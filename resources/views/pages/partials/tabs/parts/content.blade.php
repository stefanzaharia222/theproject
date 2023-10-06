<!-- Listing Items -->
<div class="tab-pane fade pt-2 show active" id="navs-pills-top-all" role="tabpanel">
    <!-- TABLE ALL -->
    <div class="card d-none">
        <input type="hidden" id="items-list" data-allitems="{{ $data }}">
        <input type="hidden" id="columns-list" data-columns="{{ json_encode($columns) }}">
        <form action="{{ route('form_bulk_action') }}" method="POST" id="all_items_form">
            @csrf
            <input type="hidden" name="type-form" value="{{ Route::currentRouteName() }}">
            <label for="form-action-select" class=" m-3">
                <select name="form-action-select" id="tab1-select" class="bulk-select mt-2">
                    <option value="">{{ __('Q174MLMGQY') }}</option>
                    <option value="bulk_delete">{{ __('L4T5O0LDD9') }}</option>
                    @if(Auth::user()->hasRole('super-admin') && Route::currentRouteName() == 'users')
                        <option value="change-entity">{{ __('RGZ13B20U2') }}</option>
                    @endif
                    @if(request()->is('users*'))
                        <option value="change-status">{{ __('Change Status') }}</option>
                    @endif
                </select>
            </label>
            <button type="button" class="submit-button btn btn-primary waves-effect waves-light">{{ __("Execute") }}</button>
            <br>
            <a class="select-all-items m-3" href="javascript:void(0)">Select all items</a>
            <a class="deselect-all-items m-3" href="javascript:void(0)">Deselect all items</a>
            <div class="card-datatable table-responsive pt-0">
                <table id="card-datatable">
                    <thead>
                    <tr>
                        <th></th>
                        @foreach($columns as $column)
                            <th>{{ __($column) }}</th>
                        @endforeach
                    </tr>
                    </thead>
                </table>
            </div>
        </form>
    </div>
    <!--/ TABLE ALL -->
</div>
<!-- /Listing Items -->

<!-- Adding Items -->
<div class="tab-pane fade " id="navs-pills-top-add" role="tabpanel">
    <h1>{{ __("GUM3V9B8RD_$tabName")  }}</h1>
    <!-- Tabs Form -->
    <form action="{{ route('form_bulk_action') }}" method="POST" id="add_item_form" autocomplete="off">
        @csrf
        <input type="hidden" name="type-form" value="{{ $tabName }}"/>
        <select name="form-action-select" class="d-none">
            <option value="add_single_action" selected></option>
        </select>
        @if($tabName == 'fields')
            @include('pages.partials.tabs.add-items.add_field')
        @endif
        @if($tabName == 'users')
            @include('pages.partials.tabs.add-items.add_user')
        @endif
        @if($tabName == 'tickets')
            @include('pages.partials.tabs.add-items.add_ticket')
        @endif
        @if($tabName == 'entities')
            @include('pages.partials.tabs.add-items.add_entity')
        @endif
        @if($tabName == 'tasks')
            @include('pages.partials.tabs.add-items.add_task')
        @endif
        @if($tabName == 'status')
            @include('pages.partials.tabs.add-items.add_status')
        @endif
        @if($tabName == 'process')
            @include('pages.partials.tabs.add-items.add_process')
        @endif
        @if($tabName == 'automations')
            @include('pages.partials.tabs.add-items.add_automations')
        @endif
        @if($tabName == 'groups')
            @include('pages.partials.tabs.add-items.add_groups')
        @endif
        @if($tabName == 'roles')
            @include('pages.partials.tabs.add-items.add_assignments')
        @endif
        @if($tabName == 'profiles')
            @include('pages.partials.tabs.add-items.add_profiles')
        @endif
    </form>
</div>
<!-- /Second Tab content -->

<!-- Import/Export Items -->
<div class="tab-pane fade" id="navs-pills-top-import-export" role="tabpanel">
    @include('pages.partials.tabs.ie-items.ie')
</div>
<!-- /Import/Export Items -->

<!-- Archive Items -->
<div class="tab-pane fade" id="navs-pills-top-archive" role="tabpanel">
    <input type="hidden" id="items-list-deleted" data-allitems="{{ ( $data_deleted ) }}">
    <form action="{{ route('form_bulk_action') }}" method="POST" id="all_items_form_archive">
        @csrf
        <input type="hidden" name="type-form" value="{{ Route::currentRouteName() }}">
        <label for="form-action-select" class=" m-3">{{ __('WQ61LIPPRO') }}
            <select name="form-action-select" id="bulk-select-archive" class="bulk-select mt-2">
                <option value="">{{ __('Q174MLMGQY') }}</option>
                <option value="bulk_restore">{{ __('V1DQI4KRHT') }}</option>
            </select>
        </label>
        <button type="button" class="submit-button btn btn-primary waves-effect waves-light">{{ __('EXECUTE') }}</button>
        <br>
        <a class="select-all-items m-3" href="javascript:void(0)">Select all items</a>
        <a class="deselect-all-items m-3" href="javascript:void(0)">Deselect all items</a>
        <div class="card-datatable table-responsive pt-0">
            <table id="card-datatable-deleted">
                <thead>
                <tr>
                    <th></th>
                    @foreach($columns as $column)
                        <th>{{ __($column) }}</th>
                    @endforeach
                </tr>
                </thead>
            </table>
        </div>
    </form>
</div>
<!-- /Archive Items -->

<!-- Bootstrap Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content d-flex flex-column">
            <div class="modal-body flex-grow-1 p-0">
            </div>
        </div>
    </div>
</div>

