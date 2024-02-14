<div class="form-group">
    <x-label for="status">Status
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </x-label>
    @if ($search)
        <select name="status" id="status" class="form-control" style="width: 100%;">
            <option value="">Select Status</option>
            @if (config('constents.status'))
                @foreach (config('constents.status') as $key => $status)
                    <option value="{{ $key }}">{{ $status }}</option>
                @endforeach
            @endif
        </select>
    @else
        <select name="status" id="status" class="form-control" style="width: 100%;">
            @foreach (config('constents.status') as $key => $status)
                @if (!$isedit && $key == 0)
                @else
                    <option value="{{ $key }}" {{ old('status', $selected) == $key ? 'selected' : '' }}>
                        {{ $status }}</option>
                @endif
            @endforeach
            {{-- @if ($isedit)
                <option value="0" {{ old('status', $selected) == 0 ? 'selected' : '' }}>Pending</option>
            @endif
            <option value="1" {{ old('status', $selected) == 1 ? 'selected' : '' }}>Active</option>
            <option value="2" {{ old('status', $selected) == 2 ? 'selected' : '' }}>Inactive</option> --}}
        </select>
        <x-input-error name="status" />
    @endif
</div>
