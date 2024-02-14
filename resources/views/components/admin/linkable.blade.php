@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('webroot/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('webroot/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <x-label for="menu_type">Menu Type<span class="text-danger">*</span></x-label>
            <select name="menu_type" id="menu_type" class="form-control">
                <option value="1" {{ old('menu_type', $selectedMenutype) == 1 ? 'selected' : '' }}>Page</option>
                <option value="2" {{ old('menu_type', $selectedMenutype) == 2 ? 'selected' : '' }}>Module</option>
                <option value="3" {{ old('menu_type', $selectedMenutype) == 3 ? 'selected' : '' }}>Custom URL
                </option>
                <option value="4" {{ old('menu_type', $selectedMenutype) == 4 ? 'selected' : '' }}>Hash</option>
            </select>
            <x-input-error name="menu_type" />
        </div>
    </div>
    <div class="col-md-6" id="linkable">
        @if (old('menu_type', $selectedMenutype))
            @if (old('menu_type', $selectedMenutype) == 1)
                <x-label for="fk_page_id">Page <span class="text-danger">*</span></x-label>
                <div class="select2-purple">
                    <select name="fk_page_id" class="form-control">
                        <option value="">Select Page</option>
                        @if ($front_menu_types)
                            @foreach ($pages as $id => $slug)
                                <option value="{{ $id }}"
                                    {{ old('fk_page_id', $selectedPage) == $id ? 'selected' : '' }}>{{ $slug }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <x-input-error name="fk_page_id" />
                </div>
            @elseif(old('menu_type', $selectedMenutype) == 2)
                <x-label for="fk_page_id">Module {{ $selectedRoute }}<span class="text-danger">*</span></x-label>
                <div class="select2-purple">
                    <select name="fk_page_id" class="form-control">
                        <option value="">Select Module</option>
                        @if ($access_list)
                            @foreach ($access_list as $id => $slug)
                                <option value="{{ $id }}"
                                    {{ old('fk_page_id', $selectedRoute) == $id ? 'selected' : '' }}>
                                    {{ $slug }}</option>
                            @endforeach
                        @endif
                    </select>
                    <x-input-error name="fk_page_id" />
                </div>
            @elseif(old('menu_type', $selectedMenutype) == 3)
                <x-label for="fk_page_id">Custom URL <span class="text-danger">*</span></x-label>
                <div class="select2-purple">
                    <input type="text" name="fk_page_id" placeholder="Enter the Current URL" class="form-control"
                        value="{{ old('fk_page_id', $selectedCustomurl) }}" />
                    <x-input-error name="fk_page_id" />
                </div>
            @else
                <x-label for="fk_page_id">Hash <span class="text-danger">*</span></x-label>
                <div class="select2-purple">
                    <input type="text" name="fk_page_id" placeholder="Enter the Current URL" class="form-control"
                        value="#" readonly />
                    <x-input-error name="fk_page_id" />
                </div>
            @endif
        @else
            <x-label for="fk_page_id">Page <span class="text-danger">*</span></x-label>
            <div class="select2-purple">
                <select name="fk_page_id" class="form-control">
                    <option value="">Select Page</option>
                    @if ($front_menu_types)
                        @foreach ($pages as $id => $slug)
                            <option value="{{ $id }}">{{ $slug }}</option>
                        @endforeach
                    @endif
                </select>
                <x-input-error name="fk_page_id" />
            </div>
        @endif
    </div>
</div>
@push('scripts')
    <script src="{{ asset('webroot/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2()
        const dropdown = {
            1: JSON.parse('<?php echo json_encode($pages); ?>'),
            2: JSON.parse('<?php echo json_encode($access_list); ?>')
        };
        $("#menu_type").on("change", function() {
            const value = $(this).val();
            console.log(value);
            loader.show();
            setTimeout(() => {
                if (dropdown.hasOwnProperty(value)) {
                    const label = ((value == 1) ? 'Page' : 'Module');
                    let options =
                        `<select name="fk_page_id" class="form-control"><option value="">Select ${label}</option>`;
                    var newOption = [];
                    for (id in dropdown[value]) {
                        options += `<option value="${id}">${dropdown[value][id]}</option>`;
                        newOption.push({
                            id: id,
                            text: dropdown[value][id]
                        });
                    }
                    options += '</select>';
                    $("#linkable label").html(label + ' <span class="text-danger">*</span>');
                    $("#linkable .select2-purple").html(options);
                    console.log(newOption);
                    $(".select2").select2({
                        data: newOption
                    });
                } else if (value == 3) {
                    const label = 'Custom URL';
                    $("#linkable label").html(label + ' <span class="text-danger">*</span>');
                    let input =
                        `<input type="text" name="fk_page_id" placeholder="Enter the ${label}" class="form-control" />`
                    $("#linkable .select2-purple").html(input);
                } else {
                    const label = 'Hash';
                    $("#linkable label").html(label + ' <span class="text-danger">*</span>');
                    let input =
                        `<input type="text" name="fk_page_id" value="#" readonly class="form-control" />`
                    $("#linkable .select2-purple").html(input);
                }
                $(".select2").trigger('change');
                loader.hide();
            }, 500);
        });
    </script>
@endpush
