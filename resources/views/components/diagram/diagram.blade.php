<div class="diagram">
    <div class="diagram-arrow arrow-prev" data-action data-action-click='locate' data-action-click-data='{{ $leftAction }}'>
        <img src="{{ asset('img/prev.svg') }}" alt="Arrow">
        {{ $left }}
    </div>
    <div class="diagram-data">
        <div class="t-center m-3">
            <div class="fz-1-2 fw-1">{{ $text }}</div>
            <div class="fz-3">{{ $period }}</div>
        </div>
        <x-diagram.circle>
            {{ $slot }}
        </x-diagram.circle>
    </div>
    
    <div class="diagram-arrow arrow-next" data-action data-action-click='locate' data-action-click-data='{{ $rightAction }}'>
        {{ $right }}
        <img src="{{ asset('img/next.svg') }}" alt="Arrow">
    </div>
</div>