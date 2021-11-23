<div class="p-1 rounded bg-light-white text-white fw-bold  overlay overflow-hidden mt-2" data-kt-element="message-text">
    <div class="d-flex align-items-center">
        <span class="svg-icon svg-icon-3x svg-icon-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="black"></path>
                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"></path>
            </svg>
        </span>
        @if ($message->receiver_id)
            <a href="{{ url("/message/download/file/$file->id")}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ file_sisze($file->size) }}" class="text-gray-800 text-hover-primary">{{ $file->originale_name }}</a>
        @elseif($message->project_id)
            <a href="{{ url("/project/download/file/$file->id")}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ file_sisze($file->size) }}" class="text-gray-800 text-hover-primary" >{{ $file->originale_name }}</a>
        @endif
    </div>
</div>
