<div>
				<label for="{{ $key }}" class="form-label">{{ $label }}</label>
				<textarea class="form-control {{ $key }}" name="{{ $key }}" id="{{ $key }}">{{ $value }}</textarea>
				@error($key)
								<div class="invalid-message">{{ $message }}</div>
				@enderror
</div>
