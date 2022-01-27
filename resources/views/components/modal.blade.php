<div class="modal" {{ $attributes }} id="{{ $id }}">
    <div class="header">
        <div class="header-element modal-close"  data-action data-action-click='deactivate' data-action-click-data='{{ $id }}'>
            <img src="{{ asset('img/cross.svg') }}" alt="cross">
        </div>
        <div class="header-element page-title">{{ $title }}</div>
        <div class="header-element"></div>
    </div>
    <div class="container">
        {{ $slot }}
    </div>
    
</div>