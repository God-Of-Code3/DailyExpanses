<div class="column">
    <div class="column-text">
        {{ $text }}
    </div>
    <div class="column-data" style='height: calc((100% - 15px) / 100 * {{ $height }});'>
        {{ $slot }}
    </div>
    
</div>