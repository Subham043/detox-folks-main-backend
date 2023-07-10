<div>
    <label for="{{$key}}" class="form-label">{{$label}}</label>
    <select class="form-control" name="{{$key}}[]" id="{{$key}}" multiple></select>
    @error($key)
        <div class="invalid-message">{{ $message }}</div>
    @enderror
</div>
