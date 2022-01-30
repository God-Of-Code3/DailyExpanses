<div class="diagram">
    <div class="diagram-arrow arrow-prev">
        <img src="img/prev.svg" alt="Arrow">
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
    
    <div class="diagram-arrow arrow-next">
        {{ $right }}
        <img src="img/next.svg" alt="Arrow">
    </div>
</div>