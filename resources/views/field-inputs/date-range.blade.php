@php
$field = $input;
$options = get_array_value($input, 'options');
$attributes = get_array_value($input, 'attributes');
$attr = '';

if ($attributes) {
    foreach ($attributes as $key => $value) {
        $attr .= ' ' . $key . '="' . $value . '"';
    }
}
@endphp
<div class="row">
<input {!! $attr !!} name="{{ get_array_value($input, 'name') }}" value="" autocomplete="off" placeholder="--/--/---- {{ trans('lang.to') }} --/--/----" id="{{ get_array_value($input, 'name') }}" />
</div>
<script>
    $(document).ready(function() {
        $("#{{ get_array_value($input, 'name') }}").daterangepicker({
            autoApply: true,
            locale: {
                format: 'DD/MM/yyyy'
            }
        }).val('');
    })
</script>
