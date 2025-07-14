<header id="header" data-transparent="true" data-fullwidth="true" class="dark submenu-light">
    <div class="header-inner">
        <div class="container">
            <div id="logo">
                <a href="">
                    <span class="logo-default">RVParkHQ</span>
                    <span class="logo-dark">RVParkHQ</span>
                </a>
            </div>
            <div id="mainMenu-trigger">
                <a class="lines-button x"><span class="lines"></span></a>
            </div>
            <div id="mainMenu">
                <div class="container">
                    <nav>
                        <ul>
                            <li><a href="{{ route('rv-park.home') }}">Home</a></li>
                            <li><a href="{{ route('rv-park.all-parks') }}">Parks</a></li>
                            <li><a href="{{ route('rv-park.team') }}">Our Team</a></li>
                            <li><a href="{{ route('rv-park.blogs.index') }}">Blogs</a></li>
                            <li><a href="{{ route('rv-park.advertise.index') }}">Advertise</a></li>
                            <li><a href="#">Park Owners</a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('rv-park.CampConnect.index') }}">Camp Connect</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('rv-park.service') }}">Services</a></li>
                            <li><a href="{{ route('rv-park.contact') }}">Contact</a></li>
                            <li>
                                <a id="btn-search" href="#"> <i class="icon-search"></i></a>
                            </li>
                            @guest
                                <li><a href="#modalLogin" data-lightbox="inline">Login</a></li>
                                <li><a href="#modalRegister" data-lightbox="inline">Register</a></li>
                            @else
                                <li>
                                    <a href="#">{{ Auth::user()->name }}</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('rv-park.profile.dashboard') }}">My Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                @include('frontend.auth.profile-edit')
                            @endguest
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.pages.layouts.partials.search')
    @include('frontend.auth.login')
    @include('frontend.auth.register')
</header>
