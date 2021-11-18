
<div class="stepper stepper-pills flex-column flex-xl-row flex-row-fluid mb-5" id="stepper-state" >
    <div class="stepper-nav ">
        @foreach ($states as $state)
            @php
                $is_current =  get_array_value($state, 'current'); 
                $is_completed =  get_array_value($state, 'completed'); 
            @endphp
            <div class="stepper-item {{ $is_current ? "current" : "" }}  {{ $is_completed ? "completed" : "" }} " data-kt-stepper-element="nav">
                <div class="stepper-line w-10px"></div>
                <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check "></i>
                    <span class="stepper-number ">{{ get_array_value($state,"step") }}</span>
                </div>
                <div class="stepper-label">
                    <h3 @if ($is_current) style="color: white !important" @endif class="stepper-title  {{  $is_completed ? "text-gray-400" : "text-gray-500" }}  " >  {{ get_array_value($state,"title") }}</h3>
                    <div class="stepper-desc  @if ($is_current) style="color: white !important" @endif ">{{ get_array_value($state,"desc") }}</div>
                </div>
            </div>
        @endforeach
    
         
    </div>
</div>
