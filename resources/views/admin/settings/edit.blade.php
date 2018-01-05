@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>App Settings</strong></li>
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
            <form class="form form-horizontal" action="{{ route('admin.setting.store') }}" method="post">
                {{ csrf_field() }}

                <div class="card">
                    <!-- Profile Form -->
                    <div class="card-body">
                        <!-- Location Manager -->
                        <div class="section">
                            <div class="section-title">App Settings</div>
                            <div class="section-body">
                                <p class="control-label-help">
                                    All fields are important<strong style="color: #ff0000">*</strong> and should be
                                    filled in.
                                </p>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Notification</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="checkbox checkbox-inline">
                                            <input type="checkbox"
                                                   name="is_notification"
                                                   id="is_notification" {{ isset($appSetting) && $appSetting->is_notification ? 'checked' : '' }}>
                                            <label for="is_notification">
                                                Enable?
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Help & FAQ</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea name="help_faq" id="help_faq" class="form-control" data-validation="required">{{ $appSetting->help_faq or '' }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Terms & Conditions</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea name="terms" id="terms" class="form-control"
                                                  data-validation="required">{{ $appSetting->terms or '' }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Privacy Policy</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea name="privacy" id="privacy" class="form-control"
                                                  data-validation="required">{{ $appSetting->privacy or '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-footer">
                            <div class="form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-success">Update App Settings</button>
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
        $('.hours').datetimepicker({
            format: 'LT'
        });
        $.validate({
            modules: 'location, date, security, file'
        });
    </script>
@endsection