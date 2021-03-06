<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 29/10/18
 * Time: 5:47 PM
 */
?>
@extends('layout.master')
@section('title','Sgks|Committee-member')
@include('partials.common.navbar')
@section('css')
    <style>
        .avatar {
            vertical-align: middle;
            width: 200px;
            height: 200px;
            border-radius: 50%;
        }
    </style>
    <style>
        .thumbimage {
            float:left;
            width:100%;
            height: 200px;
            position:relative;
            padding:5px;
            margin-left: 50%;
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
                                <div class="page-title col-md-6">
                                    <h1>Edit Member - {{$committeeName}}</h1>
                                </div>
                                <div class="btn red-flamingo col-md-1 pull-right" style="margin-top: 1%"><a href="/committee-members/manage/{{$memberData['committee_id']}}" style="color: white">
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
                                            <form role="form" id="edit-members" class="form-horizontal" action="/committee-members/edit/{{$memberData['id']}}" method="post">
                                                {!! csrf_field() !!}
                                                <div class="tab-content">
                                                    <div class="tab-pane fade in active" id="tab_general">
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-8 pull-left">
                                                                        <h4 style="margin-left: 500px">
                                                                            English
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <h4>
                                                                            Gujarati
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="col-md-2" style="text-align: center">
                                                                    <div class="col-md-12">
                                                                        @if($memberImg != null)
                                                                            <img src="{{$memberImg}}" class="avatar">
                                                                            <h4 style="font-weight: 400">{{$memberData['full_name']}}</h4>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Full Name
                                                                            <span style="color: red">*</span>
                                                                        </label>

                                                                        <div class="col-md-4">
                                                                            <input type="text" id="full_name" value="{{$memberData['full_name']}}" name="en[full_name]" class="form-control " placeholder="Enter Full Name" required>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text" id="full_name" value="{{$memberDataGujarati['full_name']}}" name="gj[full_name]" class="form-control " placeholder="Enter Full Name">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Designation
                                                                            <span style="color: red">*</span>
                                                                        </label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" id="designation"  value="{{$memberData['designation']}}" name="en[designation]" class="form-control " placeholder="Enter Designation" required></input>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Mobile
                                                                            <span style="color: red">*</span>
                                                                        </label>
                                                                        <div class="col-md-4">
                                                                            <input type="text" id="mobile_number" name="en[mobile_number]" value="{{$memberData['mobile_number']}}" class="form-control" maxlength="10" placeholder="Enter number">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label">Email ID</label>
                                                                        <div class="col-md-4">
                                                                            <input type="email" id="email_id" name="en[email_id]" value="{{$memberData['email_id']}}" class="form-control " placeholder="Enter email">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Select Images</label>
                                                                        <div class="col-md-9">
                                                                            <input id="imageupload" type="file" class="btn blue"/>
                                                                            <div id="preview-image">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3"></label>
                                                                        <div class="col-md-9" >
                                                                            <button type="submit" class="btn btn-circle"><i class="fa fa-check"></i> Submit </button>
                                                                        </div>
                                                                    </div>
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
    <script src="/assets/custom/admin/committees/edit-members-validation.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            EditMembers.init();
        });

        $("#imageupload").on('change', function () {
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#preview-image");
            image_holder.empty();
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    for (var i = 0; i < countFiles; i++) {
                        var reader = new FileReader()
                        reader.onload = function (e) {
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="profile_images" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
                            image_holder.append(imagePreview);
                        };
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[i]);
                    }
                } else {
                    alert("It doesn't supports");
                }
            } else {
                alert("Select Only images");
            }
        });

    </script>
@endsection

