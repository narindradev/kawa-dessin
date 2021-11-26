<div class="d-flex align-items-center">
    <div class="symbol  symbol-35px symbol-circle symbol-success me-3">
        <img alt="Pic" src="https://i.pravatar.cc/80?img={{ random_int(1,20) }}">
    </div>
    <div class="d-flex flex-column align-items-start">
        <span class="text-dark-50 fw-bold mb-1">{{ $name }}</span>
        @php
            $status = ["success" ,"primary" ,"warning" ,"info" ,"danger"];
            $class = array_rand($status , 1);
        @endphp
        <span class="badge badge-light-{{ $status[ $class] }}">{{ $status[ $class] }}</span>
    </div>
</div>