@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>New Event</strong></li>
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
            <form class="form form-horizontal" action="{{ route('admin.event.store') }}" method="post"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <!-- Profile Form -->
                    <div class="card-body">
                        <!-- Location Manager -->
                        <div class="section">
                            <div class="section-title">Event</div>
                            <div class="section-body">
                                <p class="control-label-help">
                                    All fields are important<strong style="color: #ff0000">*</strong> and should be
                                    filled in.
                                </p>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Select Location<strong style="color: #ff0000">*</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="location_id" id="location_id" class="form-control select2"
                                                data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="Please select a location to associate the event."
                                        >
                                            <option value="">-- Choose a location--</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}
                                                    ({{ $location->phone }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="section">
                            <div class="section-title">Event Information</div>
                            <div class="section-body">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Image<strong style="color: #ff0000">*</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div id="kv-avatar-errors-1" class="center-block"
                                             style="width:800px;display:none"></div>
                                        <input type="file" id="avatarUpload"
                                               name="image" class="file form-control" multiple
                                               data-min-file-count="1">
                                        <label for="avatarUpload" class="control-label"></label>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Title<strong style="color: #ff0000">*</strong></label>
                                    <div class="col-md-9">
                                        <input type="text" id="title" name="title"
                                               value="{{ old('title') }}"
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
                                    <label class="col-md-3 control-label">Description<strong style="color: #ff0000">*</strong></label>
                                    <div class="col-md-9">
                                        <textarea id="description" name="description"
                                                  class="form-control"
                                                  data-validation="length"
                                                  data-validation-length="min1"
                                                  data-validation-error-msg="Please enter a short description of the event."
                                        >{{old('description')}}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Date Time -->
                                <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Date And Time<strong style="color: #ff0000">*</strong></label>
                                    <div class="col-md-9">
                                        <input type="text" name="date" value="{{ old('date') }}"
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
                                        <button type="submit" class="btn btn-success">Add New Event</button>
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
    </script>
@endsection