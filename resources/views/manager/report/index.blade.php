@extends('layouts.pals')

@section('content')
    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>Reports</strong></li>
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
            <div class="card card-mini">
                <div class="card-body">
                    <div class="row">
                        <form class="form-inline" method="post" action="{{ route('manager.report.index') }}">
                            {{ csrf_field() }}
                            <div class="col-sm-2">
                                <div class="input-group input-group-lg date">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input type="text" id="from" name="from" class="form-control" placeholder="From"
                                           value="{{ $start }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group input-group-lg date">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input type="text" id="to" name="to" class="form-control" placeholder="To"
                                           value="{{ $end }}">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="input-group input-group-lge">
                                    <span class="input-group-addon"><i
                                            class="glyphicon glyphicon-map-marker"></i></span>
                                    <select name="location" id="location" class="select2 form-control">
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}"
                                                {{ ($locationId == $location->id) ? 'selected' : '' }}>
                                                {{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="input-group input-group-lge">
                                    <span class="input-group-addon"><i class="fa fa-bar-chart"></i></span>
                                    <select name="report" id="report" class="select2 form-control">
                                        <option
                                            value="totalSales" {{ request('report') == 'totalSales' ? 'selected' : '' }}>
                                            Total Sales
                                        </option>
                                        <option
                                            value="totalOrders" {{ request('report') == 'totalOrders' ? 'selected' : '' }}>
                                            Total Orders
                                        </option>
                                        <option
                                            value="averageSpent" {{ request('report') == 'averageSpent' ? 'selected' : '' }}>
                                            Average Spent
                                        </option>
                                        <option
                                            value="mostPurchaseDrinks" {{ request('report') == 'mostPurchaseDrinks' ? 'selected' : '' }}>
                                            Most Purchase Drinks
                                        </option>
                                        <option
                                            value="totalPurchase" {{ request('report') == 'totalPurchase' ? 'selected' : '' }}>
                                            Total Purchase
                                        </option>
                                        <option
                                            value="totalRedeemed" {{ request('report') == 'totalRedeemed' ? 'selected' : '' }}>
                                            Total Redeemed
                                        </option>
                                        <option
                                            value="busiestDay" {{ request('report') == 'busiestDay' ? 'selected' : '' }}>
                                            Busiest Day
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg" name="submit" type="submit">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    Data Visualization From Date Range Selected
                </div>
                <div class="card-body">
                    <div id="chart" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    Orders From Date Range Selected
                </div>
                <div class="card-body">
                    <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Redeemed?</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->username }}</td>
                                <td>{{ $order->drink != null ? 'Drink' : 'Cover' }}</td>
                                <td>{{ $order->drink != null ? $order->drink : $order->cover }}</td>
                                <td>${{ $order->price }}</td>
                                <td>{{ $order->is_redeemed == 1 ? 'Yes' : 'No' }}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="/js/loader.js"></script>

    <script type="text/javascript">
        $(function () {
            $('.date').datetimepicker({
                format: 'Y-MM-DD'
            });

            // Load Charts and the corechart package.
            google.charts.load('current', {'packages': ['corechart']});
            // Draw the pie chart for Sarah's pizza when Charts is loaded.
            google.charts.setOnLoadCallback(drawChart);

            // Callback that draws the pie chart for drinks and sales.
            function drawChart() {
                var data = new google.visualization.DataTable({!! $data !!});
                var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
                chart.draw(data, {!! $options !!});
            }


            $(window).resize(function () {
                drawChart();
            });

        });
    </script>
@endsection