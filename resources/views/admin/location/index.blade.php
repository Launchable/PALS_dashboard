@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>All Locations</strong></li>
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
                    <a href="{{ route('admin.location.add') }}" class="btn btn-success">Add New</a>
                </div>
                <div class="card-body">
                    <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Managers</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th style="width: 120px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td>{{ $location->id }}</td>
                                <td>
                                    @foreach($location->users as $user)
                                        <a href="{{route('admin.user.edit', $user->id)}}">
                                            {{ $user->full_name }}
                                        </a>
                                        @if (!$loop->last) | @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('admin.location.view', $location->id)}}">
                                        {{ $location->name }}
                                    </a>
                                </td>
                                <td>{{ $location->phone }}</td>
                                <td>{{ $location->address }}</td>
                                <td>
                                    <a href="{{ route('admin.location.view', $location->id) }}"
                                       class="btn btn-success btn-xs"><i class="fa fa-search"></i></a>
                                    <a href="{{ route('admin.location.edit', $location->id) }}"
                                       class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                    @if(Auth::user()->id != $location->user_id)
                                        <a href="#" class="btn btn-danger btn-xs btnUserDelete"
                                           data-id="{{ $location->id }}"
                                           data-toggle="modal"
                                           data-target="#deleteModal"><i class="fa fa-remove"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Your are about to delete a location!</h4>
                                </div>
                                <form action="{{route('admin.location.delete')}}" method="post">
                                    <div class="modal-body">
                                        {{csrf_field()}}
                                        <input type="hidden" id="deleteId" name="id">
                                        <p>Are you sure you want to delete this location?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-default"
                                                data-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-success">Proceed To Delete
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
@endsection

@section('scripts')
    <script>
        $('.btnUserDelete').click(function (e) {
            e.preventDefault();
            $id = $(this).data('id');

            $('#deleteId').val($id);

        });
    </script>
@endsection