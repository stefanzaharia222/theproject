
@extends('layouts/layoutMaster')

@section('title', 'Reset Password')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
    <script src="{{asset('assets/vendor/libs/toastr/toastr.js')}}"></script>
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
    <script src="{{asset('assets/js/ui-toasts.js')}}"></script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages-auth.js')}}"></script>
@endsection

@section('content')
    <div class="position-relative">
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
                    <img src="{{asset('assets/img/illustrations/auth-reset-password-illustration-'.$configData['style'].'.png') }}" class="auth-cover-illustration w-100" alt="auth-illustration" data-app-light-img="illustrations/auth-reset-password-illustration-light.png" data-app-dark-img="illustrations/auth-reset-password-illustration-dark.png" />
                    <img src="{{asset('assets/img/illustrations/auth-cover-reset-password-mask-'.$configData['style'].'.png') }}" class="authentication-image" alt="mask" data-app-light-img="illustrations/auth-cover-reset-password-mask-light.png" data-app-dark-img="illustrations/auth-cover-reset-password-mask-dark.png" />
                </div>
                <!-- /Left Section -->

                <!-- Reset Password -->
                <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5 px-4 py-4">
                    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                        @if (session('status'))
                            @if (session('send'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <p class="mb-4">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                            <p class="mb-4">{{ __('If you did not receive the email') }}</p>

                            <form id="formAuthentication" class="mb-3" action="{{ route('verification.send') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary d-grid w-100">
                                    {{ __('click here to request another') }}
                                </button>
                            </form>
                        @else
                        <h4 class="mb-2 fw-semibold">{{ __('Verify Your Email Address') }} 🔒</h4>
                        <form id="formAuthentication" class="mb-3" action="{{route('password.email')}}" method="POST">
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
                            <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
                                Set new password
                            </button>
                            <div class="text-center">
                                <a href="{{route('login')}}" class="d-flex align-items-center justify-content-center">
                                    <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px"></i>
                                    Back to login
                                </a>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
                <!-- /Reset Password -->
            </div>
        </div>
    </div>
@endsection


{{--@extends('layouts.app')--}}
{{--@section('content')--}}

{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>--}}

{{--                    <div class="card-body">--}}
{{--                        @if (session('status'))--}}
{{--                            <div class="alert alert-success" role="alert">--}}
{{--                                {{ session('status') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}--}}
{{--                        <form method="POST" action="{{ route('password.email') }}">--}}
{{--                            @csrf--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                    @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Email Password Reset Link') }}</button>.--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--@endsection--}}
