@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>History</strong></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @include('layouts.common.navbar')
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="section">
                <div class="section-title">Drink History</div>
                <div class="section-body">
                    <div class="card card-mini">
                        <div class="card-header">
                            <div class="card-title"><strong>Today</strong></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(count($drinksToday) > 0)
                                    @foreach($drinksToday as $key => $drinks)
                                        <table class="table card-table">
                                            <thead>
                                            <tr>
                                                <th colspan="3"><strong>{{ $key }}</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($drinks['drinks'] as $drink)
                                                <tr>
                                                    <td style="width: 300px">{{ $drink->title }}</td>
                                                    <td>${{ $drink->price }}</td>
                                                    <td>{{ Carbon\Carbon::parse($drink->created_at)->format('F d, Y @ H:i A')  }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                @else
                                    <table class="table card-table">
                                        <tr>
                                            <td><p>No data available</p></td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="card card-mini">
                        <div class="card-header">
                            <div class="card-title"><strong>Yesterday</strong></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(count($drinksYesterday) > 0)
                                    @foreach($drinksYesterday as $key => $drinks)
                                        <table class="table card-table">
                                            <thead>
                                            <tr>
                                                <th colspan="3"><strong>{{ $key }}</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($drinks['drinks'] as $drink)
                                                <tr>
                                                    <td style="width: 300px">{{ $drink->title }}</td>
                                                    <td>${{ $drink->price }}</td>
                                                    <td>{{ Carbon\Carbon::parse($drink->created_at)->format('F d, Y @ H:i A')  }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                @else
                                    <table class="table card-table">
                                        <tr>
                                            <td><p>No data available</p></td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="card card-mini">
                        <div class="card-header">
                            <div class="card-title"><strong>Past Days</strong></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(count($drinksPast) > 0)
                                    @foreach($drinksPast as $key => $drinks)
                                        <table class="table card-table">
                                            <thead>
                                            <tr>
                                                <th colspan="3"><strong>{{ $key }}</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($drinks['drinks'] as $drink)
                                                <tr>
                                                    <td style="width: 300px">{{ $drink->title }}</td>
                                                    <td>${{ $drink->price }}</td>
                                                    <td>{{ Carbon\Carbon::parse($drink->created_at)->format('F d, Y @ H:i A')  }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                @else
                                    <table class="table card-table">
                                        <tr>
                                            <td><p>No data available</p></td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Cover History -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

            <div class="section">
                <div class="section-title">Cover History</div>
                <div class="section-body">
                    <div class="card card-mini">
                        <div class="card-header">
                            <div class="card-title"><strong>Today</strong></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(count($coversToday) > 0)
                                    @foreach($coversToday as $key => $drinks)
                                        <table class="table card-table">
                                            <thead>
                                            <tr>
                                                <th colspan="3"><strong>{{ $key }}</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($drinks['covers'] as $drink)
                                                <tr>
                                                    <td style="width: 300px">{{ $drink->title }}</td>
                                                    <td>${{ $drink->price }}</td>
                                                    <td>{{ Carbon\Carbon::parse($drink->created_at)->format('F d, Y @ H:i A')  }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                @else
                                    <table class="table card-table">
                                        <tr>
                                            <td><p>No data available</p></td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="card card-mini">
                        <div class="card-header">
                            <div class="card-title"><strong>Yesterday</strong></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(count($coversYesterday) > 0)
                                    @foreach($coversYesterday as $key => $drinks)
                                        <table class="table card-table">
                                            <thead>
                                            <tr>
                                                <th colspan="3"><strong>{{ $key }}</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($drinks['covers'] as $drink)
                                                <tr>
                                                    <td style="width: 300px">{{ $drink->title }}</td>
                                                    <td>${{ $drink->price }}</td>
                                                    <td>{{ Carbon\Carbon::parse($drink->created_at)->format('F d, Y @ H:i A')  }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                @else
                                    <table class="table card-table">
                                        <tr>
                                            <td><p>No data available</p></td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="card card-mini">
                        <div class="card-header">
                            <div class="card-title"><strong>Past Days</strong></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(count($coversPast) > 0)
                                    @foreach($coversPast as $key => $drinks)
                                        <table class="table card-table">
                                            <thead>
                                            <tr>
                                                <th colspan="3"><strong>{{ $key }}</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($drinks['covers'] as $drink)
                                                <tr>
                                                    <td style="width: 300px">{{ $drink->title }}</td>
                                                    <td>${{ $drink->price }}</td>
                                                    <td>{{ Carbon\Carbon::parse($drink->created_at)->format('F d, Y @ H:i A')  }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                @else
                                    <table class="table card-table">
                                        <tr>
                                            <td><p>No data available</p></td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection