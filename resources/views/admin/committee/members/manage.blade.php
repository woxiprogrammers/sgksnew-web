<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 29/10/18
 * Time: 10:22 AM
 */
?>
@extends('layout.master')
@section('title','Sgks|Committee-member')
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
                                    <h1>Members Listing</h1>
                                </div>
                                <div class="btn red-flamingo col-md-1 pull-right" style="margin-top: 1%"><a href="/committee/manage" style="color: white">
                                        Back
                                    </a>
                                </div>
                                <div id="members_add" class="btn red-flamingo col-md-2 pull-right" style="margin-top: 1%"><a href="/committee-members/create/{{$id}}" style="color: white">
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
                                            <div class="portlet-body">
                                                <div class="table-toolbar">
                                                    <div class="row" style="text-align: right">
                                                        <div class="col-md-12">
                                                            <div class="btn-group">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="memberTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Sr.No</th>
                                                        <th style="width: 20%"> Name </th>
                                                        <th> Gujarati Name </th>
                                                        <th> Mobile </th>
                                                        <th> Email </th>
                                                        <th> Status
                                                            <i class="fa fa-check-square"> Enable</i>
                                                        </th>
                                                        <th> Actions </th>
                                                    </tr>
                                                    <tr class="filter">
                                                        <th><input type="hidden" id="committee-id" value="{{$id}}" /></th>
                                                        <th style="width: 20%"> <input type="text" class="form-control form-filter" name="search_name"> </th>
                                                        <th></th>
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
    {{--for this page--}}


    <script src="/assets/custom/admin/committees/committee-members-listing.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('#memberTable').DataTable();
        });

        function statusFolder(status,id){
            if(confirm("Change Status! are you sure ?")){
                var route='/committee-members/change-status/'+id;
                $.get(route,function(){
                    var route= "/committee-members/manage";
                    window.location.replace(route);
                });
            }
        }
    </script>
@endsection

