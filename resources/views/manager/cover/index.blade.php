@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>Covers</strong></li>
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
                    <a href="{{ route('manager.cover.add') }}" class="btn btn-success btn-sm">ADD NEW</a>
                    <div class="col-sm-3">
                        <form id="location-form" action="{{ route('manager.cover.post.index') }}" method="post">
                            {{ csrf_field() }}
                            <select name="location" id="location" class="select2 form-control" onchange="$('#location-form').submit();">
                                @foreach($locations->locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ ($locationId == $location->id) ? 'selected' : '' }}>
                                        {{ $location->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th style="width: 100px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($covers as $cover)
                            <tr>
                                <td>{{ $cover->id }}</td>
                                <td>
                                    <a href="{{route('manager.cover.edit', $cover->id)}}">
                                        {{ $cover->title }}
                                    </a>
                                </td>
                                <td>{{ $cover->description }}</td>
                                <td>
                                    ${{ $cover->price }}
                                </td>
                                <td>
                                    <a href="{{ route('manager.cover.edit', $cover->id) }}"
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

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Your are about to delete a drink!</h4>
                                </div>
                                <form action="{{ route('manager.cover.delete') }}" method="post">
                                    <div class="modal-body">
                                        {{csrf_field()}}
                                        <input type="hidden" id="deleteId" name="id">
                                        <p>Are you sure you want to delete this drink?</p>
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