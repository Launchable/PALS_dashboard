<li class="dropdown profile">
    <a href="/html/pages/profile.html" class="dropdown-toggle" data-toggle="dropdown">
        <img class="profile-img"
             src="{{ Auth::user()->getAvatar() }}">
        <div class="title">Profile</div>
    </a>
    <div class="dropdown-menu">
        <div class="profile-info">
            <h4 class="username">{{ Auth::user()->getFullName }}</h4>
        </div>
        <ul class="action">
            <li>
                <a href="{{ route('profile') }}">
                    Profile
                </a>
            </li>
            <li>
                <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</li>