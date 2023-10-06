<p class="description-{{ $tag }} d-none">* {{ $description }}</p>

<div class="add-container-{{ $tag }} d-none">
    <!-- NAME -->
    <div class="input-group input-group-lg name-container mb-3">
        <span class="input-group-text">{{ __('R0TYJK2A10') }}</span>
        <input type="text" name="input[language][us][name][]" class="form-control" placeholder="{{ __('Placeholder Name') }}" title="Insert the name of the field" />
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>

    <!-- Description -->
    <div class="input-group input-group-lg name-container mb-3">
        <span class="input-group-text">{{ __('QWON3SR2A1') }}</span>
        <textarea name="input[language][us][description][]" class="form-control" cols="30" rows="2" placeholder="{{ __('Placeholder Description') }}" title="Insert description" ></textarea>
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>

    <!-- Placeholder -->
    <div class="input-group input-group-lg name-container mb-3">
        <span class="input-group-text">{{ __('Placeholder') }}</span>
        <input type="text" name="input[language][us][placeholder][]" class="form-control" title="Insert placeholder text" placeholder="{{ __('Placeholder Text') }}" />
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>

    <!-- Tooltip -->
    <div class="input-group input-group-lg name-container mb-3">
        <span class="input-group-text">{{ __('Tooltip') }}</span>
        <input type="text" name="input[language][us][tooltip][]" class="form-control" title="Insert Tooltip" placeholder="{{ __('Placeholder Tooltip') }}" />
        <button type="button" class="btn btn-primary add-language">+</button>
    </div>

</div>
<div class="buttons-{{ $tag }} d-none">
    <button type="submit" class="btn btn-primary">{{ __('EAD26IL30V') }}</button>
    <button type="button" class="btn btn-secondary">{{ __('SCWO19A48M') }}</button>
</div>