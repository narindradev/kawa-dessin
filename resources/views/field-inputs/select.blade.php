@php
    $field = $input;
    $options = get_array_value($field, 'options');
@endphp
<div class="mb-10">
<label class="form-label fw-bold"> {{ get_array_value($field, 'label') ?? get_array_value($field, 'name') }}</label>
<div>
    <select name="{{ get_array_value($field, 'name') }}"
        id="{{ get_array_value($field, 'name') }}"
        class="form-select form-select-solid select2-hidden-accessible" data-kt-select2="true"
        data-placeholder="Select option" data-dropdown-parent="#kt_menu_613f01e356d57" data-allow-clear="true"
        data-select2-id="select2-data-10-wcqs" tabindex="-1" aria-hidden="true">
        <option data-select2-id="select2-data-12-vgif"></option>
        @foreach ($options as $option)
            <option value="{{ get_array_value($option, 'value') }}"
                {{ get_array_value($option, 'selected') ? 'selected' : '' }}
                data-select2-id="select2-data-81-ztsj-{{ get_array_value($option, 'value') }}">
                {{ get_array_value($option, 'text') }}</option>
        @endforeach
    </select>
</div>
</div>