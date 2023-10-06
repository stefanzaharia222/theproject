@extends('layouts/layoutMaster')

@section('title', 'Login Cover - Pages')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages-auth.js')}}"></script>
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="{{url('/')}}" class="auth-cover-brand d-flex align-items-center gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#666cff'])</span>
            <span class="app-brand-text demo text-heading fw-bold">{{config('variables.templateName')}}</span>
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">

            <!-- /Left Section -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-5 pb-2">
                <img src="{{asset('assets/img/illustrations/auth-login-illustration-'.$configData['style'].'.png') }}" class="auth-cover-illustration w-100" alt="auth-illustration" data-app-light-img="illustrations/auth-login-illustration-light.png" data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
                <img src="{{asset('assets/img/illustrations/auth-cover-login-mask-'.$configData['style'].'.png') }}" class="authentication-image" alt="mask" data-app-light-img="illustrations/auth-cover-login-mask-light.png" data-app-dark-img="illustrations/auth-cover-login-mask-dark.png" />
            </div>
            <!-- /Left Section -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
                @include('layouts.sections.navbar.nav_sections.lang')

                <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                    @if(session('failed'))
                        <div class="alert alert-danger" id="danger-message">
                            {{ session('failed') }}
                        </div>
                    @endif

                        <h4 class="mb-2 fw-semibold">{{ __('Welcome to') }} {{env('APP_NAME')}}! 👋</h4>
                    <p class="mb-4">{{ __('Please sign-in to your account and start the adventure') }}</p>

                    <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input
                                    value="{{ old('email') }}"
                                    type="email" class="form-control @error('email') is-invalid  @enderror"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email" autofocus>
                            <label for="email">Email</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password"
                                               id="password"
                                               class="form-control  @error('password') is-invalid @enderror"
                                               name="password"
                                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                               required autocomplete="current-password"
                                               aria-describedby="password" />
                                        <label for="password">Password</label>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input"  name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} id="remember-me">
                                <label class="form-check-label" for="remember-me">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="float-end mb-1">
                                <span>{{ __('Forgot Password') }}?</span>
                            </a>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100">
                            Sign in
                        </button>
                    </form>

{{--                    <div class="divider my-4">--}}
{{--                        <div class="divider-text">or</div>--}}
{{--                    </div>--}}

{{--                    <div class="d-flex justify-content-center gap-2">--}}
{{--                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-facebook">--}}
{{--                            <i class="tf-icons mdi mdi-24px mdi-facebook"></i>--}}
{{--                        </a>--}}

{{--                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-twitter">--}}
{{--                            <i class="tf-icons mdi mdi-24px mdi-twitter"></i>--}}
{{--                        </a>--}}

{{--                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-github">--}}
{{--                            <i class="tf-icons mdi mdi-24px mdi-github"></i>--}}
{{--                        </a>--}}

{{--                        <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-google-plus">--}}
{{--                            <i class="tf-icons mdi mdi-24px mdi-google"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
@endsection
