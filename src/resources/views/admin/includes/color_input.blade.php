<div>
    <label for="{{$key}}" class="form-label">{{$label}}</label>
    <input type="color" class="form-control" name="{{$key}}" id="{{$key}}" value="{{$value}}">
    @error($key)
        <div class="invalid-message">{{ $message }}</div>
    @enderror
</div>
