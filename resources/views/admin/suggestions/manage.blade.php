<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 5/12/18
 * Time: 12:43 PM
 */
?>
@extends('layout.master')
@section('title','Sgks|Suggestions')
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
                                    <h1>Suggestions Listing</h1>
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
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="suggestionTable">
                                                    <thead>
                                                    <tr>
                                                        <th> Sr.No </th>
                                                        <th> City </th>
                                                        <th> Type </th>
                                                        <th> Category </th>
                                                        <th> Description </th>
                                                        <th> Date </th>
                                                        <th> Actions </th>
                                                    </tr>
                                                    <tr class="filter">
                                                        <th></th>
                                                        <th> <input type="text" class="form-control form-filter" name="search_city"> </th>
                                                        <th>
                                                            <select class="form-control form-filter" name="sugg_type">
                                                                <option value="all">All</option>
                                                            @foreach($suggestionTypes as $suggestionType)
                                                                <option value="{{$suggestionType['id']}}">{{$suggestionType['name']}}</option>
                                                            @endforeach
                                                            </select>
                                                        </th>
                                                        <th>
                                                            <select class="form-control form-filter" name="sugg_cat">
                                                                <option value="all">All</option>
                                                                @foreach($suggestionCategories as $suggestionCategory)
                                                                    <option value="{{$suggestionCategory['id']}}">{{$suggestionCategory['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </th>
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

    <script src="/assets/custom/admin/suggestion/suggestion-listing.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('#suggestionTable').DataTable();
        });

    </script>
@endsection

