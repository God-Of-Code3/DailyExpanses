<div class="schedule">
    <div class="schedule-area">
        {{ $slot }}
    </div>
    
    <div class="arrows">
        <div class="diagram-arrow arrow-prev" data-action data-action-click='locate' data-action-click-data='{{ $leftAction }}'>
            @if($left)
                <img src="{{ asset('img/prev.svg') }}" alt="Arrow">
                {{ $left }}
            @endif
        </div>
        <div>
            {{ $period }}
        </div>
        <div class="diagram-arrow arrow-next" data-action data-action-click='locate' data-action-click-data='{{ $rightAction }}'>
            @if($right)
                {{ $right }}
                <img src="{{ asset('img/next.svg') }}" alt="Arrow">
            @endif
        </div>
    </div>
</div>