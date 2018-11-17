<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 5/11/18
 * Time: 3:13 PM
 */
?>
@extends('layout.master')
@section('title','Sgks|Events')
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
                                <div class="page-title">
                                    <h1>Edit Event</h1>
                                </div>
                            </div>
                        </div>
                        <div class="page-content">
                            <div class="container">
                                <div class="col-md-12">
                                    <!-- BEGIN VALIDATION STATES-->
                                    <div class="portlet light ">
                                        <div class="portlet-body form">
                                            <form role="form" id="edit-events" class="form-horizontal" action="/event/edit/{{$eventData['id']}}" method="post">
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
                                                                <label class="col-md-3 control-label">Event Name
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="event_name" value="{{$eventData['event_name']}}" name="en[event_name]" class="form-control " placeholder="Enter Event Name" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="event_name" value="{{$eventDataGujarati['event_name']}}" name="gj[event_name]" class="form-control " placeholder="Enter Event Name in Gujarati">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Description
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <textarea id="description" name="en[description]"  class="form-control " placeholder="Enter Event Description" required>{{$eventData['description']}}</textarea>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <textarea id="description" name="gj[description]" class="form-control " placeholder="Enter Event Description in Gujarati">{{$eventDataGujarati['description']}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Venue
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="venue" value="{{$eventData['venue']}}" name="en[venue]" class="form-control " placeholder="Enter Event Venue" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="text" id="venue" value="{{$eventDataGujarati['venue']}}" name="gj[venue]" class="form-control " placeholder="Enter Event Venue in Gujarati">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Country
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" id="country" name="en[country]" required>
                                                                        <option>{{$countryName}}</option>
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
                                                                        <option>{{$stateName}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">City
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control " id="city" value="" name="en[city]" required>
                                                                        <option value="{{$cityId}}">{{$cityName}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">Start Date
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="date" id="start_date" value="{{$eventData['start_date']}}" name="en[start_date]" class="form-control " placeholder="" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label">End Date
                                                                    <span style="color: red">*</span>
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input type="date" id="end_date" value="{{$eventData['end_date']}}" name="en[end_date]" class="form-control " placeholder="" required>
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
                                                                    @if($eventImages[0] != null)
                                                                    @for($index = 0;$index < count($eventImages); $index++)
                                                                    <img src="{{$eventImages[$index]}}" style="height: 150px; width: 150px" />
                                                                        <input type='checkbox' class='js-switch' name="images[]" onchange='return deleteImage(this.checked,"{{$eventImagesId[$index]}}","{{$eventData['id']}}")' id='' value='{{$eventImages[$index]}}'/>
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
    <script src="/assets/custom/admin/events/create-event-validation.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            CreateEvents.init();
        });


        $('#country').change(function(){
            var id=this.value;
            var route='/event/get-all-states/'+id;
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
            var route='/event/get-all-cities/'+id;
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
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="event_images[]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        function deleteImage(status,imageId,eventId){
            if (confirm("Delete Image! are you sure ?")) {
                var route = '/event/delete-image/' + imageId;
                $.get(route, function () {
                    var route = '/event/edit/' + eventId;
                    window.location.replace(route);
                });
            }
        }
    </script>
@endsection

