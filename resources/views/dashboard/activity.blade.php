<div class="card card-xxl-stretch">
    <div class="card-header align-items-center border-0 mt-4">
        <h3 class="card-title align-items-start flex-column">
            <span class="fw-bolder mb-2 text-dark">Activités</span>
        </h3>
    </div>
    <div class="card-body pt-5">
        <div class="timeline-label">
            @php
                $class = ["primary" ,"success","danger"];
                $activities  =  \Spatie\Activitylog\Models\Activity::limit(8)->get();
            @endphp
            @foreach ($activities as $activity)
                <div class="timeline-item">
                    <div class="timeline-label fw-bolder text-gray-800 fs-7">
                        {{ $activity->created_at->format('h:i') }}</div>
                    <div class="timeline-badge">
                        @php
                            $cl = array_rand($class, 1);
                        @endphp
                        <i class="fa fa-genderless text-{{ $class[$cl] }} fs-1"></i>
                    </div>
                    <div class=" {{ $class[$cl] != "danger" ? "timeline-content fw-bold text-gray-800 ps-3" : "fw-mormal timeline-content text-muted ps-3" }}">
                        {{-- {{ $activity->causer_type }}  --}}
                        Causer type id
                        -<a href="#" class="text-primary">{{ $activity->causer_id }}</a>
                        {{-- {{ $activity->subject_type }} --}}
                        Subject type id
                        -<a href="#" class="text-primary">{{ $activity->subject_id }}</a>
                        {{ $activity->log_for}}
                    </div>  
                </div>
            @endforeach
        </div>
    </div>
</div>