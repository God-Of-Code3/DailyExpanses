<form action="{{ route($action) }}" class="form" method="POST" enctype='multipart/form-data'>
    @csrf
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    {{ $slot }}
    <button>{{ $buttonText }}</button>
</form>