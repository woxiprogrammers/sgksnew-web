<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 24/10/18
 * Time: 2:38 PM
 */
?>
@extends('layout.master')
@section('title','Sgks|committee')
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
                                    <h1>Create Committee</h1>
                                </div>
                                <div class="btn red-flamingo col-md-1 pull-right" style="margin-top: 1%"><a href="/committee/manage" style="color: white">
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
                                            <form role="form" id="create-committee" class="form-horizontal" action="/committee/create" method="post">
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
                                                                <label class="col-md-3 control-label">Committee Name
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="committee_name" name="en[committee_name]" class="form-control " placeholder="Enter Committee Name" required>
                                                                </div>
                                                                <div class="col-md-4" >
                                                                    <input type="text" id="committee_name_gj" name="gj[committee_name]" class="form-control " placeholder="Enter Committee Name in gujarati">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Description
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <textarea id="description" name="en[description]" class="form-control " placeholder="Enter Committee description" required></textarea>
                                                                </div>
                                                                <div class="col-md-4" >
                                                                    <textarea id="description_gj" name="gj[description]" class="form-control " placeholder="Enter Committee description in gujarati"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Country
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" id="country" name="en[country]" required>
                                                                        <option value="">-</option>
                                                                        @foreach($countries as $country)
                                                                            <option value="{{$country['id']}}">{{$country['name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">State
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                    <div class="col-md-4">
                                                                    <select class="form-control" id="state" name="en[state]" required>

                                                                    </select>
                                                                    </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">City
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                    <div class="col-md-4">
                                                                    <select class="form-control " id="city" name="en[city]" required>

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
    <script src="/assets/custom/admin/committees/create-committee-validation.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            Create.init();
        });


        $('#country').change(function(){
            var id=this.value;
            var route='/committee/get-all-states/'+id;
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#state').html("no record found");
                } else {
                    var str='<option value="">Please select state</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['id']+'">'+res[i]['name']+'</option>';
                    }
                    $('#state').html(str);
                }
            });
        });
        $('#state').change(function(){
            var id=this.value;
            var route='/committee/get-all-cities/'+id;
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#city').html("no record found");
                } else {
                    var str='<option value="">Please select city</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['id']+'">'+res[i]['name']+'</option>';
                    }
                    $('#city').html(str);
                }
            });
        });
    </script>
    <script>
        $('form').submit(function(){
            var committee_name = $.trim($("#committee_name_gj").val());
            if(committee_name == ''){
                $('#committee_name_gj').hide();
                $("#committee_name_gj").prop("disabled", true);
                $('#committee_name_gj').removeAttr('name');
            }
            var description = $('#description_gj').val();
            if(description == ''){
                $('#description_gj').hide();
                $("#description_gj").prop("disabled", true);
                $('#description_gj').removeAttr('name');
            }

        });
    </script>
@endsection

