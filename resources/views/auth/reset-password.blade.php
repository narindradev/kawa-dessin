<x-auth-layout>
    <form method="POST" action="{{ theme()->getPageUrl('password.update') }}" class="form w-100" novalidate="novalidate" id="kt_new_password_form">
    @csrf
        <input type="hidden" name="token" value="{{ $request->token }}">
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">
                @lang('lang.update_pwd_login')
            </h1>
            <div class="text-gray-400 fw-bold fs-4">
                @lang('lang.secure_pwd')
            </div>
        </div>
        <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-gray-900 fs-6"> @lang('lang.email')</label>
            <input class="form-control form-control-solid" type="email" name="email" autocomplete="off" value="{{  $request->email ?? old('email', $request->email) }}" required/>
        </div>
        <div class="mb-10 fv-row" data-kt-password-meter="true">
            <div class="mb-1">
                <label class="form-label fw-bolder text-dark fs-6">
                    @lang('lang.password')
                   
                </label>
                <div class="position-relative mb-3">
                    <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="new-password"/>

                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
            </div>
            <div class="text-muted">
                @lang('lang.pwd_content')
            </div>
        </div>
        <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-gray-900 fs-6"> @lang('lang.confirm_password')</label>
            <input class="form-control form-control-solid" type="password" name="password_confirmation" autocomplete="off" required/>
        </div>
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" id="kt_new_password_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                @include('partials.general._button-indicator',['label' => trans('lang.reset'),"message" => trans('lang.sending')])
            </button>
            <a href="{{ theme()->getPageUrl('login') }}" class="btn btn-lg btn-light-primary fw-bolder">@lang('lang.cancel')</a>
        </div>
    </form>
    @section('scripts')
        <script src="{{ asset('js/custom/authentication/password-reset/new-password.js') }}" type="application/javascript"></script>
    @endsection
</x-auth-layout>
