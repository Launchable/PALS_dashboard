@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>Dashboard</strong></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @include('layouts.common.navbar')
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-xs-12">
            <div class="card card-banner card-chart card-green no-br">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">Top Sale Today</div>
                    </div>
                    <ul class="card-action">
                        <li>
                            <a href="{{ route('manager.dashboard') }}">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div id="registered-users" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a class="card card-banner card-green-light">
                <div class="card-body">
                    <i class="icon fa fa-shopping-basket fa-4x"></i>
                    <div class="content">
                        <div class="title">Total Sale Today</div>
                        <div class="value"><span class="sign">$</span>{{ $totalSales }}</div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a class="card card-banner card-blue-light">
                <div class="card-body">
                    <i class="icon fa fa-shopping-cart fa-4x"></i>
                    <div class="content">
                        <div class="title">Total Orders Today</div>
                        <div class="value"><span class="sign"></span>{{ $totalOrders }}</div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <a class="card card-banner card-yellow-light">
                <div class="card-body">
                    <i class="icon fa fa-ticket fa-4x"></i>
                    <div class="content">
                        <div class="title">Total Redeemed Today</div>
                        <div class="value"><span class="sign"></span>{{ $ordersRedeemed }}</div>
                    </div>
                </div>
            </a>

        </div>

        <div class="col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card card-mini">
                        <div class="card-header">
                            <div class="card-title">Latest Drinks Ordered</div>
                        </div>
                        <div class="card-body no-padding table-responsive">
                            <table class="table card-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Drink</th>
                                    <th class="right">Price</th>
                                    <th>Is Redeemed?</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($drinksOrderedToday as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td class="right">{{ $order->title }}</td>
                                        <td class="right">{{ $order->price }}</td>
                                        <td>
                                            @if($order->is_redeemed == 1)
                                                <span class="badge badge-success badge-icon">
                                                <span>YES</span></span>
                                            @else
                                                <span class="badge badge-warning badge-icon">
                                                <span>NO</span></span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card card-mini">
                        <div class="card-header">
                            <div class="card-title">Latest Covers Ordered</div>
                            <ul class="card-action">
                                <li>
                                    <a href="/">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body no-padding table-responsive">
                            <table class="table card-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cover</th>
                                    <th class="right">Price</th>
                                    <th>Is Redeemed?</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($coversOrderedToday as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td class="right">{{ $order->title }}</td>
                                        <td class="right">{{ $order->price }}</td>
                                        <td>
                                            @if($order->is_redeemed == 1)
                                                <span class="badge badge-success badge-icon">
                                                <span>YES</span></span>
                                            @else
                                                <span class="badge badge-warning badge-icon">
                                                <span>NO</span></span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
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

@endsection

@section('scripts')
    <script type="text/javascript" src="/js/loader.js"></script>
    <script>

        // Load Charts and the corechart package.
        google.charts.load('current', {'packages': ['corechart']});

        google.charts.setOnLoadCallback(drawRegisteredUsers);

        // Callback that draws the pie chart for drinks and sales.
        function drawRegisteredUsers() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Day');
            data.addColumn('number', 'Sale');
            data.addColumn({type: 'string', role: 'annotation'});
            data.addRows({!! $salesToday !!});

            var options = {
                //title: 'Daily Total Sales',
                colors: ['#29c75f'],
                vAxis: {minValue: 0, title: 'Dollars (USD)',  textPosition: 'none'}
            };

            var chart = new google.visualization.LineChart(document.getElementById('registered-users'));
            chart.draw(data, options);
        }

        $(window).resize(function(){
            drawRegisteredUsers();
        });


    </script>
@endsection