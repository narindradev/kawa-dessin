<form method="POST" id="checkout-form" action="{{ url("/project/invoice/checkout/$invoice->id") }}">
    @csrf
    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
            <div class="card card-flush shadow-lg pt-3 mb-5 mb-xl-10">
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="fw-bolder">Methode de payment</h2>
                    </div>

                    <!--end::Card toolbar-->
                </div>
                <div class="card-body pt-3">
                    <div class="mb-0">
                        <div class="w-100">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="d-flex flex-stack cursor-pointer mb-5">
                                    <span class="d-flex align-items-center me-2">
                                        <span class="symbol symbol-50px me-6">
                                            <span class="symbol-label bg-light-info">
                                                <i class="fab fa-stripe text-info fs-2x"></i>
                                            </span>
                                        </span>
                                        <span class="d-flex flex-column">
                                            <span class="fw-bolder fs-6">Stripe</span>
                                            <span class="fs-7 text-muted">https://stripe.com</span>
                                        </span>
                                    </span>
                                    <span class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input payment-method" id="stripe" type="radio"
                                        name="payment_method_name" value="stripe">
                                    </span>
                                </label>
                                <input type="hidden" id="payment_method_id" name="payment_method_id">
                                <div style="display: none" id="card-element"></div>
                            </div>
                        </div>
                        <div class="separator my-10"></div>
                        <div class="w-100">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="d-flex flex-stack cursor-pointer mb-5">
                                    <span class="d-flex align-items-center me-2">
                                        <span class="symbol symbol-50px me-6">
                                            <span class="symbol-label bg-light-primary">
                                                <i class="fab fa-paypal text-primary fs-2x"></i>
                                            </span>
                                        </span>
                                        <span class="d-flex flex-column">
                                            <span class="fw-bolder fs-6">PayPal</span>
                                            <span class="fs-7 text-muted">https://www.paypal.com</span>
                                        </span>
                                    </span>
                                    <span class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input payment-method" type="radio"
                                            name="payment_method_name" value="paypal">
                                    </span>
                                </label>

                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
            <div class="card card-flush shadow-lg mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary"
                data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}"
                data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false"
                data-kt-sticky-zindex="95" style="">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Summary</h2>
                    </div>
                </div>
                <div class="card-body pt-0 fs-6">
                    <div class="mb-7">
                        {!! view('project.column.info-client', ['client' => $invoice->project->client, 'project' => $invoice->project])->render() !!}
                    </div>
                    <div class="separator  mb-7"></div>
                    <div class="mb-7">
                        <h5 class="mb-4">Detail de paiment</h5>
                        <div class="mb-0">
                            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                <tbody>
                                    <tr class="">
                                <td class="
                                        text-primary"> <span class="text-primary me-2">Facture : </span></td>
                                        <td class="text-gray-800">{{ get_array_value($invoice_data, 'invoice_num') }}
                                        </td>
                                    </tr>
                                    <tr class="">
                                <td class=" text-primary"><span
                                            class=" me-2">Paiment :</span></td>
                                        <td class="text-gray-800"> {{invoice_item_for($item , "Tranche")}}</td>
                                    </tr>
                                    <tr class="">
                                <td class=" text-primary"><span
                                            class=" me-2">Montant :</span></td>
                                        <td class="text-gray-800">{{ format_to_currency($amount)  }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="separator  mb-7"></div>
                    <div class="mb-7">
                        <h5 class="mb-4">Déscriptions de paiment</h5>
                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                            <tbody>
                                <tr class="">
                            <td class="
                                    text-primary"><span class=" me-2">Projet(s):</span></td>
                                    <td class="text-gray-800">
                                        {{ $invoice->project->categories->pluck('name')->implode(' , ', 'name') }}
                                    </td>
                                </tr>
                                <tr class="">
                            <td class=" text-primary"><span
                                        class=" me-2">Date:</span></td>
                                    <td class="text-gray-800">15 Apr 2021</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-0 text-center">
                        <button type="submit"  id="submit-checkout-form" class="btn btn-sm btn-light-success"
                            id="submit-payment">@include('partials.general._button-indicator', ['label' =>trans('lang.paid_it'),"message" => ""])</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        const cardButton = document.getElementById("submit-checkout-form")
        $(".payment-method").on("click", function() {
            if ($("#stripe").is(':checked')) {
                $("#card-element").fadeIn("slow")
                cardButton.setAttribute("disabled","true")
            } else {
                $("#card-element").fadeOut("slow")
            }
        })
        const stripe = Stripe("{{app_setting('STRIPE_KEY')}}");
        const elements = stripe.elements()
        const cardElement = elements.create('card', {
            hidePostalCode: true,
            classes: {
                base: 'form-control form-control-solid ',
            },
            style: {
                base: {
                    color: '#6D6D80 ',
                    fontFamily: 'Helvetica',
                    fontSize: '17px',
                },
            },
        })
        cardElement.mount("#card-element")
        cardElement.on("change", async (e) => {
            cardButton.setAttribute("disabled","true")
            if (e.complete) {
                cardButton.setAttribute("data-kt-indicator", "on");
                if ($("#stripe").is(':checked')) {
                    const { paymentMethod, error } = await stripe.createPaymentMethod("card", cardElement);
                    if (error) {
                        cardElement.clear();
                        cardButton.removeAttribute("data-kt-indicator");
                        toastr.options.timeOut = 9000
                        toastr.warning(error.message +" "+ app_lang.try_again);
                    } else {
                        cardButton.removeAttribute("data-kt-indicator");
                        cardButton.removeAttribute("disabled","false")
                        document.getElementById("payment_method_id").value = paymentMethod.id
                    }
                }
            }
        })
        $("#checkout-form").appForm({
            isModal: false,
            forceBlock: true,
            onSuccess: function(response) {
                $("#submit-checkout-form").remove()
                if (response.reload) {
                    setTimeout(() => {
                        location.reload();
                    }, 4999);
                }
                if (response.url) {
                    setTimeout(() => {
                        window.location.replace(response.url);
                    }, 4999);
                }
            },
        })
    })
</script>