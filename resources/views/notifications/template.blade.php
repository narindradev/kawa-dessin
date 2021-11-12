@php
    $subject = get_template($notification)
@endphp
<div class="notification-item" data-notification-id="{{$notification->id}}" data-notification-is-unread ="{{ $notification->read_at ? 1 : 0 }}" >
<div class="separator my-2" ></div>
<a href="javascript:void(0)">
<div class="notice d-flex mb-1">
    <div class="d-flex flex-stack flex-grow-1 text-right" >
        <div class="fw-bold">
            <span id="notification-event" class="text-gray-{{ $notification->read_at ? "500" :"800" }} fw-bolder"># {{ get_array_value($subject,"title") ?? 'Action' }} </span><span class="badge badge-light-success me-1">Ajout </span>
        </div>
        <div class="d-flex align-items-center mt-1 fs-6">
            <div class="text-muted me-2 fs-7"> <i>{{ $notification->created_at->diffForHumans() }}</i> </div>
        </div>
    </div>
</div>
<div class="text-muted fw-bold lh-lg mb-1">
    @if (get_array_value($subject,"profile"))    
        <div class="symbol symbol-35px symbol-circle">
            {!! get_array_value($subject,"profile") !!}
        </div>
    @endif
    <span id="notification-desc" class="text-gray-{{ $notification->read_at ? "500" :"800" }}"> {{  Illuminate\Support\Str::limit( get_array_value($subject,"sentence"),100)  }}  </span>
</div>
</a>
</div>