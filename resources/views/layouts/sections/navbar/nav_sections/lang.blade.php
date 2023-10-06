<li class="nav-item dropdown-language dropdown me-1 me-xl-0">
    <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <i class='mdi mdi-translate mdi-24px'></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        @foreach($available_locales as $locale_name => $available_locale)
            @if($available_locale === $current_locale)
                <li>
                    <a class="dropdown-item locale" href="javascript:void(0)">
                        <span class="align-middle bold">{{$locale_name}}</span>
                    </a>
                </li>
            @else
                <li>
                    <a class="dropdown-item locale" href="{{route('set-locale', ['locale' => $available_locale])}}">
                        <span class="align-middle">{{$locale_name}}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</li>