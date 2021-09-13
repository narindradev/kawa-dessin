<div class="card  card-flush mb-5 ">
    <div class="card-body  py-2">
        <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
            <span class="svg-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
                        <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                        <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                        <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                    </g>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </button>
        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_613f01e356d57"
            style="">
            <!--begin::Header-->
            <div class="px-7 py-5">
                <div class="fs-5 text-dark fw-bolder">Plus de filtre</div>
            </div>
            <div class="separator border-gray-200"></div>
            <div class="px-7 py-5">
                @foreach ($inputs as $input)
                        @include("field-inputs.".get_array_value($input,"type") ,["input" => $input])
                @endforeach
               
                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                        data-kt-menu-dismiss="true">Reset</button>
                    <a type="submit"  class="btn btn-sm btn-primary filter-table" data-kt-menu-dismiss="true">Apply</a>
                </div>
            </div>
        </div>
    </div>
</div>
