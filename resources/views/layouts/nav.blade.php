<nav class="navbar navbar-expand-md navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/threads') }}">
                    <i class="fab fa-old-republic"></i><span class="site-text">DoAsk</span>
          </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                 <form action="/threads/search" method="get">
              <li class="nav-item ">
              <div class="searchbar">
            <input class="search_input" type="text" name="q" placeholder="Search...">
            <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
              </div>
            </li>
                 </form>
                @guest
               
                @if (Route::has('register'))
               
                @endif @else
                <notifications></notifications>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-user"></i>
                       </a>
                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->isAdmin())
                        <a class="dropdown-item" href="{{route('admin.dashboard')}}">
                                        Dashboard
                                    </a>
                            @endif
                        <a class="dropdown-item" href="{{route('profile',Auth::user())}}">
                                        My Profile
                                    </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>