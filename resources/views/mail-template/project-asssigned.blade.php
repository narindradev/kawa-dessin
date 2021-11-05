@component('mail::message')
    # {{ $event ?? '' }}
    {{ $causer->name ?? 'on' }} vous a assigné un nouveau projet !
    @component('mail::button', ['url' => url("project/detail/$project->id")])
        Project detail
    @endcomponent
    Thanks,<br>
    {{ app_setting('app_name') }}
@endcomponent
