<ul class="sidebar-nav">
    <li @if($pageName == 'home') class="active" @endif>
        <a href="{{ route('registered.home') }}">
            <div class="icon">
                <i class="fa fa-home" aria-hidden="true"></i>
            </div>
            <div class="title">Home</div>
        </a>
    </li>
    <li class="dropdown @if($pageName == 'friends') active @endif">
        <a href="{{ route('registered.friends') }}">
            <div class="icon">
                <i class="fa fa-group" aria-hidden="true"></i>
            </div>
            <div class="title">Friends</div>
        </a>
    </li>
    <li class="dropdown @if($pageName == 'history') active @endif">
        <a href="{{ route('registered.history') }}">
            <div class="icon">
                <i class="fa fa-history" aria-hidden="true"></i>
            </div>
            <div class="title">History</div>
        </a>
    </li>
    {{--
    <li class="dropdown @if($pageName == 'cover') active @endif">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon">
                <i class="fa fa-ticket" aria-hidden="true"></i>
            </div>
            <div class="title">My Covers</div>
        </a>
        <div class="dropdown-menu">
            <ul>
                <li class="section"><i class="fa fa-ticket" aria-hidden="true"></i> Actions</li>
                <li><a href="{{ route('manager.cover.add') }}">Add New Cover</a></li>
                <li><a href="{{ route('manager.cover.index') }}">View All</a></li>
            </ul>
        </div>
    </li>--}}
</ul>