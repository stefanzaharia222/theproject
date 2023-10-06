<li class="nav-item navbar-dropdown dropdown-user dropdown">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="@if(Auth::user()->image) {{Auth::user()->getImage()}} @else {{asset('assets/img/avatars/1.png')}} @endif" alt class="w-px-40 h-auto rounded-circle">
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="{{ (Auth::user()->hasRole('super-admin')) ? 'javasceript:void()' : route('admin.profile.index', ['user'=> Auth::user()->id]) }}">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <img src="@if(Auth::user()->image) {{Auth::user()->getImage()}} @else {{asset('assets/img/avatars/1.png')}} @endif" alt class="w-px-40 h-auto rounded-circle">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                    <span class="fw-semibold d-block">
                      @if (Auth::check())
                            {{ Auth::user()->getLongNameAttribute() }}
                        @else
                            Demo
                        @endif
                    </span>
                        <small class="text-muted">{{ ucfirst(Auth::user()->type) }} </small>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        @if(!Auth::user()->hasRole('super-admin')))
        <li>
            <h6 class="dropdown-header">{{__('navbar.personal_settings')}}</h6>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('admin.profile.index', ['user'=> Auth::user()->id]) }}">
                <i class="mdi mdi-account-outline me-2"></i>
                <span class="align-middle">{{__('navbar.my_profile')}}</span>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        @endif

        @if (Auth::check())
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='mdi mdi-logout me-2'></i>
                    <span class="align-middle">Logout</span>
                </a>
            </li>
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
            </form>
        @endif
    </ul>
</li>