<div class="schedule">
    <div class="schedule-area">
        {{ $slot }}
    </div>
    
    <div class="arrows">
        <div class="diagram-arrow arrow-prev">
            <img src="img/prev.svg" alt="Arrow">
            {{ $left }}
        </div>
        <div>
            {{ $period }}
        </div>
        <div class="diagram-arrow arrow-next">
            {{ $right }}
            <img src="img/next.svg" alt="Arrow">
        </div>
    </div>
</div>