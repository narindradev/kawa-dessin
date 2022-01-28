<div class="card-toolbar my-1">
    @foreach ($inputs as $input)
        <div class="me-2 my-2  w-150px ">
            @php
                $class = "form-control form-control-sm form-control-solid w-160px $filter_for";
                if (get_array_value($input, 'type') == 'select') {
                    if (!get_array_value($input, 'data-hide-search')) {
                        $input['attributes']['data-hide-search'] = 'true';
                    }
                    $class = "w-160px form-select form-select-solid form-select-sm $filter_for";
                    $input['attributes']['data-control'] = 'select2';
                }
                $input['attributes']['class'] = $class ;
                @endphp
            @include("field-inputs.".get_array_value($input,"type") ,["input" => $input])
        </div>
    @endforeach
</div>
