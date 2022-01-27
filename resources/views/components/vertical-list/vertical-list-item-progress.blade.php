<div class="vertical-list-item-progress">
    <div class="progress-bar">
        <div class="progress" style="width: {{ $percent }}%; background-color: {{ $color }}; box-shadow: 10px 0px 10px 5px {{ $color }};"></div>
    </div>
    <div class="vertical-list-item">
        <div class="left">{{ $categoryName }}</div>
        <div class="right"><div class="fw-1 mr-1">{{ $sumText }}</div><img src="{{ asset('img/arrow2.svg') }}" alt="Arrow" class="arrow-button"></div>
    </div>
</div>
