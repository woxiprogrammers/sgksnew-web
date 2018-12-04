<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 28/11/18
 * Time: 2:23 PM
 */
?>
@extends('layout.master')
@section('title','Sgks|Webview')
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
                                    <h1>Create Webview</h1>
                                </div>
                                <div class="btn red-flamingo col-md-1 pull-right" style="margin-top: 1%"><a href="/webview/manage" style="color: white">
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
                                            <form role="form" id="create-webview" class="form-horizontal" action="/webview/create" method="post">
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
                                                                <label class="col-md-3 control-label">Select Webview Type
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" name="en[webviewType]" required>
                                                                        <option value="">-</option>
                                                                        @foreach($drawerWeb as $drawer)
                                                                            <option value="{{$drawer['id']}}">{{$drawer['name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Web View Description
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4" id="f3">
                                                                    <textarea id="cktext" name="en[description]" class="form-control " cols="50" rows="4" required> </textarea>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <textarea id="cktext_gj" name="gj[description]" class="form-control " cols="50" rows="4" required> </textarea>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="form-group">
                                                                <div class="col-md-3 col-md-offset-7" >
                                                                    <button id="submit" type="submit" class="btn btn-circle"><i class="fa fa-check"></i> Submit </button>
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

    <script src="/assets/custom/admin/webview/create-webview-validation.js" type="text/javascript"></script>
    <script src="/assets/ckeditor/ckeditor.js"></script>
    <script src="/assets/ckeditor/adapters/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $("textarea").ckeditor();
            //CreateWebview.init();
        });

    </script>
    <script>
        $("form").submit( function(e) {
            var messageLength = CKEDITOR.instances['cktext'].getData();
            if(messageLength == 0 ) {
                alert( 'Webview Description in English should not be empty' );
                e.preventDefault();
            }
        });
    </script>
@endsection

