@foreach (['danger', 'warning', 'success', 'info'] as $key)
    @if(Session::has('mensaje-'.$key))
        <p class="alert alert-{{ $key }}">{{ Session::get('mensaje-'.$key) }}</p>
    @endif
@endforeach




