<form class="form" id="general-setting-form" method="POST"  action="{{ '/app/setting/general/save' }}">
    @csrf
    <div class="form-group">
        <div class="mb-4">
            <label for="app_name" class="required form-label">@lang('lang.app_name')</label>
            <input type="text" value="{{ app_setting('app_name') }}" data-rule-required="true"
                autocomplete="off" name="app_name" class="form-control form-control-solid" placeholder="" data-rule-required="true"
                data-msg-required="@lang('lang.required_input')" />
        </div>
    </div>
    <div class="form-group">
        <div class="mb-4">
            <label for="file_extension" class="form-label">@lang('lang.file_extension')</label>
            <input type="text" value="{{ app_setting('file_extension') }}" data-rule-required="true"
                autocomplete="off" name="file_extension" class="form-control form-control-solid" placeholder="png,jpg,jpeg,pdf,mp4"/>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-3">
            <div class="mb-4">
                <label for="currency" class="required form-label">@lang('lang.currency')</label>
               @php
                   $currency = app_setting('currency');
               @endphp
                <select   data-rule-required="true" data-hide-search="true" data-control="select2"
                    autocomplete="off" name="currency" class="form-control form-control-solid" placeholder="" data-rule-required="true"
                    data-msg-required="@lang('lang.required_input')">
                    <option value="EUR" @if($currency ==="EUR" ) selected @endif  >EUR (Euro)</option>
                    <option value="AUD" @if($currency ==="AUD" ) selected @endif > AUD (Dollar canadienne)</option>
                </select>
            </div>
        </div>
        <div class="form-group col-3">
            <div class="mb-4">
                <label for="currency_symbole" class="required form-label">@lang('lang.currency_symbole')</label>
                <input type="text" value="{{ app_setting('currency_symbole') }}" data-rule-required="true"
                    autocomplete="off" name="currency_symbole" class="form-control form-control-solid" placeholder="" data-rule-required="true"
                    data-msg-required="@lang('lang.required_input')" />
            </div>
        </div>
        <div class="form-group col-3">
            <div class="mb-4">
                <label for="separator_decimal" class="required form-label">@lang('lang.separator_decimal')</label>
                @php
                    $separator_decimal = app_setting('separator_decimal');
                @endphp
                <select   data-rule-required="true" data-hide-search="true" data-control="select2"
                    autocomplete="off" name="separator_decimal" class="form-control form-control-solid" placeholder="" data-rule-required="true"
                    data-msg-required="@lang('lang.required_input')">
                    <option value="," @if($separator_decimal ==="," ) selected @endif  >  Virgule (,)</option>
                    <option value="." @if($separator_decimal ==="." ) selected @endif > Point (.)</option>
                </select>
            </div>
        </div>
        <div class="form-group col-3">
            <div class="mb-4">
                <label for="separtor_thousands" class="required form-label">@lang('lang.separtor_thousands')</label>
                @php
                    $separtor_thousands = app_setting('separtor_thousands');
                @endphp
                    <select   data-rule-required="true"
                    autocomplete="off" name="separtor_thousands" data-hide-search="true" class="form-control form-control-solid" placeholder="" data-rule-required="true"
                    data-msg-required="@lang('lang.required_input') "  data-control="select2">
                    <option value="," @if($separtor_thousands ===",") selected @endif > Virgule (,)</option>
                    <option value="." @if($separtor_thousands ===".") selected @endif > Point (.)</option>
                </select>
            </div>
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
        KTApp.initSelect2();
        $("#general-setting-form").appForm({
            isModal: false,
            onSuccess: function(response) {
              return true;
            },
        })
    })
</script>
