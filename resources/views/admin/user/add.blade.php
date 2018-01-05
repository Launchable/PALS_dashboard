@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>New User</strong></li>
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
            <form class="form form-horizontal" action="{{ route('admin.user.store') }}" method="post"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <!-- Profile Form -->
                    <div class="card-body">
                        <div class="section">
                            <div class="section-title">Profile Information</div>
                            <div class="section-body">
                                <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="first-name" name="first_name"
                                               value="{{ old('first_name') }}"
                                               class="form-control"
                                               data-validation="length"
                                               data-validation-length="1-20"
                                               data-validation-error-msg="First name is required."
                                        >
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" id="last-name" name="last_name"
                                               value="{{ old('last_name') }}"
                                               class="form-control"
                                               data-validation="length"
                                               data-validation-length="1-20"
                                               data-validation-error-msg="Last name is required."
                                        >
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Phone Number</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="phone" name="phone"
                                               value="{{ old('phone') }}"
                                               class="form-control" placeholder="" data-mask="(000) 000-0000"
                                               data-validation="length"
                                               data-validation-length="1-20"
                                               data-validation-error-msg="Phone number is required."
                                        >
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('age') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Age</label>
                                    <div class="col-md-9">
                                        <select name="age" id="age" class="select2"
                                                data-validation="length"
                                                data-validation-length="1-3"
                                                data-validation-error-msg="Age is required."
                                        >
                                            <option value="">- Select Age -</option>
                                            @for($i = 18; $i <= 80; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @if ($errors->has('age'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('age') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Gender</label>
                                    <div class="col-md-9">
                                        <div class="radio radio-inline">
                                            <input type="radio" name=gender id="radio10" value="male" checked>
                                            <label for="radio10">
                                                Male
                                            </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="gender" id="radio11" value="female">
                                            <label for="radio11">
                                                Female
                                            </label>
                                        </div>
                                        @if ($errors->has('gender'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('gender') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('avatar') ? ' has-error' : '' }}">
                                    <div class="col-md-3">
                                        <label class="control-label">Profile Image</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div id="kv-avatar-errors-1" class="center-block" style="width:800px;display:none"></div>
                                        <input type="file" id="avatarUpload"
                                               name="avatar" class="file form-control" multiple
                                               data-min-file-count="1"
                                        >
                                        @if ($errors->has('avatar'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('avatar') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Login Credentials -->
                        <div class="section">
                            <div class="section-title">Login Credentials</div>
                            <div class="section-body">
                                <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">User Role</label>
                                    <div class="col-md-9">
                                        <select name="role" id="role" class="select2"
                                                data-validation="length"
                                                data-validation-length="1-20"
                                                data-validation-error-msg="Select a user role."
                                        >
                                            <option value="">- Select Role -</option>
                                            <option value="administrator">Administrator</option>
                                            <option value="manager">Manager</option>
                                            <option value="registered">Registered</option>
                                        </select>
                                        @if ($errors->has('role'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('role') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Username</label>
                                    <div class="col-md-9">
                                        <input type="text" id="username" name="username"
                                               value="{{ old('username') }}"
                                               class="form-control"
                                               data-validation="length alphanumeric"
                                               data-validation-length="3-20"
                                               data-validation-error-msg="Username is required with 3 characters minimum."
                                        >
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Email Address</label>
                                    <div class="col-md-9">
                                        <input type="text" id="email" name="email"
                                               value="{{ old('email') }}"
                                               class="form-control" data-validation="email">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" id="password" name="password"
                                               value=""
                                               class="form-control"
                                               data-validation="length" data-validation-length="min6"
                                               data-validation-error-msg="Please enter at least 6 characters."
                                        >
                                        @if ($errors->has('password'))
                                            <span
                                                class="help-block"><strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Confirm Password</label>
                                    <div class="col-md-9">
                                        <input type="password" id="password-confirm"
                                               name="password_confirmation"
                                               value=""
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer">
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Add New User</button>
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

        $("#avatarUpload").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            browseLabel: 'Browse',
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