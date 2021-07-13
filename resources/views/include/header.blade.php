<header>
    {{-- <nav class="navbar fixed-top navbar-expand-lg navbar-dark navbar_header_style"> --}}
    <nav class="navbar fixed-top navbar-expand-lg ml-auto navbar-light navbar_header_style">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="/">
                <img src="{{ asset('gambar/logo/Logo Nirmala Kuning (No BG).png') }}" alt="logoUs" width="60px" height="60px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto ulHeader">
                    <li class="nav-item btn-group">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    {{-- untuk guest atau user yg role nya member --}}
                    @if (Auth::guest() || Auth::user()->role_id != 3)
                        <li class="nav-item btn-group">
                            <div class="droupdownMenu_edit">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('Reservation')}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- <form action="/grooming" method="put">
                                        <input name="service_type" type="text" hidden value="Grooming">
                                        <button class="btn dropdown-item" type="submit">
                                            {{__('Grooming')}}
                                        </button>
                                    </form> --}}
                                    <a class="dropdown-item" href="/grooming">{{__('Grooming')}}</a>
                                    <a class="dropdown-item" href="/konsultasi">{{__('Konsultasi')}}</a>
                                </div>
                            </div>
                        </li>
                    @endif

                    {{-- untuk user member --}}
                    @if (!Auth::guest() && Auth::user()->role_id != 3)
                        <li class="nav-item btn-group">
                            <a class="nav-link" href="/adoption">Adoption</a>
                        </li>
                    @endif

                    {{-- untuk manage data = user admin or pet shop --}}
                    @if(!Auth::guest() && Auth::user()->role_id != 2)
                        <li class="nav-item btn-group">
                            <div class="droupdownMenu_edit">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('Manage Data')}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- untuk user admin --}}
                                    @if (!Auth::guest() && Auth::user()->role_id == 1)
                                        <a class="dropdown-item" href="/manage/user">{{__('Manage User')}}</a>
                                        <a class="dropdown-item" href="/manage/pet">{{__('Manage Pet')}}</a>
                                        <a class="dropdown-item" href="/manage/services">{{__('Manage Services')}}</a>
                                        {{-- <a class="dropdown-item" href="/manage/order">{{__('Manage Order')}}</a> --}}
                                    @endif
                                    {{-- untuk user pet shop --}}
                                    @if(!Auth::guest() && Auth::user()->role_id == 3)
                                        <a class="dropdown-item" href="/manage/services">{{__('Manage Services')}}</a>
                                        <a class="dropdown-item" href="/manage/order">{{__('Manage Order')}}</a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endif

                    {{-- untuk selain guest dan user member --}}
                    @if(!Auth::guest() && Auth::user()->role_id == 2)
                        <li class="nav-item btn-group">
                            <a class="nav-link" href="/transaction">{{__('Transaction')}}</a>
                        </li>
                    @endif

                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item btn-group">
                            <a class="nav-link" href="/adoption">Adoption</a>
                        </li>

                        <li class="nav-item btn-group">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('gambar/user.png')}}" alt="foto" class="userCSS" width="35px" height="35px">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/login">{{__('Login')}}</a>
                                <a class="dropdown-item" href="/register">{{__('Register')}}</a>
                            </div>
                            {{-- <a class="nav-link" href="/login">{{ __('Login') }}</a> --}}
                        </li>
                        {{-- @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="/register">{{ __('Register') }}</a>
                        </li> --}}
                        {{-- @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif --}}

                        @else
                            <li class="nav-item btn-group">
                                <div class="droupdownMenu_edit">
                                    <a id="navbarDropdown" class="btn text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{-- {{ 'Hello, '.Auth::user()->name }} --}}
                                        @if (Auth::user()->user_photo == null)
                                            <img src="{{asset('gambar/user.png')}}" alt="foto" title="{{ 'Hello, '.Auth::user()->name }}" class="userCSS" width="35px" height="35px">
                                        @else
                                            <img src="{{ asset('gambar/foto_user_login/'.Auth::user()->user_photo) }}" title="{{ 'Hello, '.Auth::user()->name }}" alt="foto user" class="rounded-circle userCSS" width="35px" height="35px">
                                        @endif
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        {{-- <a class="dropdown-item" href="/profile">{{__('My Profile')}}</a> --}}
                                        <a class="dropdown-item" href="{{ route('editProfile') }}">{{__('My Profile')}}</a>
                                        {{-- <a class="dropdown-item" href="{{ route('logout') }}" --}}
                                        <a class="dropdown-item" href="/logout"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();" id="logoutClick">
                                            {{ __('Logout') }}
                                        </a>

                                        {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> --}}
                                        <form id="logout-form" action="/logout" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                    @endguest
                </ul>
                {{-- untuk auto logout --}}
                {{-- <script>
                    $(document).ready(function () {
                        // const timeout = 900000;  // 900000 ms = 15 minutes
                        const timeout = 5000;
                        var idleTimer = null;
                        $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
                            clearTimeout(idleTimer);

                            idleTimer = setTimeout(function () {
                                document.getElementById('logout-form').submit();
                            }, timeout);
                        });
                        $("body").trigger("mousemove");
                    });
                </script> --}}
            </div>
        </div>
    </nav>
</header>
