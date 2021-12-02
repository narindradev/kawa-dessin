@php
    $date = get_array_value($data, 'date');
@endphp
<div class="timeline-item activity-item">
    <div class="timeline-label fw-bolder text-gray-800 fs-7"> {{ $date->format("h : m") }} </div>
    <div class="timeline-badge">
        <i class="fa fa-genderless text-{{ get_array_value($data, 'class')?? "primary" }} fs-1"></i>
    </div>
    <div class="timeline-content fw-bold text-gray-800 ps-3">
        {!! get_array_value($data, 'sentence') !!}
        @if (get_array_value($data, 'changed'))
            <br>
            <div class="text-muted  fs-7">{!! get_array_value($data, 'changed') !!}</div>
        @endif
    </div>
    <div class="d-flex text-right mt-1 fs-6">
        <div class="text-muted me-2 fs-7"> {{ $date->format("d-M-y") }}</div>
    </div>
</div>

