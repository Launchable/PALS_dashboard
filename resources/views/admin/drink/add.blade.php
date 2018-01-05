@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>New Drink</strong></li>
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
            <form class="form form-horizontal" action="{{ route('admin.drink.store') }}" method="post">
                {{ csrf_field() }}
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
                                        <label class="control-label">Select Location<strong
                                                style="color: #ff0000">*</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="location_id" id="location_id" class="form-control select2"
                                                data-validation="length"
                                                data-validation-length="min1"
                                                data-validation-error-msg="Please select a location to associate the drink."
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
                            <div class="section-title">Drink Information</div>
                            <div class="section-body">
                                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Title<strong style="color: #ff0000">*</strong></label>
                                    <div class="col-md-9">
                                        <input type="text" id="title" name="title"
                                               value="{{ old('title') }}"
                                               class="form-control"
                                               data-validation="length"
                                               data-validation-length="min1"
                                               data-validation-error-msg="Please enter the drink title."
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
                                                  class="form-control">{{old('description')}}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Price<strong style="color: #ff0000">*</strong></label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-addon">$</div>
                                            <input type="text" name="price" value="{{ old('price') }}"
                                                   class="form-control" id="price"
                                                   data-validation="number length"
                                                   data-validation-allowing="float"
                                                   data-validation-length="min1"
                                                   data-validation-error-msg="Please enter drink price.">
                                            @if ($errors->has('price'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="control-label-help">
                                            Override above price base on time. Leave blank if not applicable.
                                        </p>
                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label">Start Time</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="start_time" class="hours form-control"
                                                       id="start_time"
                                                       value="{{old('start_time')}}" data-mask="00:00">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label">End Time</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" name="end_time" class="hours form-control"
                                                       id="end_time"
                                                       value="{{old('end_time')}}" data-mask="00:00">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3">
                                                <label class="control-label">Price</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="text" name="timed_price"
                                                           value="{{ old('timed_price') }}"
                                                           class="form-control" id="timed_price"
                                                    >
                                                    @if ($errors->has('time_price'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('time_price') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Promo Code -->
                        <div class="form-group">
                            <div class="col-md-3">
                                <label class="control-label">Promo Code</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="promo_code" name="promo_code"
                                       value="{{ old('promo_code') }}"
                                       class="form-control">
                            </div>
                        </div>

                        <!-- Types -->
                        <div class="form-group">
                            <div class="col-md-3">
                                <label class="control-label">Drink Type<strong
                                        style="color: #ff0000">*</strong></label>
                            </div>
                            <div class="col-md-9">
                                <select name="type_id" id="type_id" class="form-control select2"
                                        data-validation="length"
                                        data-validation-length="min1"
                                        data-validation-error-msg="Please select the drink type."
                                >
                                    <option value="">-- Select Drink Type -</option>
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Stocks -->
                        <div class="form-group">
                            <div class="col-md-3">
                                <label class="control-label">Stocks</label>
                                <p class="control-label-help">Leave blank if there is unlimited stocks</p>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="stocks" name="stocks"
                                       value="{{ old('stocks') }}"
                                       class="form-control">
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="form-group">
                            <div class="col-md-3">
                                <label class="control-label">Settings</label>
                            </div>
                            <div class="col-md-9">
                                <div class="checkbox checkbox-inline">
                                    <input type="checkbox" name="is_limited" id="is_limited">
                                    <label for="is_limited">
                                        Drink is limited?
                                    </label>
                                </div>
                                <div class="checkbox checkbox-inline">
                                    <input type="checkbox" name="is_available" id="is_available" checked>
                                    <label for="is_available">
                                        Drink is available?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-footer">
                            <div class="form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-success">Add New Drink</button>
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