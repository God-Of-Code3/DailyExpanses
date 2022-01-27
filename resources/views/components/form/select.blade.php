<div class="form-group @if ($horizontal) form-group-horizontal @endif">
    @if ($labelText)
        <label for="{{ $name }}" class="form-label">{{ $labelText }}</label>
    @endif
    <select class="" id="{{ $name }}" name="{{ $name }}" {{ $attributes }}>
        {{ $slot }}
    </select>
</div>