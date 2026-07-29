<a {{ $attributes->merge([
    'class'=>'btn btn-primary'
]) }}>

    <i class="bi bi-plus-circle"></i>

    {{ $slot }}

</a>