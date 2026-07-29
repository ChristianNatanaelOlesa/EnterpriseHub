@props([
    'label',
    'name',
    'type' => 'text',
    'required' => false,
])

<div class="mb-3">

    <label for="{{ $name }}" class="form-label">

        {{ $label }}

        @if($required)
            <span class="text-danger">*</span>
        @endif

    </label>

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $attributes->get('value')) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'form-control'.($errors->has($name) ? ' is-invalid' : '')
        ]) }}
    >

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>