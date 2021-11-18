<x-base-layout>
    <div class="card mb-6 mb-xl-9 shadow-sm col-md-12">
        <div class="card-header mt-5 ">
            @include('project.detail.state' , ["project" => $project ,"states" => $states])
        </div>
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
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
                            @if (auth()->user()->is_client())
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
                            @endif
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
                                    <div class="fs-4 fw-bolder text-primary" @if ($project->price) data-kt-countup="true" data-kt-countup-value="{{ $project->price }}" data-kt-countup-prefix="{{app_setting("currency_symbole")}}" @endif>
                                        {{format_to_currency( $project->price ? $project->price  : '0.000' )}}
                                    </div>
                                </div>
                                @if ($project->estimate == 'accepted')
                                    <div class="fw-bold fs-6  text-gray-400">{{ trans("lang.price") }} ( taxe : {{get_array_value($invoice_data,"taxe_percent")}}% )</div>
                                @endif
                            </div>
                            @if ($project->estimate == 'accepted')
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-check-alt"></i> &nbsp;
                                        <div class="fs-4 fw-bolder" data-kt-countup="true" data-kt-countup-prefix="{{app_setting("currency_symbole")}}">
                                            {{format_to_currency(get_array_value($invoice_data,"total_paid"))}}
                                        </div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400 ">{{ trans("lang.total_paid") }}</div>
                                </div>
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-check-alt"></i> &nbsp;
                                        <div class="fs-4 fw-bolder  " data-kt-countup="true" data-kt-countup-prefix="{{app_setting("currency_symbole")}}">
                                            {{format_to_currency(get_array_value($invoice_data,"rest_to_paid"))}} 
                                        </div>
                                    </div>
                                    <div class="fw-bold fs-6 text-gray-400 ">{{ trans("lang.total_not_paid") }}</div>
                                </div>
                            @endif
                        </div>
                        @if (auth()->user()->not_client())
                        <div class="symbol-group symbol-hover mb-3">
                            @foreach ( get_cache_member($project) as $member)
                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$member->name}}">
                                    <img alt="Pic" src="{{ $member->avatar_url }}"> 
                                </div>
                            @endforeach
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
