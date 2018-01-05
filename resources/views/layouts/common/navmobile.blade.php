<ul class="nav navbar-nav navbar-mobile">
    <li>
        <button type="button" class="sidebar-toggle">
            <i class="fa fa-bars"></i>
        </button>
    </li>
    <li class="logo">
        <a class="navbar-brand" href="#"><span class="highlight">PALS</span></a>
    </li>
    <li>
        <button type="button" class="navbar-toggle">
            <img class="profile-img" src="@if(Auth::user()->avatar == 'default.jpg')https://robohash.org/{{Auth::user()->username}}.png @else /uploads/avatars/{{ Auth::user()->avatar}}
            @endif">
        </button>
    </li>
</ul>