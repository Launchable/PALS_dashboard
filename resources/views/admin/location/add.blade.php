@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>New Location</strong></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @include('layouts.common.navbar')
                </ul>
            </div>
        </div>
    </nav>

    @include('layouts.common.flash')

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <form class="form form-horizontal" action="{{ route('admin.location.store') }}" method="post"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <!-- Profile Form -->
                    <div class="card-body">
                        <!-- Location Manager -->
                        <div class="section">
                            <div class="section-title">Location Manager(s)</div>
                            <div class="section-body">
                                <p class="control-label-help">
                                    All fields are important<strong style="color: #ff0000">*</strong> and should be
                                    filled in.
                                </p>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Select Manager(s)<strong style="color: #ff0000">*</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="users[]" id="user_id" class="form-control select2"
                                                data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="At least one manager is required."
                                                multiple>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="section">
                            <div class="section-title">Location Information</div>
                            <div class="section-body">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Name<strong style="color: #ff0000">*</strong></label>
                                    <div class="col-md-9">
                                        <input type="text" id="name" name="name"
                                               value="{{ old('name') }}"
                                               class="form-control"
                                               data-validation="length"
                                               data-validation-length="min1"
                                               data-validation-error-msg="Name is required."
                                        >
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-9">
                                        <textarea id="description" name="description"
                                                  class="form-control">{{old('description')}}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                        @endif

                                        <div class="form-group">
                                            <div class="col-md-9">
                                                <div id="kv-avatar-errors-1" class="center-block"
                                                     style="width:800px;display:none"></div>
                                                <input type="file" id="avatarUpload"
                                                       name="avatar" class="file form-control" multiple
                                                       data-min-file-count="1">
                                                <label for="avatarUpload" class="control-label"></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Address<strong style="color: #ff0000">*</strong></label>
                                    <div class="col-md-9">
                                        <textarea id="address" name="address"
                                                  class="form-control"
                                                  data-validation="length"
                                                  data-validation-length="min1"
                                                  data-validation-error-msg="Address is required"
                                        >{{old('address')}}</textarea>
                                        <p class="control-label-help">
                                            Generates latitude and longitude when correct address is entered.
                                        </p>
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>

                                <label class="col-md-3"></label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Latitude</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="latitude" class="form-control" id="latitude"
                                                   value="{{old('latitude')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Longitude</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="longitude" class="form-control" id="longitude"
                                                   value="{{old('longitude')}}">
                                        </div>
                                    </div>
                                </div>


                                <!-- Contact Number -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Contact Number<strong style="color: #ff0000">*</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="phone" name="phone"
                                               value="{{ old('phone') }}"
                                               class="form-control" data-mask="(000) 000-0000"
                                               data-validation="length"
                                               data-validation-length="min1"
                                               data-validation-error-msg="Phone number is required"
                                        >
                                    </div>
                                </div>

                                <!-- Types -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Establishment Type<strong style="color: #ff0000">*</strong></label>
                                        <p class="control-label-help">( Choose multiple types if needed)</p>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="types[]" id="types" class="form-control" multiple
                                                data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="At least one establishment type is required."
                                        >
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Operation Hours -->
                        <div class="section">
                            <div class="section-title">Operation Hours</div>
                            <div class="section-body">
                                <div class="card card-tab card-mini">
                                    <div class="card-header">
                                        <ul class="nav nav-tabs">
                                            <li role="tab1" class="active">
                                                <a href="#monday" aria-controls="tab1" role="tab"
                                                   data-toggle="tab">Monday</a>
                                            </li>
                                            <li role="tab2">
                                                <a href="#tuesday" aria-controls="tab2" role="tab"
                                                   data-toggle="tab">Tuesday</a>
                                            </li>
                                            <li role="tab3">
                                                <a href="#wednesday" aria-controls="tab3" role="tab" data-toggle="tab">Wednesday</a>
                                            </li>
                                            <li role="tab4">
                                                <a href="#thursday" aria-controls="tab4" role="tab" data-toggle="tab">Thursday</a>
                                            </li>
                                            <li role="tab5">
                                                <a href="#friday" aria-controls="tab5" role="tab"
                                                   data-toggle="tab">Friday</a>
                                            </li>
                                            <li role="tab6">
                                                <a href="#saturday" aria-controls="tab6" role="tab" data-toggle="tab">Saturday</a>
                                            </li>
                                            <li role="tab7">
                                                <a href="#sunday" aria-controls="tab7" role="tab"
                                                   data-toggle="tab">Sunday</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body tab-content no-padding">
                                        <div role="tabpanel" class="tab-pane active" id="monday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[0][week_day]" value="0">
                                                <label class="control-label col-md-1">Opens At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[0][opens_at]" class="hours form-control">
                                                </div>
                                                <label class="control-label col-md-1">Closes At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[0][closes_at]" class="hours form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tuesday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[1][week_day]" value="1">
                                                <label class="control-label col-md-1">Opens At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[1][opens_at]" class="hours form-control">
                                                </div>
                                                <label class="control-label col-md-1">Closes At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[1][closes_at]" class="hours form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="wednesday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[2][week_day]" value="2">
                                                <label class="control-label col-md-1">Opens At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[2][opens_at]" class="hours form-control">
                                                </div>
                                                <label class="control-label col-md-1">Closes At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[2][closes_at]" class="hours form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="thursday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[3][week_day]" value="3">
                                                <label class="control-label col-md-1">Opens At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[3][opens_at]" class="hours form-control">
                                                </div>
                                                <label class="control-label col-md-1">Closes At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[3][closes_at]" class="hours form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="friday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[4][week_day]" value="4">
                                                <label class="control-label col-md-1">Opens At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[4][opens_at]" class="hours form-control">
                                                </div>
                                                <label class="control-label col-md-1">Closes At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[4][closes_at]" class="hours form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="saturday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[5][week_day]" value="5">
                                                <label class="control-label col-md-1">Opens At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[5][opens_at]" class="hours form-control">
                                                </div>
                                                <label class="control-label col-md-1">Closes At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[5][closes_at]" class="hours form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="sunday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[6][week_day]" value="6">
                                                <label class="control-label col-md-1">Opens At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[6][opens_at]" class="hours form-control">
                                                </div>
                                                <label class="control-label col-md-1">Closes At:</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="days[6][closes_at]" class="hours form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success">Add New Location</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        $.validate({
            modules : 'location, date, security, file'
        });

        $('#types').select2({
            placeholder: 'Choose Types'
        });

        $('.hours').datetimepicker({
            format: 'LT'
        });

        $("#avatarUpload").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            browseLabel: 'Upload Image',
            removeLabel: '',
            //browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors-1',
            msgErrorClass: 'alert alert-block alert-danger',
            //defaultPreviewContent: '<img src="https://robohash.org/default.jpg" alt="Your Avatar" style="width:250px">',
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });

        $('#address').blur(function (e) {
            var geocoder = new google.maps.Geocoder();
            var address = $(this).val();
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#latitude').val(results[0].geometry.location.lat());
                    $('#longitude').val(results[0].geometry.location.lng());
                    // results[0].geometry.location.longitude
                }
            });
        });
    </script>
@endsection