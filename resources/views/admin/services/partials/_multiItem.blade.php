@foreach($items as $item)
    <li>
        <input class="keyField" type="hidden" name="headers[{{ $loop->index }}][key]"
               value="{{ $item['key'] }}">
        <input class="valueField" type="hidden" name="headers[{{ $loop->index }}][value]"
               value="{{ $item['value'] }}">
        <span class="contentInfo col-md-3"><strong>{{ $item['key'] }}</strong>: {{ $item['value'] }}</span>
        <button class="btn btn-danger" onclick="removeItem(this)">Remove</button>
        @if ($errors->has('headers.' . $loop->index . '.key'))
            <span class="help-block">
                <strong>{{ $errors->first('headers.' . $loop->index . '.key') }}</strong>
            </span>
        @endif
        @if ($errors->has('headers.' . $loop->index . '.value'))
            <span class="help-block">
                <strong>{{ $errors->first('headers.' . $loop->index . '.value') }}</strong>
            </span>
        @endif
    </li>
@endforeach