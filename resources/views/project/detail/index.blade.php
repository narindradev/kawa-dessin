<x-base-layout>
    <div class="card mb-6 mb-xl-9">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <div
                    class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                    <img class="mw-50px mw-lg-75px" src="assets/media/svg/brand-logos/volicity-9.svg" alt="image">
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-1">
                                <a href="#"
                                    class="text-gray-800 text-hover-primary fs-2 fw-bolder me-3">{{ $project->client->user->name }}</a>
                                <span
                                    class="badge badge-light-{{ $project->status->class }} me-auto"> 
                                    @if ($project->estimate == "accepted" && $project->status->id == 3 && auth()->user()->is_client())
                                        Completion de dessies
                                    @else
                                        {{ trans("lang.{$project->status->name}") }}
                                    @endif    
                                </span>
                            </div>
                            <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400">
                                {{ $project->categories->pluck('name')->implode(',') }}</div>
                        </div>
                        <div class="d-flex mb-4">
                            @if (!$project->estimate || $project->estimate =="refused")
                                
                                <a class="btn btn-sm  btn-light-primary me-3" data-project-id ={{ $project->id }}  id="accept_estimate">
                                    <span class="indicator-label" id="accpeted">
                                        J'accepte le devis.
                                    </span>
                                    <span class="indicator-progress">
                                        Un instant...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                                @php
                                    echo modal_anchor(url("/project/refuse/estimate/$project->id"), 'Non, J\'accepte pas le devis', ['class' => 'btn btn-sm  btn-light me-3', 'title' => " "]);
                                @endphp
                            @endif

                            {{-- <div class="me-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                                    </div>
                                  
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">Create Invoice</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link flex-stack px-3">Create Payment
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i></a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">Generate Bill</a>
                                    </div>
                                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end" data-kt-menu-flip="bottom, top">
                                        <a href="#" class="menu-link px-3">
                                            <span class="menu-title">Subscription</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        
                                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Plans</a>
                                            </div>
                                            
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Billing</a>
                                            </div>
                                           
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">Statements</a>
                                            </div>
                                           
                                            <div class="separator my-2"></div>
                                            
                                            <div class="menu-item px-3">
                                                <div class="menu-content px-3">
                                                    
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        
                                                        <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications">
                                                       
                                                        <span class="form-check-label text-muted fs-6">Recuring</span>
                                                        
                                                    </label>
                                                    
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <div class="menu-item px-3 my-1">
                                        <a href="#" class="menu-link px-3">Settings</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div> --}}
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-start">
                        <div class="d-flex flex-wrap">
                            @if ($project->accept_estimate == 'accepted')
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bolder text-primary">
                                            {{ $project->start_date ? $project->start_date->format('d-M-Y') : '-' }}
                                        </div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400 ">Debut date</div>
                                </div>
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bolder text-danger ">
                                            {{ $project->due_date ? $project->due_date->format('d-M-Y') : '-' }}
                                        </div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400  ">Date de livraivon</div>
                                </div>
                            @endif
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-money-check-alt"></i> &nbsp;
                                    <div class="fs-4 fw-bolder text-primary" @if ($project->price) data-kt-countup="true" data-kt-countup-value="{{ $project->price }}" data-kt-countup-prefix="$" @endif>
                                        {{ $project->price ? "$" . $project->price : '0.000' }}</div>
                                </div>
                                <div class="fw-bold fs-6  text-gray-400">Price</div>
                            </div>
                            @if ($project->accept_estimate)
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-check-alt"></i> &nbsp;
                                        <div class="fs-4 fw-bolder" data-kt-countup="true" data-kt-countup-prefix="$">
                                            $0.00</div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400 ">Total paid</div>
                                </div>
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-check-alt"></i> &nbsp;
                                        <div class="fs-4 fw-bolder  " data-kt-countup="true" data-kt-countup-prefix="$">
                                            $0.00</div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400 ">Total not paid</div>
                                </div>
                            @endif
                        </div>
                        @if (auth()->user()->not_client())

                            <div class="symbol-group symbol-hover mb-3">
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="Alan Warden">
                                    <span class="symbol-label bg-warning text-inverse-warning fw-bolder">A</span>
                                </div>
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="Michael Eberon">
                                    <img alt="Pic" src="assets/media/avatars/150-12.jpg">
                                </div>
                                <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_view_users">
                                    <span class="symbol-label bg-dark text-inverse-dark fs-8 fw-bolder"
                                        data-bs-toggle="tooltip" data-bs-trigger="hover" title=""
                                        data-bs-original-title="View more users">+42</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="separator"></div>
            <div class="d-flex overflow-auto h-55px">
                <ul
                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 active" data-toggle="ajax-tab" data-bs-toggle="tab"
                            href="#descriptions"
                            data-loal-url="{{ url("/project/tab/description/$project->id") }}">Déscriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" data-toggle="ajax-tab" data-bs-toggle="tab"
                            href="#files" data-loal-url="#">Fichiers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" data-toggle="ajax-tab" data-bs-toggle="tab"
                            href="#activity" data-loal-url="#">Activity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" data-toggle="ajax-tab" data-bs-toggle="tab"
                            href="#invoices" data-loal-url="#">Facture et payment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6" data-toggle="ajax-tab" data-bs-toggle="tab"
                            href="#settings" data-loal-url="#">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row g-6 g-xl-9">
        <div class="tab-content" id="tab-project-details">
            <div class="tab-pane fade show active" id="descriptions" role="tabpanel"></div>
            <div class="tab-pane fade" id="files" role="tabpanel">files</div>
            <div class="tab-pane fade" id="activity" role="tabpanel">activity</div>
            <div class="tab-pane fade" id="invoices" role="tabpanel">invoices</div>
            <div class="tab-pane fade" id="settings" role="tabpanel">settings</div>
        </div>
    </div>
    @section('scripts')
        <script>
            $(document).ready(function() {
                $("#accept_estimate").on("click", function() {
                    var _this = $(this) 
                    _this.attr("data-kt-indicator", "on");
                    var projectId = _this.attr("data-project-id")
                    var uri = "{{ url('/project/accept/estimate') }}" +"/"+ projectId
                    $.ajax({
                        type: "POST",
                        data: { _token : getCsrfToken() },
                        url: uri,
                        success: function(response) {
                            _this.removeAttr("data-kt-indicator");
                            if (response.success) {
                                $("#accpeted").text(response.message)
                                toastr.success(response.message);
                                setTimeout(() => {
                                    window.location.replace(response.redirect);
                                }, 200);   
                            }else{
                                $("#accpeted").text(response.message)
                                toastr.success(response.message);
                            }
                        }
                    });
                })
            })
        </script>
    @endsection
</x-base-layout>
