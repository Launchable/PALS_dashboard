<ul class="sidebar-nav">
    <li @if($pageName == 'dashboard') class="active" @endif>
        <a href="{{ route('manager.dashboard') }}">
            <div class="icon">
                <i class="fa fa-tasks" aria-hidden="true"></i>
            </div>
            <div class="title">Dashboard</div>
        </a>
    </li>
    <li @if($pageName == 'location') class="active" @endif>
        <a href="{{ route('manager.location.index') }}">
            <div class="icon">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
            <div class="title">Locations</div>
        </a>
    </li>
    {{--<li class="dropdown @if($pageName == 'location') active @endif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
            <div class="title">Locations</div>
        </a>
        <div class="dropdown-menu">
            <ul>
                <li class="section"><i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Actions</strong></li>
                <li><a href="{{ route('manager.location.add') }}">Add New Location</a></li>
                <li><a href="{{ route('manager.location.index') }}">View All</a></li>
            </ul>
        </div>
    </li>--}}
    <li class="dropdown @if($pageName == 'drink') active @endif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon">
                <i class="fa fa-beer" aria-hidden="true"></i>
            </div>
            <div class="title">Drinks</div>
        </a>
        <div class="dropdown-menu">
            <ul>
                <li class="section"><i class="fa fa-beer" aria-hidden="true"></i> Actions</li>
                <li><a href="{{ route('manager.drink.add') }}">Add New Drink</a></li>
                <li><a href="{{ route('manager.drink.index') }}">View All</a></li>
            </ul>
        </div>
    </li>
    <li class="dropdown @if($pageName == 'cover') active @endif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon">
                <i class="fa fa-ticket" aria-hidden="true"></i>
            </div>
            <div class="title">Covers</div>
        </a>
        <div class="dropdown-menu">
            <ul>
                <li class="section"><i class="fa fa-ticket" aria-hidden="true"></i> Actions</li>
                <li><a href="{{ route('manager.cover.add') }}">Add New Cover</a></li>
                <li><a href="{{ route('manager.cover.index') }}">View All</a></li>
            </ul>
        </div>
    </li>
    <li class="dropdown @if($pageName == 'event') active @endif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon">
                <i class="fa fa-location-arrow" aria-hidden="true"></i>
            </div>
            <div class="title">Events</div>
        </a>
        <div class="dropdown-menu">
            <ul>
                <li class="section"><i class="fa fa-location-arrow" aria-hidden="true"></i> Actions</li>
                <li><a href="{{ route('manager.event.add') }}">Add New Event</a></li>
                <li><a href="{{ route('manager.event.index') }}">View All</a></li>
            </ul>
        </div>
    </li>
    <li class="dropdown @if($pageName == 'report') active @endif">
        <a href="{{ route('manager.report.index') }}">
            <div class="icon">
                <i class="fa fa-area-chart" aria-hidden="true"></i>
            </div>
            <div class="title">Reports</div>
        </a>
    </li>
</ul>