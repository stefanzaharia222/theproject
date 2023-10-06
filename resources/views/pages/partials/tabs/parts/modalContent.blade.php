<!-- Multi Column with Form Separator -->
<div class="card">
    <form class="card-body form-update-modal" action="{{ route('form_bulk_action') }}" method="POST">
        @foreach($data as $key => $value)
            @php
               $listReadonly = ['id', 'tag', 'user','type', 'entity', 'entity_id', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at', 'code', 'pid'];
            @endphp
            @if(gettype($value) != 'array')

            <h6 class="mt-4">{{ __($key) }}</h6>
            <div class="col">
                <div class="form-floating form-floating-outline">
                    <input type="text" value="{{ $value }}" @if($key == 'user' || $key == 'entity') disabled @endif @if(in_array($key, $listReadonly)) readonly @endif class="form-control w-100" name="{{ $key }}" placeholder="{{$key}}" />
                </div>
            </div>
            @endif

        @endforeach
            <div class="mt-5">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Delete Record</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary update-button">Update changes</button>
            </div>
    </form>
</div>
