<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! theme()->printHtmlAttributes('html') !!}
    {{ theme()->printHtmlClasses('html') }}>
{{-- begin::Head --}}

<head>
    <meta charset="utf-8" />
    <title> {{ config("app_name") }}</title>
    <meta name="description" content="{{ ucfirst(theme()->getOption('meta', 'description')) }}" />
    <meta name="keywords" content="{{ theme()->getOption('meta', 'keywords') }}" />
    <link rel="canonical" href="{{ ucfirst(theme()->getOption('meta', 'canonical')) }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset("app/logo/logo.png") }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
    <link href="{{ url('demo1/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

        {{-- begin::Fonts --}}
        {{ theme()->includeFonts() }}
        {{-- end::Fonts --}}
        
        @if (theme()->hasOption('page', 'assets/vendors/css'))
        {{-- begin::Page Vendor Stylesheets(used by this page) --}}
        @foreach (theme()->getOption('page', 'assets/vendors/css') as $file)
        <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css" />
        @endforeach
        {{-- end::Page Vendor Stylesheets --}}
        @endif
        
        @if (theme()->hasOption('page', 'assets/custom/css'))
        {{-- begin::Page Custom Stylesheets(used by this page) --}}
        @foreach (theme()->getOption('page', 'assets/custom/css') as $file)
        <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css" />
        @endforeach
        {{-- end::Page Custom Stylesheets --}}
        @endif
        
        @if (theme()->hasOption('assets', 'css'))
        {{-- begin::Global Stylesheets Bundle(used by all pages) --}}
        @foreach (theme()->getOption('assets', 'css') as $file)
        <link href="{{ assetCustom($file) }}" rel="stylesheet" type="text/css" />
        @endforeach
        {{-- end::Global Stylesheets Bundle --}}
        @endif
        
        
        @if (theme()->getViewMode() === 'preview')
        {{ theme()->getView('partials/trackers/_ga-general') }}
        {{ theme()->getView('partials/trackers/_ga-tag-manager-for-head') }}
        @endif
        
        
        @yield('styles')
        <link src="{{ asset('custom.css') }}" rel="stylesheet" type="text/css" />
        <link src="{{ asset('other.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('library/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
        <link href="{{ asset('library/bootstrap-fileinput/themes/explorer/theme.min.css') }}" rel="stylesheet">
    </head>
    {{-- end::Head --}}

{{-- begin::Body --}}

<body {!! theme()->printHtmlAttributes('body') !!} {!! theme()->printHtmlClasses('body') !!} {!! theme()->printCssVariables('body') !!}>

    @if (theme()->getOption('layout', 'loader/display') === true)
        {{ theme()->getView('layout/_loader') }}
    @endif

    @yield('content')
   
    @include('includes.ajax-modal')
    
    <script>
        window.authUser = {
            id : {{ optional( auth()->user() )->id ?? 0 }}
        }
        </script>

{{-- begin::Javascript --}}
@if (theme()->hasOption('assets', 'js'))
{{-- begin::Global Javascript Bundle(used by all pages) --}}
@foreach (theme()->getOption('assets', 'js') as $file)
<script src="{{ asset(theme()->getDemo() . '/' . $file) }}"></script>
@endforeach
{{-- end::Global Javascript Bundle --}}
@endif

@if (theme()->hasOption('page', 'assets/vendors/js'))
{{-- begin::Page Vendors Javascript(used by this page) --}}
@foreach (theme()->getOption('page', 'assets/vendors/js') as $file)
<script src="{{ asset(theme()->getDemo() . '/' . $file) }}"></script>
@endforeach
{{-- end::Page Vendors Javascript --}}
@endif

@if (theme()->hasOption('page', 'assets/custom/js'))
{{-- begin::Page Custom Javascript(used by this page) --}}
@foreach (theme()->getOption('page', 'assets/custom/js') as $file)
<script src="{{ asset(theme()->getDemo() . '/' . $file) }}"></script>
@endforeach
{{-- end::Page Custom Javascript --}}
@endif
{{-- end::Javascript --}}

@if (theme()->getViewMode() === 'preview')
{{ theme()->getView('partials/trackers/_ga-tag-manager-for-body') }}
@endif

@include('includes.helper-js')
@include('includes.notification-js')
    <script src="{{ asset('library/jquery.validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('library/jquery.form/jquery.form.js') }}"></script>
    <script src="{{ asset('main.js') }} "></script>
    <script src=" {{ url('demo1/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('library/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-fileinput/themes/explorer/theme.min.js') }}"></script>
    @yield('scripts')
    @include('includes.ajax-drawer')
    @include('includes.debugs')
</body>
{{-- end::Body --}}

</html>
