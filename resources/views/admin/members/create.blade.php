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
                                <div class="page-title col-md-2">
                                    <h1>Create Members</h1>
                                </div>
                                <div class="btn red-flamingo col-md-1 pull-right" style="margin-top: 1%"><a href="/member/manage" style="color: white">
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
                                            <form role="form" id="create-members" class="form-horizontal" action="/member/create" method="post">
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
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">First Name
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="first_name" name="en[first_name]" class="form-control " placeholder="Enter First Name" required>
                                                                </div>
                                                                <div class="col-md-4" >
                                                                    <input type="text" id="first_name" name="gj[first_name]" class="form-control " placeholder="Enter First Name in gujarati" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Middle Name
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="middle_name" name="en[middle_name]" class="form-control " placeholder="Enter Middle Name" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="middle_name" name="gj[middle_name]" class="form-control " placeholder="Enter Middle Name in gujarati" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Last Name
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="last_name" name="en[last_name]" class="form-control " placeholder="Enter Last Name" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="last_name" name="gj[last_name]" class="form-control " placeholder="Enter Last Name in gujarati" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Address</label>
                                                                <div class="col-md-4">
                                                                    <textarea id="address" name="en[address]" class="form-control" placeholder="Enter Address"> </textarea>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <textarea id="address" name="gj[address]" class="form-control" placeholder="Enter Address in gujarati" > </textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Gender</label>
                                                                <div class="col-md-4" style="margin-top: 5px">
                                                                    <input type="radio" value="Male" name="en[gender]">Male
                                                                    <input type="radio" value="Female" name="en[gender]"> Female
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Date of birth</label>
                                                                <div class="col-md-4 date date-picker">
                                                                    <input type="text" class="form-control" id="dob" name="en[dob]" placeholder="mm/dd/yyyy">
                                                                    <button class="btn btn-sm default" type="button">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Blood Group</label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control " id="blood_group" name="en[blood_group]">
                                                                        <option value="">-</option>
                                                                        @foreach($blood_group_types as $blood_group)
                                                                            <option value="{{$blood_group['id']}}">{{$blood_group['blood_group_type']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Mobile
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="mobile_number" name="en[mobile_number]" class="form-control" placeholder="Enter number" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Email ID</label>
                                                                <div class="col-md-4">
                                                                    <input type="email" id="email_id" name="en[email_id]" class="form-control " placeholder="Enter email">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">City
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control " id="city" name="en[city]" required>
                                                                        <option value="">-</option>
                                                                        @foreach($cities as $city)
                                                                            <option value="{{$city['id']}}">{{$city['name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Latitude</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="latitude" name="en[latitude]" class="form-control " placeholder="Enter latitude">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Longitude</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="longitude" name="en[longitude]" class="form-control " placeholder="Enter longitude">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Select Images :</label>
                                                                <input id="imageupload" type="file" class="btn blue"/>
                                                                <br />
                                                                <div class="row" >
                                                                    <div id="preview-image" class="row">

                                                                    </div>
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
    <script src="/assets/custom/admin/members/create-members-validation.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            CreateMembers.init();
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
    <script>
        $('form').submit(function(){
            var address = $.trim($("#address_gj").val());
            if(address == ''){
                $('#address_gj').hide();
                $("#address_gj").prop("disabled", true);
                $('#address_gj').removeAttr('name');
            }
            var firstName = $('#first_name_gj').val();
            if(firstName == ''){
                $('#first_name_gj').hide();
                $("#first_name_gj").prop("disabled", true);
                $('#first_name_gj').removeAttr('name');
            }
            var middleName = $('#middle_name_gj').val();
            if(middleName == ''){
                $('#middle_name_gj').hide();
                $("#middle_name_gj").prop("disabled", true);
                $('#middle_name_gj').removeAttr('name');
            }
            var lastName = $('#last_name_gj').val();
            if(lastName == ''){
                $('#last_name_gj').hide();
                $("#last_name_gj").prop("disabled", true);
                $('#last_name_gj').removeAttr('name');
            }

        });
    </script>
@endsection

