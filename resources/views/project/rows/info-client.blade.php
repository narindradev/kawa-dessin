
<div class="d-flex align-items-center">
    <div class="symbol symbol-45px symbol-circle me-5">
        <span class="symbol-label bg-primary text-inverse-primary fw-bolder">{{ strtoupper($user->name[0]) }}</span>
        {{-- <img src="http://127.0.0.1:8000/demo1/media/avatars/150-11.jpg" alt=""> --}}
    </div>
    <div class="d-flex justify-content-start flex-column">
        <a href="{{ url("/project/detail/$project->id") }}" class="text-dark fw-bolder text-hover-primary fs-6">{{ $user->name }}
            <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">{{ 'new' }}</span>
        </a>
            <span class="text-muted fw-bold text-muted d-block fs-7">{{ $user->email }}</span>
    </div>
</div>