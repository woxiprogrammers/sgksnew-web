<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 2/1/19
 * Time: 2:54 PM
 */
?>
@extends('layout.master')
@section('title','Sgks|Admin')
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
                                    <h1>Create Admin</h1>
                                </div>
                                <div class="btn red-flamingo col-md-1 pull-right" style="margin-top: 1%"><a href="/admin/manage" style="color: white">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="page-content">
                            <div class="container">
                                <div class="col-md-12">
                                    <!-- BEGIN VALIDATION STATES-->
                                    <div class="portlet light ">
                                        <div class="portlet-body form">
                                            <form role="form" id="edit-admin" class="form-horizontal" action="/admin/edit/{{$userData['id']}}" method="post">
                                                {!! csrf_field() !!}
                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="tab_general">
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">First Name
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="fname" class="form-control" value="{{$userData['first_name']}}" placeholder="Enter First Name" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Last Name
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="lname" class="form-control " value="{{$userData['last_name']}}" placeholder="Enter Last Name" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Mobile</label>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="mobile" class="form-control " value="{{$userData['mobile']}}" placeholder="Enter Mobile Number">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Email Id
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-6">
                                                                    <input type="email" name="email" class="form-control " value="{{$userData['email']}}" placeholder="Enter Email Id" required>
                                                                </div>
                                                                @if($alertMsg != null)
                                                                    <div class="col-md-3">
                                                                        <span style="color: red">{{$alertMsg}}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">New Password
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="password" class="form-control " placeholder="Enter New Password" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Gender</label>
                                                                <div class="col-md-4" style="margin-top: 5px">
                                                                    @if($userData['gendre'] == 'M' || $userData['gendre'] == null)
                                                                        <input type="radio" value="M" name="gender" checked>Male
                                                                        <input type="radio" value="F" name="gender"> Female
                                                                    @else
                                                                        <input type="radio" value="M" name="gender">Male
                                                                        <input type="radio" value="F" name="gender" checked> Female
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Date of birth</label>
                                                                <div class="col-md-4 date date-picker">
                                                                    <input type="text" class="form-control" id="dob" name="dob" placeholder="mm/dd/yyyy">
                                                                    <button class="btn btn-sm default" type="button">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Select Role
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" name="user-role" required>
                                                                        @foreach($userRoles as $userRole)
                                                                            @if($userData['role_id'] == $userRole['id'])
                                                                                <option value="{{$userRole['id']}}" selected>{{$userRole['name']}}</option>
                                                                            @else
                                                                                <option value="{{$userRole['id']}}">{{$userRole['name']}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Assign Cities
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" name="cities[]" multiple>
                                                                        @foreach($cities as $city)
                                                                            <option value="{{$city['id']}}">{{$city['name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <div class="col-md-3 col-md-offset-7" >
                                                                    <button type="submit" class="btn btn-circle"><i class="fa fa-check"></i> Submit </button>
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
    <script src="/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="/assets/custom/admin/manageAdmins/edit-admin-validation.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            EditAdmin.init();
        });
    </script>

@endsection

