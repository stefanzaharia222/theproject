<div class="col-xxl">
    @php
        do {
               $uniqueCode = \Illuminate\Support\Str::random(8);
           } while (\App\Models\Assignment::where('code', $uniqueCode)->exists());
    @endphp

            <!-- ID -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">#{{ __('id') }}  </span>
        <input type="text" name="input[code]" value="{{ $uniqueCode }}" class="form-control" readonly placeholder="{{ $uniqueCode }}"/>
    </div>
    <!-- LABEL -->
    <div class="input-group input-group-lg  mb-3">
        <span class="input-group-text">{{ __('Role Name') }}</span>
        <input type="text" name="input[language][us][role-name]" class="form-control" placeholder="{{ __('Role Name') }}"/>
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>
    <button type="submit" class="btn btn-primary">{{ __('EAD26IL30V') }}</button>
    <button type="button" class="btn btn-secondary">{{ __('SCWO19A48M') }}</button>
</div>