<form action="{{ route($action) }}" class="form" method="POST" enctype='multipart/form-data'>
    @csrf
    {{ $slot }}
    <button>{{ $buttonText }}</button>
</form>