<div class="col-xxl">
    @php
        do {
               $uniqueCode = \Illuminate\Support\Str::random(8);
           } while (\App\Models\User::where('code', $uniqueCode)->exists());
    @endphp

            <!-- ID -->
    <div class="input-group input-group-lg mb-3">
        <span class="input-group-text">#{{ __('id') }}  </span>
        <input type="text" name="input[code]" value="{{ $uniqueCode }}" class="form-control" readonly placeholder="{{ $uniqueCode }}"/>
    </div>
    <h6 class="mb-b fw-semibold p-3">{{ __('T469H5U4JM') }} </h6>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-e-mail">{{ __('M4F4YK6SXE') }} </label>
        <div class="col-sm-9">
            <input type="text" name="input[e-mail]" id="alignment-e-mail" class="form-control" placeholder="john.doe@yahoo.com" autocomplete="off" />
        </div>
    </div>
    <div class="row mb-3 form-password-toggle">
        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-password">{{ __('XYSY85ASEO') }}</label>
        <div class="col-sm-9">
            <div class="input-group input-group-merge">
                <input type="password" id="alignment-password" name="input[password]" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="alignment-password2"/>
                <span class="input-group-text cursor-pointer" id="alignment-password2"><i class="mdi mdi-eye-off-outline"></i></span>
            </div>
        </div>
    </div>
    <hr class="my-4 mx-n4"/>
    <h6 class="mb-3 fw-semibold p-3">{{ __('7I1PVSNQHG') }}</h6>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-first-name">{{ __('2MDHER017Y') }}</label>
        <div class="col-sm-9">
            <div class="input-group input-group-merge">
                <input type="text" id="alignment-first-name" name="input[first-name]" class="form-control" placeholder="John" aria-label="john" aria-describedby="alignment-first-name"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-last-name">{{ __('TNB1CJGBN3') }}</label>
        <div class="col-sm-9">
            <div class="input-group input-group-merge">
                <input type="text" id="alignment-last-name" name="input[last-name]" class="form-control" placeholder="Doe" aria-label="doe" aria-describedby="alignment-last-name"/>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-user-kind">{{ __('Type') }}</label>
        <div class="col-sm-9">
            <div class="input-group input-group-merge">
                <select name="input[user-kind]">'
                    @if(Auth::user()->hasRole('admin'))
                        <option value="user" selected>{{ __('NI6FSH93D8') }}</option>
                    @endif
                    @if(Auth::user()->hasRole('super-admin'))
                        <option value="admin" selected>{{ __('E9SIYYN7F9') }}</option>
                        <option value="user" selected>{{ __('NI6FSH93D8') }}</option>
                    @endif
                </select>
            </div>
        </div>
    </div>
@if(Auth::user()->hasRole('super-admin'))
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-entity-id">{{ __('UL0XZXPTWA') }}</label>
        <div class="col-sm-9">
            <div class="input-group input-group-merge">
                <select name="input[entity-id]" required>
                    <option value="" disabled >{{ __('UL0XZXPTWA') }}</option>
                @foreach($entities as $entity)
                        <option value="{{ $entity->id }}">{{ __($entity->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @endif
}
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label text-sm-end" for="basic-icon-default-message">{{ __('P852898AQX') }}</label>
        <div class="col-sm-9">
            <div class="input-group input-group-merge">
                <span id="basic-icon-default-additional-info" class="input-group-text"><i class="mdi mdi-message-outline"></i></span>
                <textarea id="basic-icon-default-message" class="form-control" placeholder="Additional information about this contact" aria-label="Additional information about this contact" aria-describedby="basic-icon-default-additional-info"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-3 col-form-label text-sm-end" for="alignment-phone">{{ __('3YE9I7JV7X') }}</label>
        <div class="col-sm-9">
            <input type="text" id="alignment-phone" name="input[phone]" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941"/>
        </div>
    </div>
    <div class="pt-4 pb-4">
        <div class="row justify-content-end">
            <div class="col-sm-9">
                <button type="submit" class="btn btn-primary me-sm-2 me-1">{{ __('HR5SNCKBWT') }}</button>
                <button type="reset" class="btn btn-label-secondary">{{ __('HSGON0EYPT') }}  </button>
            </div>
        </div>
    </div>
</div>

<script>
    datepickerList = document.querySelectorAll('.dob-picker');
    datepickerList.flatpickr()
</script>