<ul class="sidebar-nav">
    <li @if($pageName == 'dashboard') class="active" @endif>
        <a href="{{ route('admin.dashboard') }}">
            <div class="icon">
                <i class="fa fa-tasks" aria-hidden="true"></i>
            </div>
            <div class="title">Dashboard</div>
        </a>
    </li>
    <li class="dropdown @if($pageName == 'user') active @endif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <div class="title">Users</div>
        </a>
        <div class="dropdown-menu">
            <ul>
                <li class="section"><i class="fa fa-user" aria-hidden="true"></i> <strong>Actions</strong></li>
                <li><a href="{{ route('admin.user.add') }}">Add New User</a></li>
                <li><a href="{{ route('admin.user.index') }}">View All</a></li>
            </ul>
        </div>
    </li>
    <li class="dropdown @if($pageName == 'location') active @endif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
            <div class="title">Locations</div>
        </a>
        <div class="dropdown-menu">
            <ul>
                <li class="section"><i class="fa fa-map-marker" aria-hidden="true"></i> <strong>Actions</strong></li>
                <li><a href="{{ route('admin.location.add') }}">Add New Location</a></li>
                <li><a href="{{ route('admin.location.index') }}">View All</a></li>
                <li class="line"></li>
                <li class="section"><i class="fa fa-folder-o" aria-hidden="true"></i> <strong>Establishment Type</strong></li>
                <li><a href="{{ route('admin.location.types') }}">Add New Type</a></li>
            </ul>
        </div>
    </li>
    <li class="dropdown @if($pageName == 'drink') active @endif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon">
                <i class="fa fa-beer" aria-hidden="true"></i>
            </div>
            <div class="title">Drinks</div>
        </a>
        <div class="dropdown-menu">
            <ul>
                <li class="section"><i class="fa fa-beer" aria-hidden="true"></i> <strong>Actions</strong></li>
                <li><a href="{{ route('admin.drink.add') }}">Add New Drink</a></li>
                <li><a href="{{ route('admin.drink.index') }}">View All</a></li>
                <li class="line"></li>
                <li class="section"><i class="fa fa-folder-o" aria-hidden="true"></i> <strong>Drink Types</strong></li>
                <li><a href="{{ route('admin.drink.types') }}">Add New Type</a></li>
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
                <li class="section"><i class="fa fa-ticket" aria-hidden="true"></i> <strong>Actions</strong></li>
                <li><a href="{{ route('admin.cover.add') }}">Add New Cover</a></li>
                <li><a href="{{ route('admin.cover.index') }}">View All</a></li>
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
                <li class="section"><i class="fa fa-location-arrow" aria-hidden="true"></i> <strong>Actions</strong></li>
                <li><a href="{{ route('admin.event.add') }}">Add New Event</a></li>
                <li><a href="{{ route('admin.event.index') }}">View All</a></li>
            </ul>
        </div>
    </li>
    <li class="dropdown @if($pageName == 'report') active @endif">
        <a href="{{ route('admin.report.index') }}">
            <div class="icon">
                <i class="fa fa-area-chart" aria-hidden="true"></i>
            </div>
            <div class="title">Reports</div>
        </a>
    </li>
</ul>