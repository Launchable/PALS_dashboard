@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>Edit Cover</strong></li>
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
            <form class="form form-horizontal" action="{{ route('manager.cover.update', $cover->id) }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $cover->id }}">
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
                                                data-validation-error-msg="Please select a location to associate the cover."
                                        >
                                            <option value="">-- Choose a location--</option>
                                            @foreach($locations as $location)
                                                <option
                                                    value="{{ $location->id }}"
                                                    {{$location->id == $cover->location_id ? 'selected' : ''}}>
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
                                               value="{{ $cover->title }}"
                                               class="form-control"
                                               data-validation="length"
                                               data-validation-length="min1"
                                               data-validation-error-msg="Cover title is required."
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
                                                  data-validation-error-msg="Please enter a short description of the cover."
                                        >{{ $cover->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                    <label class="col-md-3 control-label">Price</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-addon">$</div>
                                            <input type="text" name="price" value="{{ $cover->price }}"
                                                   class="form-control" id="price"
                                                   data-validation="number"
                                                   data-validation-allowing="float"
                                                   data-validation-error-msg="Please enter cover price, e.g. 20.00"
                                            >
                                            @if ($errors->has('price'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('price') }}</strong>
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


                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $.validate({
            modules: 'location, date, security, file'
        });
    </script>
@endsection