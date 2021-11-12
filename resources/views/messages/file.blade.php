<div class="p-1 rounded bg-light-white text-white fw-bold  text-start mt-2" data-kt-element="message-text">
    <div class="d-flex align-items-center">
        <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="black"></path>
                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"></path>
            </svg>
        </span>
        <a href="{{ url("/project/download/file/$file->id") }}" class="text-gray-800 text-hover-primary">{{ $file->originale_name }}</a>
    </div>
</div>