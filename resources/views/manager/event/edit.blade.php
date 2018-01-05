@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>Edit Event</strong></li>
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
                    Event Image
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="thumbnail">
                                <img class="profile-img" style="width: 100%;height: 100%;"
                                     src="/uploads/events/{{ $event->image }}">
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
                                                <h4 class="modal-title">Update Event Image</h4>
                                            </div>
                                            <form action="{{ route('manager.event.image.update', [$event->id]) }}"
                                                  method="post"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $event->id }}">
                                                <input type="hidden" name="isAvatar" value="1">
                                                <div class="modal-body">
                                                    <input type="file" id="avatarUpload"
                                                           name="image" class="file form-control" multiple
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
            <form class="form form-horizontal" action="{{ route('manager.event.update', $event->id) }}"
                  method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $event->id }}">
                <div class="card">
                    <!-- Profile Form -->
                    <div class="card-body">
                        <!-- Location Manager -->
                        <div class="section">
                            <div class="section-title">Drink</div>
                            <div class="section-body">
                                <p class="control-label-help">
                                    All fields are important<strong style="color: #ff0000">*</strong> and should be
                                    filled in.
                                </p>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Change Location</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="location_id" id="location_id" class="form-control select2"
                                                data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="Please select a location to associate the event."
                                        >
                                            <option value="">-- Choose a location--</option>
                                            @foreach($locations as $location)
                                                <option
                                                    value="{{ $location->id }}"
                                                    {{$location->id == $event->location_id ? 'selected' : ''}}>
                                                    {{ $location->name }} - {{ $location->phone }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="section">
                            <div class="section-title">Drink Information</div>
                            <div class="section-body">

                                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Title</label>
                                    <div class="col-md-9">
                                        <input type="text" id="title" name="title"
                                               value="{{ $event->title }}"
                                               class="form-control"
                                               data-validation="length"
                                               data-validation-length="min1"
                                               data-validation-error-msg="Event title is required."
                                        >
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-9">
                                        <textarea id="description" name="description"
                                                  class="form-control"
                                                  data-validation="length"
                                                  data-validation-length="min1"
                                                  data-validation-error-msg="Please enter a short description of the event."
                                        >{{ $event->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Date Time -->
                                <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Date And Time</label>
                                    <div class="col-md-9">
                                        <input type="text" name="date" value="{{ date('m/d/Y H:i:s', strtotime($event->date)) }}"
                                               class="form-control" id="date"
                                               data-validation="length"
                                               data-validation-length="min1"
                                               data-validation-error-msg="Event date and time is required."
                                        >
                                        @if ($errors->has('date'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('date') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success">Update Cover</button>
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

        $('#date').datetimepicker();

        $("#avatarUpload").fileinput({showCaption: false, allowedFileExtensions: ['jpg', 'png', 'gif']});
    </script>
@endsection