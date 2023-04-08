<header class="ht-header">
    <div class="container">
        <nav class="navbar navbar-default navbar-custom">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header logo">
                <div class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <div id="nav-icon1">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <a href="{{ URL::route('index') }}"><img class="logo" src="{{ asset('assets/images/logo1.png') }}"
                        alt="" width="119" height="58"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse flex-parent" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav flex-child-menu menu-left">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="dropdown first">
                        <a href="{{ URL::route('index') }}" class="btn btn-default lv1">
                            Home
                        </a>
                    </li>
                    <li class="dropdown first">
                        <a href="{{ URL::Route('movies') }}">Movies List</a>
                    </li>
                    <li class="dropdown first">
                        <a href="{{ URL::Route('series') }}">Series List</a>
                    </li>
                    <li class="dropdown first">
                        <a href="{{ URL::Route('celeb_list') }}">celebrities</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav flex-child-menu menu-right">
                    {{-- <li class="dropdown first">
                        <a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">
                            pages <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                        <ul class="dropdown-menu level1">
                            <li><a href="landing.html">Landing</a></li>
                            <li><a href="{{ URL::Route('404') }}">404 Page</a></li>
                            <li class="it-last"><a href="comingsoon.html">Coming soon</a></li>
                        </ul>
                    </li> --}}
                    <li><a href="#">Help</a></li>
                    @if (!Session::has('userId'))
                        <li class="loginLink"><a href="#">LOG In</a></li>
                        <li class="btn signupLink"><a href="#">sign up</a></li>
                    @else
                        <li class="dropdown">
                            <a data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Hello, {{ Session::get('userName') }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="#">Buy Cash</a></li>
                                <li><a class="dropdown-item" href="{{URL::Route('user_profile', Session::get('userId'))}}">Edit Account</a></li>
                                <li><a class="dropdown-item" href="{{URL::Route('logout')}}">Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        {{-- <!-- top search form -->
        <div class="top-search">
            <form>
                <input type="text" placeholder="Search for a movie, TV Show or celebrity that you are looking for">
            </form>
        </div> --}}
    </div>
</header>
