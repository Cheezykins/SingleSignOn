@foreach($items as $item)
    <li>
        <input class="keyField" type="hidden" name="{{ $type }}[{{ $loop->index }}][key]"
               value="{{ $item['key'] }}">
        <input class="valueField" type="hidden" name="{{ $type }}[{{ $loop->index }}][value]"
               value="{{ $item['value'] }}">
        <div class="col-md-3 col-md-offset-4 showKey">
            {{ $item['key'] }}
        </div>
        <div class="col-md-2 showValue">
            {{ $item['value'] }}
        </div>
        <div class="col-md-2 showButton">
            <button class="btn btn-danger btn-sm" onclick="removeItem(this)">Remove</button>
        </div>
        @foreach(['key', 'value'] as $component)
            @if ($errors->has($type . '.' . $loop->index . '.' . $component))
                <div class="help-block">
                    <strong>{{ $errors->first($type . '.' . $loop->index . '.' . $component) }}</strong>
                </div>
            @endif
        @endforeach
        <div class="clearfix"></div>
    </li>
@endforeach