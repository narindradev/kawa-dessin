<x-auth-layout>
    <form method="POST" action="{{ theme()->getPageUrl('login') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
    @csrf
        <div class="text-center mb-10">
            <h1 class="text-dark mb-3">
                {{-- {{ __('Sign In to Metronic') }} --}}
            </h1>
            <div class="text-gray-400 fw-bold fs-4">
                {{-- {{ __('New Here?') }} --}}
                <a href="{{ theme()->getPageUrl('register') }}" class="link-primary fw-bolder">
                    {{-- {{ __('Create an Account') }} --}}
                </a>
            </div>
        </div>
        <div class="fv-row mb-10">
            <label class="form-label fs-6 fw-bolder text-dark">@lang('lang.email')</label>
            <input class="form-control form-control-lg form-control-solid" type="email" name="email" autocomplete="off" value="{{ old('email', '') }}" required autofocus/>
        </div>
        <div class="fv-row mb-10">
            <div class="d-flex flex-stack mb-2">
                <label class="form-label fw-bolder text-dark fs-6 mb-0">@lang('lang.password')</label>
                @if (Route::has('password.request'))
                    <a href="{{ theme()->getPageUrl('password.request') }}" class="link-primary fs-6 fw-bolder">
                        {{ __('Forgot Password ?') }}
                    </a>
            @endif
            </div>
            <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" value="demo" required/>
        </div>
        {{-- <div class="fv-row mb-10">
            <label class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" name="remember"/>
                <span class="form-check-label fw-bold text-gray-700 fs-6">{{ __('Remember me') }}
            </span>
            </label>
        </div> --}}
        <div class="text-center">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                @include('partials.general._button-indicator', ['label' => __('Continue')])
            </button>
            {{-- <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
            <a href="{{ url('/auth/redirect/google') }}?redirect_uri={{ url()->previous() }}" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'svg/brand-logos/google-icon.svg') }}" class="h-20px me-3"/>
                {{ __('Continue with Google') }}
            </a>
            <a href="{{ url('/auth/redirect/facebook') }}?redirect_uri={{ url()->previous() }}" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'svg/brand-logos/facebook-4.svg') }}" class="h-20px me-3"/>
                {{ __('Continue with Facebook') }}
            </a> --}}
        </div>
    </form>
</x-auth-layout>
