@props([
    'label',
    'name',
])

<div class="form-check mb-3">

    <input
        class="form-check-input"
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        value="1"
        {{ old($name, $attributes->get('checked')) ? 'checked' : '' }}
    >

    <label
        class="form-check-label"
        for="{{ $name }}"
    >
        {{ $label }}
    </label>

</div>