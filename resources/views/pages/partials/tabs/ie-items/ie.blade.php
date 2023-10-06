<div class="dz-message mb-3 needsclick">
    {{ __('DZ9T5MS7PB') }}
    <span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
</div>
<form action="/upload" class="dropzone mb-5 needsclick d-inline-flex" id="dropzone-basic">
    <div class="fallback">
        <input name="file" type="file"/>
    </div>
    <div class="form-floating form-floating-outline">
        <select id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true">
            <option value="AK">{{ __('KCS79VA0V3') }}</option>
            <option value="HI">{{ __('HCSO9BZ6MK') }}</option>
            <option value="CA">{{ __('BSKNN4U24P') }}</option>
        </select>
        <label for="select2Basic">{{ __('3WXXA8XEUE') }}</label>
    </div>


</form>


<div class="row import-export-row">
    <div class="col">
        <p class="download-template">Download template</p>
        <p class="upload-template">Upload file</p>
        <p class="import-export-template">Import and create</p>
    </div>
    <div class="arrow-container-images col-2 d-grid">
        <img src="{{ asset('arrow-right.png') }}" alt="" width="100px">
        <img src="{{ asset('arrow-right.png') }}" alt="" width="100px">
    </div>
    <div class="col">
        <input type="text" class="form-control mb-4" placeholder="Fill in the template">
        <input type="text" class="form-control mb-4" placeholder="Check for errors / Import">
        <button class="button-import-export">Export all fields</button>
    </div>
</div>