<div class="vertical-list-item">
    <div class="left"><x-badge color='{{ $color }}' icon='{{ $icon }}'>{{ $categoryName }}</x-badge></div>
    <div class="right"><div class="value value-@if ($positive) green @else red @endif">{{ $sumText }}</div><img src="{{ asset('img/arrow.svg') }}" alt="Arrow" class="arrow-button"></div>
</div>