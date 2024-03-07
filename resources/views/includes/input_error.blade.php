@if($errors->has($field))
    <div class="error-message">{{ $errors->first($field) }}</div>
@endif