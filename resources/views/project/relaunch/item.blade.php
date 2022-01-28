<div id="relaunch-item-{{ $relaunch->id }}" class="timeline-item  {{ 0 ? "ps-10" : "" }} ">
    <div class="timeline-line w-40px {{ 0 ? "px-15" : "" }}"></div>
    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
        <div class="symbol-label bg-light">
            <span class="svg-icon svg-icon-2 svg-icon-gray-500">
                {!! theme()->getSvgIcon("icons/duotune/communication/com003.svg") !!}
            </span>
        </div>
    </div>
    <div class="timeline-content mb-10 ">
        <div class=" mb-5">
            <div class="fw-bolder text-gray-800 "> {{ $relaunch->subject->description }}
                @if ($relaunch->note)
                    <div class="d-flex  mt-1 fs-7 mb-2">
                        <div class="text-muted me-2">
                          <u>@lang('lang.note')</u>  : {{ $relaunch->note }}
                        </div>
                    </div>
                @endif 
                <div class="d-flex  mt-1 fs-9">
                    <div class="text-muted me-2">Ajouté  {{ $relaunch->created_at->format("d-m-Y") }}  par 
                        @if ($relaunch->createdBy->id == $for_user->id)
                            @lang('lang.me')
                        @else
                            <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="" data-bs-original-title="Nina Nilson">
                                <img src="{{ $relaunch->createdBy->avatar_url }}" alt="img">
                            </div>
                        @endif 
                    </div>
                </div>
            </div>
        </div>
        @if ($relaunch->files )
            @foreach ($relaunch->attachements as $file)
                <div class="d-flex flex-aligns-center">
                    <span class="svg-icon svg-icon-3x svg-icon-primary me-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="black"></path>
                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"></path>
                        </svg>
                    </span>
                    <div class="ms-1 fw-bold">
                        <a href="{{ url("/project/download/file/$file->id")}}" title ="telechager" class="fs-6 text-hover-primary fw-bolder">{{ $file->originale_name }}</a>
                        <div class="text-gray-400">{{ file_sisze($file->size) }}</div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@if ($relaunch->created_by != $for_user->id && !in_array($for_user->id, explode(",",$relaunch->seen_by)))
    <script id="script-set-seen-{{$relaunch->id}}">
        $(document).ready(function(){
            $.ajax({
                url: url("/project/relaunch/mark/seen"),
                type: 'POST',
                dataType: 'json',
                data: {
                    id : "{{$relaunch->id}}",
                    _token: _token
                },
                success: function(result) {
                    if (result.success) {
                        $("#script-set-seen-{{$relaunch->id}}").remove() // remove this script for to not execute secondly
                    }
                },
            });
        })
    </script>
@endif