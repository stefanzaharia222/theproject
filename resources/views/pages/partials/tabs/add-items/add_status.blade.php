<div class="col-xxl add-field-container">
    @php
        do {
               $uniqueCode = \Illuminate\Support\Str::random(8);
           } while (\App\Models\Status::where('code', $uniqueCode)->exists());
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

    <!-- LIST OF TICKETS -->
    <div class="list-items-container input-group input-group-lg  mb-3">
        <span class="input-group-text">{{ __('All Tickets') }}</span>
        <select title="Select multiple fields to insert in your Ticket"
                name="input[tickets-selected][]"
                class="bulk-select"
                multiple>
            <option value="" disabled>{{ __('Select Ticket') }}</option>
            @foreach($tickets['tickets'] as $ticket)
                @if(Auth::user()->hasRole('super-admin'))
                    <option value="{{ $ticket->id }}">{{ __($ticket->name) }}</option>
                @endif
                @if(Auth::user()->hasRole('admin'))
                    <option value="{{ $ticket->id }}">{{ __($ticket->name) }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <!-- Choose Status -->
    <div class="input-group input-group-lg name-container mb-3">
        <span class="input-group-text">{{ __('Status') }}</span>
        <select name="input[class-status]"
                class="bulk-select class-field-select"
                required
        >
            <option value="" disabled selected>{{ __('Choose Status') }}</option>
            @foreach($select_option as $option)
                <option value="{{ $option['tag'] }}" data-tooltip="{{ $option['tooltip'] }}">{{ __($option['option_name']) }}</option>
            @endforeach
        </select>
    </div>

    <!-- Name -->
    <div class="input-group input-group-lg  mb-3">
        <span class="input-group-text">{{ __('Name') }}</span>
        <input type="text"
               title="Insert your description name"
               name="input[language][us][name][]"
               class="form-control"
               placeholder="{{ __('Name') }}"
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