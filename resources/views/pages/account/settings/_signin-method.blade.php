<!--begin::Sign-in Method-->
<div class="card {{ $class ?? '' }}" {{ util()->putHtmlAttributes(array('id' => $id ?? '')) }}>
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">  @lang('lang.methode_signin')</h3>
        </div>
    </div>
    <div id="kt_account_signin_method" class="collapse show">
        <!--begin::Card body-->
        <div class="card-body border-top p-9">
            <!--begin::Email Address-->
            <div class="d-flex flex-wrap align-items-center">
                <!--begin::Label-->
                <div id="kt_signin_email">
                    <div class="fs-6 fw-bolder mb-1">@lang('lang.email_address') </div>
                    <div class="fw-bold text-gray-600">{{ $info->email }}</div>
                </div>
                <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                    <form id="kt_signin_change_email" class="form" novalidate="novalidate" method="POST" action="{{ route('settings.changeEmail') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="current_email" value="{{ $info->email }} "/>
                        <input type="hidden" name="id" value="{{ $info->id }} "/>
                        <div class="row mb-6">
                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <div class="fv-row mb-0">
                                    <label for="email" class="form-label fs-6 fw-bolder mb-3">@lang('lang.enter_new_email') </label>
                                    <input type="email" class="form-control  form-control-solid" placeholder="@lang('lang.email_address')" name="email" value="{{ old('email') }}" id="email"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="fv-row mb-0">
                                    <label for="current_password" class="form-label fs-6 fw-bolder mb-3">@lang('lang.current_password')</label>
                                    <input type="password" class="form-control  form-control-solid" name="current_password" id="current_password"/>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button id="kt_signin_submit" type="button" class="btn btn-primary btn btn-sm  me-2 px-6">
                                @include('partials.general._button-indicator', ['label' => trans("lang.update_email")])
                            </button>
                            <button id="kt_signin_cancel" type="button" class="btn btn btn-sm btn-color-gray-400 btn-active-light-primary px-6">    @lang('lang.cancel')</button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <div id="kt_signin_email_button" class="ms-auto">
                    <button class="btn btn-sm btn-light btn-active-light-primary">@lang('lang.change_email')</button>
                </div>
            </div>
            <div class="separator separator-dashed my-6"></div>
            <div class="d-flex flex-wrap align-items-center mb-10">
                <div id="kt_signin_password">
                    <div class="fs-6 fw-bolder mb-1">@lang('lang.password')</div>
                    <div class="fw-bold text-gray-600"> ************ </div>
                </div>
                <!--end::Label-->

                <!--begin::Edit-->
                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                    <!--begin::Form-->
                    <form id="kt_signin_change_password" class="form" novalidate="novalidate" method="POST" action="{{ route('settings.changePassword') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="current_email" value="{{ $info->email }} "/>
                        <div class="row mb-1">
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="current_password" class="form-label fs-6 fw-bolder mb-3">@lang('lang.current_password')</label>
                                    <input type="password" class="form-control  form-control-solid" name="current_password" id="current_password"/>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="password" class="form-label fs-6 fw-bolder mb-3">@lang('lang.new_password')</label>
                                    <input type="password" autocomplete="off" class="form-control  form-control-solid" name="password" id="password"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="password_confirmation" class="form-label fs-6 fw-bolder mb-3">@lang('lang.confirm_new_password') </label>
                                    <input type="password" autocomplete="off" class="form-control  form-control-solid" name="password_confirmation" id="password_confirmation"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-text mb-5">@lang('lang.password_rules')</div>

                        <div class="d-flex">
                            <button id="kt_password_submit" type="button" class="btn btn-sm  btn-primary me-2 px-6">
                                @include('partials.general._button-indicator', ['label' => trans("lang.update_password")])
                            </button>
                            <button id="kt_password_cancel" type="button" class="btn btn-sm btn-color-gray-400 btn-active-light-primary px-6"> @lang('lang.cancel') </button>
                        </div>
                    </form>
                </div>
                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-sm btn-light btn-active-light-primary">@lang('lang.reset_pwd')</button>
                </div>
            </div>
        </div>
    </div>
</div>
