<div class="d-flex align-items-center">
    <div class="symbol symbol-35px symbol-circle">
        <?php $int = random_int(1, 50); ?>
        {{-- avatar user --}}
        <img alt="Pic" src="https://i.pravatar.cc/80?img={{$int}}"> 
    </div>
    <div class="ms-5">
        <b href="#" class="fs-5 fw-bolder text-primary mb-2">
            {{$user->name}} @if($is_member)<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Membre</span> @endif
        </b>
        <div class="fw-bold text-muted">{{$user->email}}</div>
    </div>
</div>
