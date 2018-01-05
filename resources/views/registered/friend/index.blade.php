@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>All Friends</strong></li>
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
        <div class="col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    Friends
                </div>
                <div class="card-body">

                    <div class="row" id="loading-box">
                       @if(count($friends) > 0)
                            @foreach($friends as $friend)
                                <div class="col-md-3 col-sm-6" id="media-{{$friend->id}}">
                                    <div class="thumbnail">
                                        <img
                                            src="{{ App\Http\Helpers::getAvatar($friend->avatar, $friend->avatar_social) }}"
                                            alt="" style="width: 250px; border-radius: 50%;">
                                        <div class="caption">
                                            <h3 class="title">{{ $friend->first_name }} {{ $friend->last_name }}</h3>
                                            <p class="description">
                                                {{ $friend->first_name }} is {{ $friend->gender }} with email address
                                                {{ $friend->email }}. You can contact your friend at {{ $friend->phone }}
                                            </p>
                                            <div>
                                                <input type="hidden" name="requestId" id="request-id-{{ $friend->id }}"
                                                       value="{{ $friend->id }}">
                                                <button data-id="{{ $friend->id }}"
                                                        class="btnFriendRequestDelete btn btn-danger btn-xs">
                                                    Remove Friend
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                           <p>No friends available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/friends.js"></script>
@endsection