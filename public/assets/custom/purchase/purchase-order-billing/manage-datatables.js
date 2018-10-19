var PurchaseOrderListing = function () {
    var handleOrders = function () {
        var grid = new Datatable();
        grid.init({
            src: $("#purchaseOrderBillTable"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var vendor_name = $('#vendor_name').val();
                    var system_bill_number = $('#system_bill_number').val();
                    var bill_number = $('#bill_number').val();
                    var project_name = $('#project_name').val();


                    // Total over all pages
                    $.ajax({
                        url: "/purchase/purchase-order-bill/listing?_token="+$("input[name='_token']").val(), // ajax source
                        type: 'POST',
                        data :{
                            "get_total" : true,
                            "vendor_name" : vendor_name,
                            "system_bill_number" : system_bill_number,
                            "bill_number" : bill_number,
                            "project_name" : project_name

                        },
                        success: function(result){
                            total = result['total'];

                            // Total over this page
                            pageTotal = api
                                .column( 9, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Update footer
                            $( api.column( 9 ).footer() ).html(
                                customRound(pageTotal) +' ( '+ total +' total)'
                            );

                            billtotal = result['billtotal'];

                            // Total over this page
                            pageBillTotal = api
                                .column( 10, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Update footer
                            $( api.column( 10 ).footer() ).html(
                                customRound(pageBillTotal) +' ( '+ billtotal +' total)'
                            );

                            paidtotal = result['paidtotal'];

                            // Total over this page
                            pagePaidTotal = api
                                .column( 11, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Update footer
                            $( api.column( 11 ).footer() ).html(
                                customRound(pagePaidTotal) +' ( '+ paidtotal +' total)'
                            );

                            /*balancetotal = result['balancetotal'];

                            // Total over this page
                            pageBalanceTotal = api
                                .column( 9, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Update footer
                            $( api.column( 9 ).footer() ).html(
                                pageBalanceTotal +' ( '+ balancetotal +' total)'
                            );*/

                        }});
                },

                "lengthMenu": [
                    [50, 100, 150],
                    [50, 100, 150] // change per page values here
                ],
                "pageLength": 50, // default record count per page
                "ajax": {
                    "url": "/purchase/purchase-order-bill/listing?_token="+$("input[name='_token']").val(), // ajax source
                },
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            }
        });
        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });
    }
    return {

        //main function to initiate the module
        init: function () {
            handleOrders();
        }
    };
}();
jQuery(document).ready(function() {
    PurchaseOrderListing.init();
    $(".search_filter").on('keyup', function(){
        $(".filter-submit").trigger('click');
    });
});