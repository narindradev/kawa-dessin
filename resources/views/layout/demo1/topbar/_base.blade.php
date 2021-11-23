@php
    $toolbarButtonMarginClass = "ms-1 ms-lg-3";
    $toolbarButtonHeightClass = "w-40px h-40px";
    $toolbarUserAvatarHeightClass = "symbol-40px";
    $toolbarButtonIconSizeClass = "svg-icon-1";
    $count = auth()->user()->unreadNotifications->count() ?? "";
@endphp
<div class="d-flex align-items-stretch flex-shrink-0">
    {{-- <div class="d-flex align-items-stretch {{ $toolbarButtonMarginClass }}">
        {{ theme()->getView('partials/search/_base') }}
    </div>
    <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">
        <div class="btn btn-icon btn-active-light-primary {{ $toolbarButtonHeightClass }}" id="kt_activities_toggle">
            {!! theme()->getSvgIcon("icons/duotune/general/gen032.svg", $toolbarButtonIconSizeClass) !!}
        </div>
    </div> --}}
    <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">
        <div id="bell-icon" class="btn btn-icon btn-active-light-primary position-relative pulse pulse-danger {{ $toolbarButtonHeightClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                {!! theme()->getSvgIcon("icons/duotune/general/gen007.svg", $toolbarButtonIconSizeClass) !!}
            <span class="menu-badge position-absolute top-0 start-50 text-danger ">
                <span class="badge badge-light-danger badge-circle fw-bolder fs-7 ">
                     <span id="notifications-count">{{ $count }}</span> 
                     <span class="pulse-notification" id="pulse-notification"></span>
                </span>
            </span>
        </div>
        {{ theme()->getView('partials/topbar/_notifications-menu') }}
    </div>
    <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}">
        <div class=" {{ $toolbarButtonHeightClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
            {{-- {!! theme()->getSvgIcon("icons/duotune/general/gen025.svg", $toolbarButtonIconSizeClass) !!} --}}
        </div>
        {{-- {{ theme()->getView('partials/topbar/_quick-links-menu') }} --}}
    </div>
    @if(Auth::check())
        <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}" id="kt_header_user_menu_toggle">
            <div class="cursor-pointer symbol symbol-40px symbol-circle {{ $toolbarUserAvatarHeightClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                <img src="{{ auth()->user()->avatar_url }}" alt="metronic"/>
            </div>
            {{ theme()->getView('partials/topbar/_user-menu') }}
        </div>
    @endif
    @if(theme()->getOption('layout', 'header/left') === 'menu')
        <div class="d-flex align-items-center d-lg-none ms-2 me-n3" data-bs-toggle="tooltip" title="Show header menu">
            <div class="btn btn-icon btn-active-light-primary" id="kt_header_menu_mobile_toggle">
                {!! theme()->getSvgIcon("icons/duotune/text/txt001.svg", "svg-icon-1") !!}
            </div>
        </div>
    @endif
</div>
