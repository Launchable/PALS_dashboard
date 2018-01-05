@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>Location</strong></li>
                    {{--<li class="navbar-search hidden-sm">
                        <input id="searchTerm" type="text" placeholder="Search.." value="{{ old('search') }}">
                        <button class="btn-search" id="searchBtn"><i class="fa fa-search"></i></button>
                    </li>--}}
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @include('layouts.common.navbar')
                </ul>
            </div>
        </div>
    </nav>

    @include('layouts.common.flash')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body app-heading">
                    <img class="profile-img" src="/uploads/locations/{{$location->image}}">
                    <div class="app-title">
                        <div class="pull-right">
                            <a href="{{route('admin.location.edit', $location->id)}}" class="btn btn-success">Edit</a>
                            <a href="{{ route('admin.location.add') }}" class="btn btn-success">Add Location</a>
                        </div>
                        <div class="title"><span class="highlight">{{ $location->name }}</span></div>
                        <div class="description">{{$location->address}}, {{$location->phone}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-tab">
                <div class="card-header">
                    <ul class="nav nav-tabs">
                        <li role="tab1" class="active">
                            <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Profile</a>
                        </li>
                        <li role="tab3">
                            <a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">Drinks</a>
                        </li>
                        <li role="tab4">
                            <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">Covers</a>
                        </li>
                        <li role="tab5">
                            <a href="#tab5" aria-controls="tab5" role="tab" data-toggle="tab">Events</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body no-padding tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <div class="section">
                                    <div class="section-title">
                                        QR Code
                                    </div>
                                    <div class="section-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    {!! QrCode::size(300)->generate($location->code) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-sm-12">
                                <div class="section">
                                    <div class="section-title"><i class="icon fa fa-file" aria-hidden="true"></i> Description</div>
                                    <div class="section-body __indent">{{$location->description}}</div>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-sm-4 col-xs-12">
                                <div class="section">
                                    <div class="section-body">
                                        <div class="section-title"><i class="icon fa fa-group" aria-hidden="true"></i> Managers</div>
                                        <div class="section-body __indent">
                                            <div class="list-group __timeline">
                                                @foreach($location->users as $user)
                                                    <div class="list-group-item">
                                                        <span class="badge badge-success"></span>
                                                        <a href="{{route('admin.user.edit', $user->id)}}">
                                                            {{ $user->full_name }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="section">
                                    <div class="section-title"><i class="icon fa fa-clock-o" aria-hidden="true"></i> Open Days and Hours</div>
                                    <div class="section-body __indent">
                                        <div class="list-group __timeline">
                                            @foreach($location->operations as $operation)
                                                @if($operation->opens_at !== NULL)
                                                    <div class="list-group-item">
                                                        <span class="badge badge-success">{{date('h:i A', strtotime($operation->opens_at))}} - {{date('h:i A', strtotime($operation->closes_at))}}</span>
                                                        {{date('l', strtotime("Monday +{$operation->week_day} days"))}}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="section">
                                    <div class="section-title"><i class="icon fa fa-folder-o" aria-hidden="true"></i> Location Type</div>
                                    <div class="section-body __indent">
                                        <div class="list-group __timeline">
                                            @foreach($location->types as $type)
                                                <div class="list-group-item">
                                                    {{$type->name}}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab3">
                        <div class="row">
                            <div class="section">
                                <div class="section-title">&nbsp;</div>
                                <div class="section-body">
                                    <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Drink</th>
                                            <th>Price</th>
                                            <th>Type</th>
                                            <th>Stocks</th>
                                            <th>IsAvailable</th>
                                            <th>IsLimited</th>
                                            <th style="width: 100px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($location->drinks as $drink)
                                            <tr>
                                                <td>{{ $drink->id }}</td>
                                                <td>
                                                    <a href="{{route('admin.drink.edit', $drink->id)}}">
                                                        {{ $drink->title }}
                                                    </a>
                                                </td>
                                                <td>
                                                    ${{ $drink->price }}
                                                </td>
                                                <td>
                                                    {{ $drink->type->name }}
                                                </td>
                                                <td>
                                                    {{ $drink->stocks }}
                                                </td>
                                                <td>
                                                    {{ $drink->is_available == 1 ? 'YES' : 'NO'}}
                                                </td>
                                                <td>
                                                    {{ $drink->is_limited == 1 ? 'YES' : 'NO'}}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.drink.edit', $drink->id) }}"
                                                       class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger btn-xs btnUserDelete"
                                                       data-id="{{ $drink->id }}"
                                                       data-toggle="modal"
                                                       data-target="#deleteModal"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab4">
                        <div class="row">
                            <div class="section">
                                <div class="section-title">&nbsp;</div>
                                <div class="section-body">
                                    <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Drink</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th style="width: 100px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($location->covers as $cover)
                                            <tr>
                                                <td>{{ $cover->id }}</td>
                                                <td>
                                                    <a href="{{route('admin.cover.edit', $cover->id)}}">
                                                        {{ $cover->title }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $cover->description }}
                                                </td>
                                                <td>
                                                    ${{ $cover->price }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.cover.edit', $cover->id) }}"
                                                       class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger btn-xs btnUserDelete"
                                                       data-id="{{ $cover->id }}"
                                                       data-toggle="modal"
                                                       data-target="#deleteModal"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab5">
                        <div class="row">
                            <div class="section">
                                <div class="section-title">&nbsp;</div>
                                <div class="section-body">
                                    <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th style="width:100px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($location->events as $event)
                                            <tr>
                                                <td>{{ $event->id }}</td>
                                                <td>
                                                    {{ $event->title }}
                                                </td>
                                                <td>
                                                    {{ $event->description }}
                                                </td>
                                                <td>
                                                    {{ date('d/m/Y H:i A', strtotime($event->date)) }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.event.edit', $event->id) }}"
                                                       class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger btn-xs btnUserDelete"
                                                       data-id="{{ $event->id }}"
                                                       data-toggle="modal"
                                                       data-target="#deleteModal"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection