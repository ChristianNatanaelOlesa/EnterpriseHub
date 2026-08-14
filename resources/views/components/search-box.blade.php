<form method="GET">

    <div class="input-group">

        <span class="input-group-text">

            <i class="bi bi-search"></i>

        </span>

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="{{ $placeholder }}">

        @if(request('search'))

            <a href="{{ url()->current() }}"
               class="btn btn-outline-secondary">

                Clear

            </a>

        @endif

    </div>

</form>