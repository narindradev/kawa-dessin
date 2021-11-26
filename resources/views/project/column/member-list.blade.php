<div class="d-flex align-items-center">
    <div class="symbol symbol-35px symbol-circle">
        {{-- avatar user --}}
        <img alt="Pic" src="{{ $user->avatar_url }}"> 
    </div>
    <div class="ms-5">
        <b href="#" class="fs-5 fw-bolder text-primary mb-2">
            {{$user->name}} @if($is_member)<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2"> @lang('lang.member') </span> @endif
        </b>
        <div class="fw-bold text-muted">{{$user->email}}</div>
    </div>
</div>
