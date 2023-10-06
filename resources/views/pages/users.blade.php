@php
    $configData = Helper::appClasses();
@endphp
@extends('layouts.layoutMaster')
@section('title', 'FIELDS')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
@endsection

<!-- Page -->
@section('page-style')
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
    <script>
        // Define a JavaScript variable with the app locale value
        var appLocale = "{{ config('app.locale') }}";
    </script>
    <script src="{{ asset('../js/custom-datatables.js') }}"></script>
    <script src="{{asset('assets/js/forms-tagify.js')}}"></script>
@endsection

@section('content')
    @include('pages.partials.tabs.tabs', [
        'tabName' => 'users',
        'data' => $users,
        'data_deleted' => $users_deleted,
        'columns' => [
            '',
            'id',
            'first_name',
            'last_name',
            'code',
            'status',
            'email',
            'phone',
            'additional_contact_info',
            'type',
            'entity_id',
            'email_verified_at',
            'created_at',
            'updated_at',
            'deleted_at',
        ]
    ])

@endsection
