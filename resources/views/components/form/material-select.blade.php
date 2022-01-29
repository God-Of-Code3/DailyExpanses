<div class="form-group @if ($horizontal) form-group-horizontal @endif" data-material-select>
    @if ($labelText)
        <label for="{{ $name }}" class="form-label">{{ $labelText }}</label>
    @endif
    <div class='row row-wrap' {{ $attributes }}>
        {{ $slot }}
    </div>
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" data-material-select-input>
</div>