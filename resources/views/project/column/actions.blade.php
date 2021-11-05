<div class="card-toolbar">
    <button type="button" data-bs-toggle="dropdown"
        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click"
        data-kt-menu-placement="bottom-end">
        <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
                    <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                    <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                    <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                </g>
            </svg>
        </span>
    </button>
    <div class="dropdown-menu  menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-2"
        data-kt-menu="true" style="" data-bind="enable: !noResults()">

        <div class="menu-item px-3">
            <div class="menu-content text-muted pb-2 px-3 fs-7 "><i class="fas fa-bars"></i></div>
        </div>
        @if ($for_user->is_commercial())
            <div class="menu-item px-3">
                @php
                    echo modal_anchor(url("/project/relaunch/summary/$project->id"), 'Relance', ['class' => 'menu-link px-3', 'data-drawer' => true, 'title' => trans('lang.relaunch')]);
                @endphp
            </div>
        @endif

        @if ($for_user->is_commercial() && (!$project->estimate || $project->estimate == 'refused'))
            <div class="menu-item px-3">
                @php
                    echo modal_anchor(url("/project/estimate/form/$project->id"), 'Assingné dévis', ['class' => 'menu-link px-3', 'title' => trans('lang.estimate')]);
                @endphp
            </div>
        @endif
        @if ($for_user->is_commercial())
            <div class="menu-item px-3 my-1">
                <a href="#" class="menu-link px-3">Annuler le project</a>
            </div>
        @endif
        @if ($for_user->is_dessignator())
            <div class="menu-item px-3 my-1">
                <a href="#" class="menu-link px-3">Dessi action</a>
            </div>
        @endif
        @if ($for_user->is_mdp())
        <div class="menu-item px-3 my-1">
            @php
                echo modal_anchor(url("/project/start/form/$project->id"), trans("lang.start_project"), ['class' => 'menu-link px-3', 'title' => trans('lang.start_project')]);
            @endphp
        </div>
    @endif
        @if ($for_user->is_admin())
            <div class="menu-item px-3 my-1">
                <a href="#" class="menu-link px-3">Admin action</a>
            </div>
        @endif
        
    </div>
</div>
