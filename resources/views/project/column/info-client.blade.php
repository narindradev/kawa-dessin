
<div class="d-flex align-items-center">
    
   
    <div class="symbol symbol-45px symbol-circle me-5">
        <span class="symbol-label bg-primary text-inverse-primary fw-bolder">{{ strtoupper($client->user->name[0]) }}</span>
        {{-- <img src="http://127.0.0.1:8000/demo1/media/avatars/150-11.jpg" alt=""> --}}
    </div>
    <div class="d-flex justify-content-start flex-column">
        <a href="{{ "/project/detail/$project->id" }}" class="text-dark fw-bolder text-hover-primary fs-6">{{ $client->user->name }}
        </a>
            <span class="text-muted fw-bold text-muted d-block fs-7">{{ $client->user->email }}  </span>
    </div>
</div>