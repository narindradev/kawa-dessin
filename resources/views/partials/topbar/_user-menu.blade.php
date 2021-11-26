<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <div class="symbol symbol-50px symbol-circle me-5">
                <img alt="Logo" src="{{ auth()->user()->avatar_url }}"/>
            </div>
            <div class="d-flex flex-column">
                <div class="fw-bolder d-flex align-items-center fs-5">
                    {{ auth()->user()->first_name }}
                    <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">{{ auth()->user()->function->description }}</span>
                </div>
                <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
            </div>
        </div>
    </div>
    <div class="separator my-2"></div>
    <div class="menu-item px-5">
        <a href="{{ theme()->getPageUrl('settings.index') }}" class="menu-link px-5">
            @lang('lang.my_profile')
        </a>
    </div>
    {{-- <div class="menu-item px-5">
        <a href="#" class="menu-link px-5" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ __('Coming soon') }}">
            <span class="menu-text">{{ __('My Projects') }}</span>
            <span class="menu-badge">
                <span class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>
            </span>
        </a>
    </div> --}}
    {{-- <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-kt-menu-flip="center, top">
        <a href="#" class="menu-link px-5">
            <span class="menu-title">{{ __('My Subscription') }}</span>
            <span class="menu-arrow"></span>
        </a>
        <div class="menu-sub menu-sub-dropdown w-175px py-4">
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-5">
                    {{ __('Referrals') }}
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-5">
                    {{ __('Billing') }}
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-5">
                    {{ __('Payments') }}
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link d-flex flex-stack px-5">
                    {{ __('Statements') }}

                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="View your statements"></i>
                </a>
            </div>
            <div class="separator my-2"></div>
            <div class="menu-item px-3">
                <div class="menu-content px-3">
                    <label class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications"/>
                        <span class="form-check-label text-muted fs-7">
                            {{ __('Notifications') }}
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="menu-item px-5">
        <a href="#" class="menu-link px-5">
            {{ __('My Statements') }}
        </a>
    </div> --}}
    {{-- <div class="separator my-2"></div> --}}
    {{-- <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start" data-kt-menu-flip="center, top">
        <a href="#" class="menu-link px-5">
            <span class="menu-title position-relative">
                {{ __('Language') }}

                <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                    {{ __('English') }} <img class="w-15px h-15px rounded-1 ms-2" src="{{ asset(theme()->getMediaUrlPath() . 'flags/united-states.svg') }}" alt="metronic"/>
                </span>
            </span>
        </a>
        <div class="menu-sub menu-sub-dropdown w-175px py-4">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link d-flex px-5 active">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/united-states.svg') }}" alt="metronic"/>
                    </span>
                    {{ __('English') }}
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link d-flex px-5">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/spain.svg') }}" alt="metronic"/>
                    </span>
                    {{ __('Spanish') }}
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link d-flex px-5">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/germany.svg') }}" alt="metronic"/>
                    </span>
                    {{ __('German') }}
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link d-flex px-5">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/japan.svg') }}" alt="metronic"/>
                    </span>
                    {{ __('Japanese') }}
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link d-flex px-5">
                    <span class="symbol symbol-20px me-4">
                        <img class="rounded-1" src="{{ asset(theme()->getMediaUrlPath() . 'flags/france.svg') }}" alt="metronic"/>
                    </span>
                    {{ __('French') }}
                </a>
            </div>
        </div>
    </div> --}}
    {{-- <div class="menu-item px-5 my-1">
        <a href="{{ theme()->getPageUrl('settings.index') }}" class="menu-link px-5">
            @lang('lang.account_setting')
        </a>
    </div> --}}
    <div class="menu-item px-5">
        <a href="#" data-action="{{ theme()->getPageUrl('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true" class="button-ajax menu-link px-5">
            @lang('lang.signout')
        </a>
    </div>
    @if (theme()->isDarkModeEnabled())
    <form id="form-theme-mode" class="form" method="POST" action="{{url("/users/save/theme")}}">
        @csrf
        <div class="separator my-2"></div>
        <div class="menu-item px-5">
            <div class="menu-content px-5">
                <label class="form-check form-switch form-check-custom form-check-solid " for="dark_mode_toggle">
                    <input class="form-check-input w-30px h-20px" type="checkbox"  value="1" name="skin" id="dark_mode_toggle" {{ auth()->user()->theme_mode=="dark" ? 'checked' : '' }}  />
                    <span class="form-check-label text-gray-600 fs-7">
                        @lang('lang.dark_mode')
                    </span>
                </label>
            </div>
        </div>
        <button type="submit" id="submit-form-theme-mode" style="display: none"></button>
    </form>
    @endif
</div>
<script>
    $(document).ready(function() {
        $("#dark_mode_toggle").on("click",function () {
            $("#submit-form-theme-mode").trigger("click")
        });
    })
</script>
