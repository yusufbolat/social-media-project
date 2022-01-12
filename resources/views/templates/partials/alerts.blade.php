@if (Session::has('info'))
    <div class="alert alert-info mt-3" role="alert">
        {{ Session::get('info') }}
    </div>
@endif