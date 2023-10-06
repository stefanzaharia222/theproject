<div class="nav-align-top mb-4">
    @include('pages.partials.tabs.parts.navbar')
    <div class="tab-content">
        @if(session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif
            @if(session('failed'))
                <div class="alert alert-danger" id="danger-message">
                    {{ session('failed') }}
                </div>
            @endif
        @include('pages.partials.tabs.parts.filters')
        @include('pages.partials.tabs.parts.content')
    </div>
</div>
