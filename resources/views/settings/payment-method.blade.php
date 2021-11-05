<form class="form" id="payment-methode-setting-form" method="POST"  action="{{ '/app/setting/payment_method/save' }}">
    @csrf
    <div class="form-group">
        <div class="mb-4">
            <label for="" class="required form-label">STRIPE</label>
            <input type="text" value="{{ app_setting('STRIPE_KEY') }}" data-rule-required="true"
                autocomplete="off"  placeholder="@lang('lang.STRIPE_KEY')"  name="STRIPE_KEY" class="form-control form-control-solid mb-4" placeholder="" data-rule-required="true"
                data-msg-required="@lang('lang.required_input')" />

                <input type="text" value="{{ app_setting('STRIPE_SECRET') }}" data-rule-required="true"
                autocomplete="off" placeholder="@lang('lang.STRIPE_SECRET')" name="STRIPE_SECRET" class="form-control form-control-solid mb-4" placeholder="" data-rule-required="true"
                data-msg-required="@lang('lang.required_input')" />
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit"  class=" btn btn-sm btn-light-primary  mr-2">
            @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" =>
            trans("lang.sending")])
        </button>
    </div>
</form>
<script>
    $(document).ready(function() {

        $("#payment-methode-setting-form").appForm({
            isModal: false,
            onSuccess: function(response) {
              return true;
            },
        })
    })
</script>
