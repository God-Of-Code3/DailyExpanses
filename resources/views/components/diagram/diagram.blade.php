<div class="diagram">
    <div class="diagram-arrow arrow-prev">
        <img src="img/prev.svg" alt="Arrow">
        дек
    </div>
    <div class="diagram-data">
        <div class="t-center m-3">
            <div class="fz-1-2 fw-1">64 000 Р</div>
            <div class="fz-3">январь 2022</div>
        </div>
        <x-diagram.circle>
            {{ $slot }}
        </x-diagram.circle>
    </div>
    
    <div class="diagram-arrow arrow-next">
        фев
        <img src="img/next.svg" alt="Arrow">
    </div>
</div>