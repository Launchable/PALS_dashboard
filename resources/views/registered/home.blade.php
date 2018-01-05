@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>Home</strong></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @include('layouts.common.navbar')
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">

        <div class="col-sm-4 col-xs-12">
            <div class="card">
                <div class="card-header">
                    Friend Requests
                </div>
                <div class="card-body" id="loading-box">
                    @if(count($friendRequest) > 0)
                        @foreach($friendRequest as $request)
                            <div id="media-{{$request->id}}">
                                <div class="media social-post">
                                    <div class="media-left">
                                        <a href="#">
                                            <img
                                                src="{{ App\Http\Helpers::getAvatar($request->avatar, $request->avatar_social) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <h4 class="title">{{ $request->first_name }} {{ $request->last_name }}</h4>
                                            <h5 class="timeing">{{ \Carbon\Carbon::parse($request->created_at)->diffForHumans() }}</h5>
                                        </div>
                                        <div class="media-content">
                                            <input type="hidden" name="senderId" id="sender-id-{{ $request->id }}"
                                                   value="{{ $request->sender_id }}">
                                            <input type="hidden" name="requestId" id="request-id-{{ $request->id }}"
                                                   value="{{ $request->id }}">
                                            <button class="btnFriendRequestConfirm btn btn-primary btn-sm"
                                                    data-id="{{ $request->id }}"
                                            >Confirm
                                            </button>
                                            <button class="btnFriendRequestDelete btn btn-default btn-sm"
                                                    data-id="{{ $request->id }}"
                                            >Delete Request
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>

                        @endforeach
                        @else
                        <p>No friend request</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-8 col-xs-12">
            <div class="card card-tab card-mini">
                <div class="card-header">
                    <ul class="nav nav-tabs tab-stats">
                        <li role="tab1" class="active">
                            <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">My Drinks</a>
                        </li>
                        <li role="tab2">
                            <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">My Covers</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab1">
                        <div class="row">
                            <table class="table card-table">
                                <thead>
                                <tr>
                                    <th>Drink</th>
                                    <th>Price</th>
                                    <th>Location</th>
                                    <th>From</th>
                                    <th>Message</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($drinks as $drink)
                                    <tr>
                                        <td>{{ $drink->drink->title }}</td>
                                        <td>${{ $drink->price }}</td>
                                        <td>{{ $drink->drink->location->name }}</td>
                                        <td>{{ $drink->sender->username }}</td>
                                        <td>{{ $drink->message }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab2">
                        <div class="row">
                            <table class="table card-table">
                                <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Price</th>
                                    <th>Location</th>
                                    <th>From</th>
                                    <th>Message</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($covers as $cover)
                                    <tr>
                                        <td>{{ $cover->cover->title }}</td>
                                        <td>${{ $cover->price }}</td>
                                        <td>{{ $cover->cover->location->name }}</td>
                                        <td>{{ $cover->sender->username }}</td>
                                        <td>{{ $cover->message }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab3">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/friends.js"></script>
@endsection