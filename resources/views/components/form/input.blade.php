<div class="form-group @if ($horizontal) form-group-horizontal @endif">
    @if ($labelText)
        <label for="{{ $name }}" class="form-label">{{ $labelText }}</label>
    @endif
    <input type="{{ $type }}" class="" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" {{ $attributes }}/>
    {{ $slot }}
</div>