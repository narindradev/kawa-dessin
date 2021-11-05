<div class="d-flex flex-aligns-center">
    @foreach ($project->invoiceItems as $item)
        @if ($item->pdf)
            <a class="d-block overlay" 
            title="{{ "Facture " .invoice_item_for($item , "paiment")}}" 
            data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-trigger="hover"
            href="{{ url("/project/invoice/download/$item->id") }}">
                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded">
                    <img alt="" class="w-25px me-3"
                        src="{{ asset(theme()->getMediaUrlPath() . 'svg/files/pdf.svg') }}" />
                </div>
            </a>
        @endif
    @endforeach
</div>
<script>
    $(document).ready(function() {
        KTApp.initBootstrapTooltips();
    })
</script>