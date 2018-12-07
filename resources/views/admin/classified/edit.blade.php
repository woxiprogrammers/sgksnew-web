<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 23/11/18
 * Time: 1:01 PM
 */
?>
@extends('layout.master')
@section('title','Sgks|Classified')
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
                                    <h1>Create Classified</h1>
                                </div>
                                <div class="btn red-flamingo col-md-1 pull-right" style="margin-top: 1%"><a href="/classified/manage" style="color: white">
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
                                            <form role="form" id="create-classified" class="form-horizontal" action="/classified/edit/{{$classifiedData['id']}}" method="post">
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
                                                                <label class="col-md-3 control-label">Title
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="title" name="en[title]" class="form-control " value="{{$classifiedData['title']}}" placeholder="Enter Title" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="title" name="gj[title]" class="form-control " value="{{$classifiedGujaratiData['title']}}" placeholder="Enter Title Gujarati">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Description
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <textarea id="description" name="en[description]" class="form-control " placeholder="Enter Description" required>{{$classifiedData['description']}}</textarea>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <textarea id="description" name="gj[description]" class="form-control " placeholder="Enter Description in Gujarati">{{$classifiedGujaratiData['classified_desc']}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Class Package
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" id="package" name="en[class_package_type]" required>
                                                                        <option value="{{$classifiedPackage['id']}}">{{$classifiedPackage['package_name']}}</option>
                                                                        @foreach($packages as $package)
                                                                            <option value="{{$package['id']}}">{{$package['package_name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Class Type
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" id="package_type" name="en[class_type]" required>
                                                                        <option value="{{$classifiedPackageType['id']}}">{{$classifiedPackageType['package_desc']}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">City
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control " id="city" name="en[city]" required>
                                                                        @foreach($cities as $city)
                                                                            @if($city['id'] == $classifiedData['city_id'])
                                                                                <option value="{{$city['id']}}" selected>{{$city['name']}}</option>
                                                                            @else
                                                                                <option value="{{$city['id']}}">{{$city['name']}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">Select Images :</label>
                                                                <input id="imageupload" name="imageupload[]" type="file" class="btn blue" multiple/>
                                                                <br />
                                                                <div class="row" >
                                                                    <div id="preview-image" class="row">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    @if($classifiedImages[0] != null)
                                                                        @for($index = 0;$index < count($classifiedImages); $index++)
                                                                            <div class="col-md-2">
                                                                                <div class="content">
                                                                                    <img src="{{$classifiedImages[$index]}}" style="height: 150px; width: 150px" />
                                                                                </div>
                                                                                <div class="content">
                                                                                    <span>delete image</span>
                                                                                    <input type='checkbox' class='js-switch' name="images[]" onchange='return deleteImage(this.checked,"{{$classifiedImagesId[$index]}}","{{$classifiedData['id']}}")' id='' value='{{$classifiedImages[$index]}}'/>
                                                                                </div>
                                                                            </div>
                                                                        @endfor
                                                                    @endif
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
    <script src="/assets/custom/admin/classified/create-classified-validation.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            CreateClassified.init();
        });

        $('#package').change(function(){
            var id=this.value;
            var route='/classified/get-all-package/'+id;
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#package_type').html("no record found");
                } else {
                    var str='<option value="">Please select class type</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['id']+'">'+res[i]['package_desc']+'</option>';
                    }
                    $('#package_type').html(str);
                }
            });
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
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="classified_images[]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" />' + '</div>';
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

        function deleteImage(status,imageId,classifiedId){
            if (confirm("Delete Image! are you sure ?")) {
                var route = '/classified/delete-image/' + imageId;
                $.get(route, function () {
                    var route = '/classified/edit/' + classifiedId;
                    window.location.replace(route);
                });
            }
        }
    </script>
@endsection

