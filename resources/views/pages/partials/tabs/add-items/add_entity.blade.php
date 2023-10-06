<div class="col-xxl">
    @php
        do {
               $uniqueCode = \Illuminate\Support\Str::random(8);
           } while (\App\Models\Entity::where('code', $uniqueCode)->exists());
    @endphp

            <!-- ID -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">#{{ __('id') }}  </span>
        <input type="text" name="input[code]" value="{{ $uniqueCode }}" class="form-control" readonly placeholder="{{ $uniqueCode }}"/>
    </div>
    <!-- Entity Name -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">{{ __('LXA341A4DZ') }}</span>
        <input type="text" name="input[entity-name]" class="form-control" placeholder="{{ __('P2RIDRFCTO') }}"/>
    </div>
    <!-- Entity Description -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">{{ __('Description') }}</span>
        <input type="text" name="input[entity-description]" class="form-control" placeholder="{{ __('Description') }}"/>
    </div>
    <!-- Entity Address -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">{{ __('Address') }}</span>
        <input type="text" name="input[entity-address]" class="form-control" placeholder="{{ __('Address') }}"/>
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
    <button type="button" class="btn btn-secondary">{{ __('SCWO19A48M') }}</button>
</div>