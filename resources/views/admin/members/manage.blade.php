<?php
/**
 * Created by Ameya Joshi.
 * Date: 19/10/18
 * Time: 12:44 PM
 */
?>
@extends('layout.master')
@section('title','Sgks')
@include('partials.common.navbar')
@section('css')
    <style>
        .avatar {
            vertical-align: middle;
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
    </style>
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
                                    <h1>Members Listing</h1>
                                </div>
                                <div id="members_add" class="btn red-flamingo col-md-2 pull-right" style="margin-top: 1%"><a href="/member/create" style="color: white">
                                        Add Members
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
                                            {{--{!! csrf_field() !!}--}}
                                            <div class="portlet-body">
                                                <div class="table-toolbar">
                                                    <div class="row" style="text-align: right">
                                                        <div class="form-filter pull-right">
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="memberTable">
                                                    <thead>
                                                    <tr>
                                                        <th> Sr.No </th>
                                                        <th> Profile </th>
                                                        <th width="10%"> Name </th>
                                                        <th> Gujarati Name </th>
                                                        <th> Address </th>
                                                        <th> Gujarati Address </th>
                                                        <th> Mobile </th>
                                                        <th> City </th>
                                                        <th> Status <i class="fa fa-check-square"> Enable</i></th>
                                                        <th> Actions
                                                            <select class="form-control form-filter" name="filter_data">
                                                                @foreach($edit as $key=>$edi)
                                                                    <option value="{{$key}}">{{$edi}}</option>
                                                                @endforeach
                                                            </select>
                                                        </th>
                                                    </tr>
                                                    <tr class="filter">
                                                        <th></th>
                                                        <th></th>
                                                        <th> <input type="text" class="form-control form-filter" name="search_name"> </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th> <input type="text" class="form-control form-filter" name="search_mobile"> </th>
                                                        <th style="width: 15%"><input type="text" class="form-control form-filter" name="search_city"></th>
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
    <link rel="stylesheet"  href="/assets/global/plugins/datatables/datatables.min.css"/>
    <link rel="stylesheet"  href="/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css"/>
    <link rel="stylesheet"  href="/assets/global/css/app.css"/>
    <script  src="/assets/global/plugins/datatables/datatables.min.js"></script>
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/plupload/js/plupload.full.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
    <script src="/assets/custom/inventory/component-manage-datatable.js" type="text/javascript"></script>
    <script src="/assets/custom/inventory/component-reading-manage-datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>

    <script src="/assets/custom/admin/members/manage-datatable.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('#memberTable').DataTable();
        });

       function statusFolder(status,id){
           if(confirm("Change Status! are you sure ?")){
               var route='/member/change-status/'+id;
               $.get(route,function(res){
                   if(res == 200){
                       var route= "/member/manage";
                       window.location.replace(route);
                   }else{
                       alert("something went wrong");
                   }
               });
           } else {
               var route1= "/member/manage";
               window.location.replace(route1);
           }
        }
    </script>
@endsection

