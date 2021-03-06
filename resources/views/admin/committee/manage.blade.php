<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 24/10/18
 * Time: 2:36 PM
 */
?>
@extends('layout.master')
@section('title','Sgks|Committee')
@include('partials.common.navbar')
@section('css')
    <link href="/assets/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="page-wrapper">
        <div class="page-wrapper-row full-height">
            <div class="page-wrapper-middle">
                <!-- BEGIN CONTAINER -->
                <div class="page-container">
                    <!-- BEGIN CONTENT -->
                    <div class="page-content-wrapper">
                        <div class="page-head">
                            <div class="container">
                                <!-- BEGIN PAGE TITLE -->

                                <div class="page-title col-md-2">
                                    <h1>Committee Listing</h1>
                                </div>
                                <div id="committee_add" class="btn red-flamingo col-md-2 pull-right" style="margin-top: 1%"><a href="/committee/create/" style="color: white">
                                    Add Committee
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="page-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                        <div class="portlet light ">
                                            {!! csrf_field() !!}
                                            <div class="portlet-body">
                                                <div class="table-toolbar">
                                                    <div class="row" style="text-align: right">
                                                        <div class="col-md-12">
                                                            <div class="btn-group">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="committeeTable">
                                                    <thead>
                                                    <tr>
                                                        <th> Sr.No </th>
                                                        <th style="width: 20%"> Name </th>
                                                        <th> Gujarati Name </th>
                                                        <th> Description </th>
                                                        <th> Gujarati Description </th>
                                                        <th> City </th>
                                                        <th> Date </th>
                                                        <th> Total Members </th>
                                                        <th> Status
                                                            <i class="fa fa-check-square"> Enable</i>
                                                        </th>
                                                        <th> Action </th>
                                                    </tr>
                                                    <tr class="filter">
                                                        <th></th>
                                                        <th style="width: 20%"> <input type="text" class="form-control form-filter" name="search_committee"> </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="width: 20%"> <input type="text" class="form-control form-filter" name="search_city"> </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            <button class="btn btn-xs blue filter-submit"> Search <i class="fa fa-search"></i> </button>
                                                            <button class="btn btn-xs default filter-cancel"> Reset <i class="fa fa-undo"></i> </button>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END CONTAINER -->
@endsection
@section('javascript')
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css"/>
    <link rel="stylesheet"  href="/assets/global/plugins/datatables/datatables.min.css"/>
    <script  src="/assets/global/plugins/datatables/datatables.min.js"></script>
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

    <script src="/assets/custom/admin/committees/manage-committee-listing.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
           $('#committeeTable').DataTable();
        });
        function statusFolder(status,id){
            if(confirm("Change Status! are you sure ?")){
                var route='/committee/change-status/'+id;
                $.get(route,function(){
                        var route= "/committee/manage";
                        window.location.replace(route);
                });
            } else {
                var route1= "/committee/manage";
                window.location.replace(route1);
            }
        }
    </script>
@endsection

