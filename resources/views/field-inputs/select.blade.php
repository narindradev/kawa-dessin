@php

$field = $input;
$options = get_array_value($input, 'options');
$attributes = get_array_value($input, 'attributes');
$html = "";
if ($attributes) {
    foreach ($attributes as $key => $value) {
        $html .= ' ' . $key . '="' . $value . '"';
    }
}
@endphp

<select name="{{ get_array_value($field, 'name') }}" id="{{ get_array_value($field, 'name') }}"
    data-placeholder="Select option" {!! $html !!}>
    <option value="0"> -- {{get_array_value($field, 'label') }} --</option>
    @foreach ($options as $option)
        <option value="{{ get_array_value($option, 'value') }}" {{ get_array_value($option, 'selected') ? 'selected' : '' }}> {{ get_array_value($option, 'text') }} </option>
    @endforeach
</select>
