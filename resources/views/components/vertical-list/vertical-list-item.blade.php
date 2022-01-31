<div class="vertical-list-item">
    <div class="left"><x-badge color='{{ $color }}' icon='{{ $icon }}'>{{ $categoryName }}</x-badge></div>
    <div class="right"><div class="value value-@if ($positive) green @else red @endif">{{ $sumText }}</div><img src="{{ asset('img/arrow.svg') }}" alt="Arrow" class="arrow-button" data-action data-action-click='locate' data-action-click-data='{{ $href }}'></div>
</div>