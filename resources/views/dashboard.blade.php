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
                    <div id="drinks-sold" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a class="card card-banner card-green-light">
                    <div class="card-body">
                        <i class="icon fa fa-shopping-basket fa-4x"></i>
                        <div class="content">
                            <div class="title">Sale Today</div>
                            <div class="value"><span class="sign">$</span>420</div>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a class="card card-banner card-blue-light">
                    <div class="card-body">
                        <i class="icon fa fa-thumbs-o-up fa-4x"></i>
                        <div class="content">
                            <div class="title">Page Likes</div>
                            <div class="value"><span class="sign"></span>2453</div>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a class="card card-banner card-yellow-light">
                    <div class="card-body">
                        <i class="icon fa fa-user-plus fa-4x"></i>
                        <div class="content">
                            <div class="title">New Registration</div>
                            <div class="value"><span class="sign"></span>50</div>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="/js/loader.js"></script>
    <script>

        // Load Charts and the corechart package.
        google.charts.load('current', {'packages': ['corechart']});

        google.charts.setOnLoadCallback(drawDrinksSold);

        // Callback that draws the pie chart for drinks and sales.
        function drawDrinksSold() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Day');
            data.addColumn('number', 'Sales (USD)');
            data.addColumn({type: 'string', role: 'annotation'});
            data.addRows({!! $salesToday !!});

            var options = {
                //title: 'Daily Total Sales',
                colors: ['#29c75f'],
                vAxis: {minValue: 0, title: 'Dollars (USD)',  textPosition: 'none'}
            };

            var chart = new google.visualization.LineChart(document.getElementById('drinks-sold'));
            chart.draw(data, options);
        }

        $(window).resize(function(){
            drawDrinksSold();
        });


    </script>
@endsection