@guest
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                med<b class="text-primary">sos</b>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                @if(Request::is('register'))
                    <li class="nav-item">
                        <a href="/login" class="nav-link">Login</a>
                    </li>
                @elseif(Request::is('login'))
                    <li class="nav-item">
                        <a href="/register" class="nav-link">Register</a>
                    </li>
                @else
                    <!-- Authentication Links -->
                    <form class="form-inline" method="POST" action="{{ route('login') }}">
                    @csrf
                        <label class="sr-only" for="inlineFormInputEmail">Email</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroupEmail" name="email" placeholder="E-mail">
                        </div>

                        <label class="sr-only" for="inlineFormInputGroupPassword">Password</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-unlock-alt" aria-hidden="true">&nbsp;</i></div>
                            </div>
                            <input type="password" class="form-control" id="inlineFormInputGroupPassword" name="password" placeholder="Password">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">Login</button>
                    </form>
                @endif
                </ul>
            </div>
        </div>
    </nav>
@else    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/home">med<b class="text-primary">sos</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{Request::is('home') ? 'active' : ''}}" href="/home">Home</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link {{Request::is('dashboard') ? 'active' : ''}}" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{Request::is('profile/*') ? 'active' : ''}}" href="/profile/{{auth()->user()->id}}">Profile</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link {{Request::is('message') ? 'active' : ''}}" id="msg_notif" href="/message">
                        Message<span class="notif2" id="notif_msg"></span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notification<span class="notif" id="Notif"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="notificationsMenu" id="notificationsMenu">
                        <li class="dropdown-header">No notification</li>
                        <hr>
                        <li><a href="/history/{{auth()->user()->id}}">View History</a></li>
                    </ul>
                </li>
            </ul>
            <form class="form-inline my-2 my-md-0" method="GET" action="/search" role="search">
                <div class="input-group">
                    <input class="form-control" type="text" id="search" name="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="nav navbar-nav ml-auto" style="margin-left:5px !important">
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action" title="{{Auth::user()->name}}"><img src="{{asset('/public/cover_image/' . auth()->user()->profile_image)}}" class="avatar" alt="Avatar">&nbsp;<b class="caret">{{ Auth::user()->name }}</b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/dashboard" class="dropdown-item"><i class="fa fa-user-o"></i> Dashboard</a></li>
                        <li><a href="/profile/{{auth()->user()->id}}" class="dropdown-item"><i class="fa fa-calendar-o"></i> Profile</a></li>
                        <li><a href="/linked" class="dropdown-item"><i class="fa fa-link"></i> Linked account</a></li>
                        <li class="divider dropdown-divider"></li>
                        <li><a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a></li>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endguest