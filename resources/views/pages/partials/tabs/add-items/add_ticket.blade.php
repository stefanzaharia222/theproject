<div class="col-xxl add-field-container">
    @php
        do {
               $uniqueCode = \Illuminate\Support\Str::random(8);
           } while (\App\Models\Ticket::where('code', $uniqueCode)->exists());
    @endphp

    <!-- PID -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">#{{ __('id') }}  </span>
        <input type="text"
               title="This is your PID"
               name="input[code]"
               readonly
               class="form-control" value="{{ $uniqueCode }}"
               placeholder="{{ $uniqueCode }}"/>
    </div>

    <!-- TYPE -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">{{ __('TYPE') }}  </span>
        <input type="text"
               name="input[type]"
               class="form-control"
               title="This is your type of ticket"
               readonly
               value="@if(Auth::user()->hasRole('super-admin')) standard @endif @if(Auth::user()->hasRole('admin')) custom @endif"
               placeholder="@if(Auth::user()->hasRole('super-admin')) standard @endif @if(Auth::user()->hasRole('admin')) custom @endif"/>
    </div>

    <!-- Class Name -->
    <div class="input-group input-group-lg  mb-3">
        <span class="input-group-text">{{ __('Class') }}</span>
        <input type="text"
               title="Insert your class name"
               name="input[class-ticket]"
               class="form-control"
               placeholder="{{ __('Choose Class Name') }}"
        />
    </div>

    <!-- LIST OF FIELDS -->
    @if(Auth::user()->hasRole('admin'))
        <p>Here are listed the fields created by you and your Entity because you are an Admin</p>
    @endif
    <div class="list-items-container input-group input-group-lg  mb-3">

            <span class="input-group-text">{{ __('YOSQMJGN7Y') }}</span>
        <select title="Select multiple fields to insert in your Ticket"
                name="input[fields-selected][]"
                class="bulk-select"
                multiple>
            <option value="" disabled selected>{{ __('N6DFWBA7N0') }}</option>
            @foreach($fields['fields'] as $field)
                @if(Auth::user()->hasRole('super-admin'))
                    @if($field->type === 'standard')
                        <option value="{{ $field->id }}">{{ __($field->name) }}</option>
                    @endif
                @endif
                @if(Auth::user()->hasRole('admin'))
                    <option value="{{ $field->id }}">{{ __($field->name) }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <!-- Ticket Name -->
    <div class="input-group input-group-lg  mb-3">
        <span class="input-group-text">{{ __('BFAGM9JB0A') }}</span>
        <input type="text"
               title="Insert your ticket name"
               name="input[language][us][ticket-name][]"
               class="form-control"
               placeholder="{{ __('BFAGM9JB0A') }}"
        />
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>

    <!-- DESCRIPTION -->
    <div class="input-group input-group-lg  mb-3">
        <span class="input-group-text">{{ __('QWON3SR2A1') }}</span>
        <input type="text"
               title="Insert your description name"
               name="input[language][us][description][]"
               class="form-control"
               placeholder="{{ __('QWON3SR2A1') }}"
        />
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>

    <!-- Placeholder -->
    <div class="input-group input-group-lg name-container mb-3">
        <span class="input-group-text">{{ __('Placeholder') }}</span>
        <input type="text"
               name="input[language][us][placeholder][]"
               class="form-control"
               title="Insert placeholder text"
               placeholder="{{ __('Placeholder Text') }}"
        />
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>

    <!-- Tooltip -->
    <div class="input-group input-group-lg name-container mb-3">
        <span class="input-group-text">{{ __('Tooltip') }}</span>
        <input type="text"
               name="input[language][us][tooltip][]"
               class="form-control"
               title="Insert Tooltip"
               placeholder="{{ __('Placeholder Tooltip') }}"
        />
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>

    <div class="field-buttons d-none">
        <button type="submit" class="btn btn-primary">{{ __('EAD26IL30V') }}</button>
        <button type="button" class="btn btn-secondary">{{ __('SCWO19A48M') }}</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#class-field-select option').each(function () {
            $(this).attr('title', $(this).data('tooltip'));
        });

        $('#mySelect').on('mouseleave', function () {
            $('#mySelect option').attr('title', '');
        });
    });
</script>