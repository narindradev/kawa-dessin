{{-- <div class="symbol-group symbol-hover mb-3">

    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="" data-bs-original-title="Alan Warden">
        <span class="symbol-label bg-primary text-inverse-primary fw-bolder">{{ strtoupper($user->name[0]) }}</span>
    </div>
    <div class="d-flex flex-column">
        <div class="fw-bolder d-flex align-items-center fs-5">{{ $user->name }}
            <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">{{ 'new' }}</span>
        </div>
        <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ $user->email }}</a>
    </div>
</div> --}}
<div class="d-flex align-items-center">
    <div class="symbol symbol-45pxsymbol-circle me-5">
        <span class="symbol-label bg-primary text-inverse-primary fw-bolder">{{ strtoupper($user->name[0]) }}</span>
        {{-- <img src="http://127.0.0.1:8000/demo1/media/avatars/150-11.jpg" alt=""> --}}
    </div>
    <div class="d-flex justify-content-start flex-column">
        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{ $user->name }}
            <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">{{ 'new' }}</span></a>
        
        <span class="text-muted fw-bold text-muted d-block fs-7">{{ $user->email }}</span>
    </div>
</div>