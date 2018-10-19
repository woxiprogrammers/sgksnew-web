<?php
/**
 * Created by Ameya Joshi.
 * Date: 19/10/18
 * Time: 1:01 PM
 */
?>
@extends('layout.master')
@section('title','Sgks')
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
                                <div class="page-title">
                                    <h1>Create Members</h1>
                                </div>
                            </div>
                        </div>
                        <div class="page-content">
                            <div class="container">
                                <div class="col-md-12">
                                    <!-- BEGIN VALIDATION STATES-->
                                    <div class="portlet light ">
                                        <div class="portlet-body form">
                                            <form role="form" id="create-product" class="form-horizontal" action="/members/create" method="post">
                                                {!! csrf_field() !!}
                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="tab_general">
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">First Name</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="first_name" name="first_name" class="form-control " placeholder="Enter First Name">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Middle Name</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="middle_name" name="middle_name" class="form-control " placeholder="Enter Middle Name">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Last Name</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="last_name" name="last_name" class="form-control " placeholder="Enter Last Name">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Gender</label>
                                                                <div class="col-md-4">
                                                                    <input type="radio" value="male" name="gender">Male
                                                                    <input type="radio" value="female" name="gender"> Female
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Date of birth</label>
                                                                <div class="col-md-4">
                                                                    <input type="date" id="dob" name="dob" class="form-control">                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Blood Group</label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control " id="blood_group" name="category_id">
                                                                        @foreach($blood_group_types as $blood_group)
                                                                            <option value="{{$blood_group['id']}}">{{$blood_group['blood_group_type']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Mobile</label>
                                                                <div class="col-md-4">
                                                                    <input type="number" id="mobile_number" name="mobile_number" class="form-control " placeholder="Enter number">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Email ID</label>
                                                                <div class="col-md-4">
                                                                    <input type="email" id="email_id" name="email_id" class="form-control " placeholder="Enter email">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Email ID</label>
                                                                <div class="col-md-4">
                                                                    <input type="email" id="email_id" name="email_id" class="form-control " placeholder="Enter email">
                                                                </div>
                                                            </div>


                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </form>
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
    <script src="/assets/custom/admin/dashboard/manage-datatable.js" type="text/javascript"></script>

    <script>

    </script>
@endsection

