
<span type="button" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-bs-toggle="dropdown" class="badge badge-light-{{$project->version == "APS" ? "danger" : "success"}}  py-2 px-2" "> 
    {{ $project->version }}
</span>

<div class="dropdown-menu  menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-2 pt-10"
    data-kt-menu="true" style="" data-bind="enable: !noResults()">
       
            <div class="menu-item px-3 ">
                <button type="button" data-project_id="{{ $project->id }}" data-version="APS"  class="project-version btn btn-outline  btn-outline-dashed btn-outline-danger btn-outline-danger btn-active-light-danger  btn-sm  mb-2 w-100">
                    APS 
                @if ($project->version == "APS")
                    &nbsp;  <i class="fas fa-check"></i> 
                @endif
                </button> <br>
            </div>
            <div class="menu-item px-3 ">
                <button type="button" data-project_id="{{ $project->id }}" data-version="DS"  class="project-version btn btn-outline btn-outline-dashed btn-outline-info btn-active-light-info btn-sm  mb-2 w-100">
                   DS  
                @if ($project->version == "DS")
                    &nbsp;  <i class="fas fa-check"></i> 
                @endif
                </button> 
            </div>
</div>
