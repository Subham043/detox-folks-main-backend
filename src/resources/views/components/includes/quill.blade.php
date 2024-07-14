<div>
    <label for="{{$key}}" class="form-label">{{$label}}</label>
    <div id="{{$key}}_quill">{!!$value!!}</div>
    <input type="hidden" id="{{$key}}" name="{{$key}}" value="{{$value}}">
    @error($key)
        <div class="invalid-message">{{ $message }}</div>
    @enderror
</div>
