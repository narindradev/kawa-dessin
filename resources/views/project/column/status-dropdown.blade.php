<div class="dropdown-menu  menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-2 pt-10"
    data-kt-menu="true" style="" data-bind="enable: !noResults()">
        @foreach ($status_drop as $item)
            <div class="menu-item px-3 ">
                <button type="button" data-project_id="{{ $project->id }}"  data-project-status="{{ $project->id }}"  data-status="{{ $item["value"] }}"  class="project-status btn btn-outline btn-outline-dashed btn-sm  btn-outline-{{$item['class']}} btn-active-light-{{$item['class']}} mb-2 w-100">{{$item['text']}} 
                    @if ($item["value"] == $project->status_id)
                        &nbsp;  <i class="fas fa-check"></i> 
                    @endif
                </button> <br>
            </div>
        @endforeach
</div>
