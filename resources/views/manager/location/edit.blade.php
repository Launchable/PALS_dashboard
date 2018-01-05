@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>Edit Location</strong></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @include('layouts.common.navbar')
                </ul>
            </div>
        </div>
    </nav>

    @include('layouts.common.flash')

    <div class="row">

        <div class="col-sm-4 col-xs-12">
            <div class="card">
                <div class="card-header">
                    Picture
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="thumbnail">
                                <img class="profile-img" style="width: 100%;height: 100%;"
                                     src="/uploads/locations/{{ $location->image }}">
                                <div class="caption">
                                    <div>
                                        <button class="btn btn-default" id="uploadAvatar"
                                                data-toggle="modal" data-target="#modalUploadAvatar">Change
                                        </button>
                                    </div>
                                </div>

                                <!-- Upload Modal -->
                                <div class="modal fade" id="modalUploadAvatar" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title">Update Location Picture</h4>
                                            </div>
                                            <form action="{{ route('manager.location.image.update', [$location->id]) }}"
                                                  method="post"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $location->id }}">
                                                <input type="hidden" name="isAvatar" value="1">
                                                <div class="modal-body">
                                                    <input type="file" id="avatarUpload"
                                                           name="avatar" class="file form-control" multiple
                                                           data-min-file-count="1">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                            data-dismiss="modal">Close
                                                    </button>
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

        <div class="col-sm-8 col-xs-12">
            <form class="form form-horizontal" action="{{ route('manager.location.update', $location->id) }}"
                  method="post"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $location->id }}">
                <div class="card">
                    <!-- Profile Form -->
                    <div class="card-body">
                        <input type="hidden" name="user_id" value="{{ $location->user_id }}">

                        <!-- Location Manager -->
                        <div class="section">
                            <div class="section-title">Location Manager</div>
                            <div class="section-body">
                                <p class="control-label-help">
                                    All fields are important<strong style="color: #ff0000">*</strong> and should be
                                    filled in.
                                </p>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Select Manager(s)</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="users[]" id="user_id" class="form-control select2"
                                                data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="At least one manager is required."
                                                multiple>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}"
                                                @foreach($location->users as $item)
                                                    {{ $item->id == $user->id ? 'selected' : '' }}
                                                    @endforeach>{{$user->full_name}}</option>
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
                                    <label class="col-md-3 control-label">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="name" name="name"
                                               value="{{ $location->name }}"
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
                                        <textarea id="description"
                                                  name="description"
                                                  class="form-control">{{ $location->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                        @endif

                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Address</label>
                                    <div class="col-md-9">
                                        <textarea id="address" name="address"
                                                  class="form-control"
                                                  data-validation="length"
                                                  data-validation-length="min1"
                                                  data-validation-error-msg="Address is required"
                                        >{{ $location->address }}</textarea>
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
                                            <input type="text" name="latitude"
                                                   class="form-control" id="latitude"
                                                   value="{{ $location->latitude }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Longitude</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="longitude" class="form-control" id="longitude"
                                                   value="{{ $location->longitude }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Contact Number</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="phone" name="phone"
                                               value="{{ $location->phone }}"
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
                                        <label class="control-label">Establishment Type</label>
                                        <p class="control-label-help">( Choose multiple types if needed)</p>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="types[]" id="types" class="form-control" multiple
                                                data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="At least one establishment type is required."
                                        >
                                            @foreach($types as $type)
                                                <option value="{{$type->id}}"
                                                @foreach($location->types as $item)
                                                    {{ $item->id == $type->id ? 'selected' : '' }}
                                                    @endforeach>{{$type->name}}</option>
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
                                                @foreach($operations as $operation)
                                                    @if($operation['week_day'] == 0)
                                                        <input type="hidden" name="days[0][id]"
                                                               value="{{ $operation->id }}">
                                                        <label class="control-label col-md-1">Opens At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[0][opens_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['opens_at'] }}">
                                                        </div>
                                                        <label class="control-label col-md-1">Closes At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[0][closes_at]"
                                                                   class="hours form-control"
                                                                   value="{{$operation['closes_at']}}">
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="tuesday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[1][week_day]" value="1">
                                                @foreach($operations as $operation)
                                                    @if($operation['week_day'] == 1)
                                                        <input type="hidden" name="days[1][id]"
                                                               value="{{ $operation->id }}">
                                                        <label class="control-label col-md-1">Opens At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[1][opens_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['opens_at'] }}">
                                                        </div>
                                                        <label class="control-label col-md-1">Closes At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[1][closes_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['closes_at'] }}">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="wednesday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[2][week_day]" value="2">
                                                @foreach($operations as $operation)
                                                    @if($operation['week_day'] == 2)
                                                        <input type="hidden" name="days[2][id]"
                                                               value="{{ $operation->id }}">
                                                        <label class="control-label col-md-1">Opens At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[2][opens_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['opens_at'] }}">
                                                        </div>
                                                        <label class="control-label col-md-1">Closes At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[2][closes_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['closes_at'] }}">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="thursday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[3][week_day]" value="3">
                                                @foreach($operations as $operation)
                                                    @if($operation['week_day'] == 3)
                                                        <input type="hidden" name="days[3][id]"
                                                               value="{{ $operation->id }}">
                                                        <label class="control-label col-md-1">Opens At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[3][opens_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['opens_at'] }}">
                                                        </div>
                                                        <label class="control-label col-md-1">Closes At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[3][closes_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['closes_at'] }}">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="friday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[4][week_day]" value="4">
                                                @foreach($operations as $operation)
                                                    @if($operation['week_day'] == 4)
                                                        <input type="hidden" name="days[4][id]"
                                                               value="{{ $operation->id }}">
                                                        <label class="control-label col-md-1">Opens At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[4][opens_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['opens_at'] }}">
                                                        </div>
                                                        <label class="control-label col-md-1">Closes At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[4][closes_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['closes_at'] }}">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="saturday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[5][week_day]" value="5">
                                                @foreach($operations as $operation)
                                                    @if($operation['week_day'] == 5)
                                                        <input type="hidden" name="days[5][id]"
                                                               value="{{ $operation->id }}">
                                                        <label class="control-label col-md-1">Opens At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[5][opens_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['opens_at'] }}">
                                                        </div>
                                                        <label class="control-label col-md-1">Closes At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[5][closes_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['closes_at'] }}">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="sunday">
                                            <div class="form-group">
                                                <input type="hidden" name="days[6][week_day]" value="6">
                                                @foreach($operations as $operation)
                                                    @if($operation['week_day'] == 6)
                                                        <input type="hidden" name="days[6][id]"
                                                               value="{{ $operation->id }}">
                                                        <label class="control-label col-md-1">Opens At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[6][opens_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['opens_at'] }}">
                                                        </div>
                                                        <label class="control-label col-md-1">Closes At:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="days[6][closes_at]"
                                                                   class="hours form-control"
                                                                   value="{{ $operation['closes_at'] }}">
                                                        </div>
                                                    @endif
                                                @endforeach
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
                                        <button type="submit" class="btn btn-primary">Update Location</button>
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

        $("#avatarUpload").fileinput({showCaption: false, allowedFileExtensions: ['jpg', 'png', 'gif']});

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