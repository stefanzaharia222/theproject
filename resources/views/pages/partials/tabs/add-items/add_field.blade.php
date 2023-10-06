<div class="col-xxl add-field-container">
    @php
        do {
               $uniqueCode = \Illuminate\Support\Str::random(8);
           } while (\App\Models\Field::where('code', $uniqueCode)->exists());
    @endphp

    <!-- ID -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">#{{ __('id') }}  </span>
        <input type="text" name="input[code]" class="form-control unchanged" value="{{ $uniqueCode }}" readonly placeholder="{{ $uniqueCode }}"/>
    </div>


    <!-- TYPE -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">{{ __('TYPE') }}  </span>
        <input type="text" name="input[type]" class="form-control unchanged"
               value="@if(Auth::user()->hasRole('super-admin')) standard @endif @if(Auth::user()->hasRole('admin')) custom @endif" readonly
               placeholder="@if(Auth::user()->hasRole('super-admin')) standard @endif @if(Auth::user()->hasRole('admin')) custom @endif"/>
    </div>

    <!-- CLASS -->
    <div class="input-group input-group-lg name-container mb-3">
        <span class="input-group-text">{{ __('3WXXA8XEUE') }}</span>
        <select name="input[class-field]" class="bulk-select class-field-select" id="class-field-select">
            <option value="" disabled selected>{{ __('3WXXA8XEUE') }}</option>
            @foreach($select_option as $option)
                <option value="{{ $option['tag'] }}" data-tooltip="{{ $option['tooltip'] }}">{{ __($option['option_name']) }}</option>
            @endforeach
        </select>
    </div>
    @foreach($select_option as $option)
        @if($option['tag'] !== '')
            @include('pages.partials.tabs.add-items.select-options.field_kind.add_' . $option['tag'],
                [
                    'placeholder' => $option['placeholder'],
                    'tag' => $option['tag'],
                    'description' => $option['description']
                ]
            )
        @endif
    @endforeach
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