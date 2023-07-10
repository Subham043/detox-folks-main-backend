<div>
    <label for="{{$key}}" class="form-label">{{$label}}</label>
    <input class="form-control" type="file" name="{{$key}}" id="{{$key}}">
    @error($key)
        <div class="invalid-message">{{ $message }}</div>
    @enderror
</div>
