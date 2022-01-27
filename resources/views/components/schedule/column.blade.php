<div class="column">
    <div class="column-figures" {{ $attributes }}>
        <div class="column-figure" style="height: {{ $mainPercent }}%"></div>
        @if ($transparentPercent)
            <div class="column-figure transparent" style="height: {{ $transparentPercent }}%"></div>
        @endif
    </div>
    <div class="column-text">{{ $slot }}</div>
</div>