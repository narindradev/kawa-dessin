@extends('base.base')

@section('content')
    <div class="post d-flex flex-column-fluid p-20" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Stepper-->
                    <div class="stepper stepper-links d-flex flex-column pt-15" id="kt_create_account_stepper"
                        data-kt-stepper="true">
                        <!--begin::Nav-->
                        <div class="stepper-nav mb-5">
                            <!--begin::Step 1-->
                            <div class="stepper-item current" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Information de client </h3>
                            </div>
                            <!--end::Step 1-->
                            <!--begin::Step 2-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Choix du projet</h3>
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Information préliminaire </h3>
                            </div>
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Documents</h3>
                            </div>
                            <!--end::Step 3-->
                            <!--begin::Step 4-->
                            <!--end::Step 4-->
                            <!--begin::Step 5-->
                            <div class="stepper-item" data-kt-stepper-element="nav">
                                <h3 class="stepper-title">Completed</h3>
                            </div>
                            <!--end::Step 5-->
                        </div>
                        <!--end::Nav-->
                        <!--begin::Form-->
                        <form method="POST" action="{{ url('home/request/save') }}"
                            class="mx-auto mw-900px w-100 pt-15 pb-10 fv-plugins-bootstrap5 fv-plugins-framework "
                            novalidate="novalidate" id="request-form" enctype="multipart/form-data">
                            <!--begin::Step 1-->
                            <div class="current" data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="w-100">
                                    <!--begin::Heading-->
                                    <div class="pb-5 pb-lg-1">
                                        <!--begin::Title-->
                                        <h2 class="fw-bolder d-flex align-items-center text-dark">Type du client
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Billing is issued based on your selected account type"
                                                aria-label="Billing is issued based on your selected account type"></i>
                                        </h2>
                                        <!--end::Title-->
                                        <!--begin::Notice-->

                                        <!--end::Notice-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Input group-->
                                    <div class="fv-row fv-plugins-icon-container">
                                        <!--begin::Row-->
                                        <div class="row">

                                            <!--begin::Col-->
                                            <div class="col-lg-6">

                                                <!--begin::Option-->
                                                <input type="radio" class="btn-check client_type" name="client_type"
                                                    value="particular" checked="checked" id="client_type_particular">
                                                <label
                                                    class="btn btn-outline btn-outline-dashed btn-outline-default p-4 d-flex align-items-center mb-10"
                                                    for="client_type_particular">
                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                                                    <span class="svg-icon svg-icon-3x me-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                                                fill="black"></path>
                                                            <path opacity="0.3"
                                                                d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                                                fill="black"></path>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <!--begin::Info-->
                                                    <span class="d-block fw-bold text-start">
                                                        <span
                                                            class="text-dark fw-bolder d-block fs-4 mb-2">Particulier</span>
                                                        <span class="text-muted fw-bold fs-6"></span>
                                                    </span>
                                                    <!--end::Info-->
                                                </label>
                                                <!--end::Option-->
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-lg-6">
                                                <!--begin::Option-->
                                                <input type="radio" class="btn-check client_type" name="client_type"
                                                    value="corporate" id="client_type_corporate">
                                                <label
                                                    class="btn btn-outline btn-outline-dashed btn-outline-default p-4 d-flex align-items-center"
                                                    for="client_type_corporate">
                                                    <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                                    <span class="svg-icon svg-icon-3x me-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3"
                                                                d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                                                fill="black"></path>
                                                            <path
                                                                d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                                                fill="black"></path>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <!--begin::Info-->
                                                    <span class="d-block fw-bold text-start">
                                                        <span class="text-dark fw-bolder d-block fs-4 mb-2">Entreprise
                                                        </span>
                                                    </span>
                                                    <!--end::Info-->
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                    </div>

                                    <div class="pb-10 pb-lg-1">
                                        <!--begin::Title-->
                                        <h2 class="fw-bolder d-flex align-items-center text-dark">Information du client
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                                                data-bs-original-title="Billing is issued based on your selected account type"
                                                aria-label="Billing is issued based on your selected account type"></i>
                                        </h2>

                                    </div>
                                    <div class="row gx-5 mb-4">
                                        <!--begin::Col-->
                                        {{-- <div
                                            class=" col-lg-6 pb-lg-1 fv-row mb-4  fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <label class="form-label required">Non</label>
                                            <input name="first_name" autocomplete="off" value="aaa"
                                                class="form-control form-control-lg form-control-solid">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <div class="dropzone" id="filelist">
                                            <div class="dz-message needsclick">
                                                <!--begin::Icon-->
                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                <!--end::Icon-->
                                
                                                <!--begin::Info-->
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                    <span class="fs-7 fw-bold text-gray-400">Upload up to 10 files</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        </div> --}}
                                       

                                        {{-- <div class="dropzone" id="filelist">
                                            <!--begin::Message-->
                                            <div class="dz-message needsclick">
                                                <!--begin::Icon-->
                                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                <!--end::Icon-->
                                
                                                <!--begin::Info-->
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                    <span class="fs-7 fw-bold text-gray-400">Upload up to 10 files</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        </div> --}}
                                        <div
                                        class=" col-lg-6 pb-lg-1 fv-row mb-4  fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                        <label class="form-label required">Name</label>
                                        <input name="first_name" autocomplete="off" value="aaa"
                                            class="form-control form-control-lg form-control-solid">
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                    
                                   
                                      

                                        <div class=" col-lg-6 pb-lg-1 fv-row mb-4  fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <label class="form-label required">Prénom</label>
                                            <input name="last_name" autocomplete="off" value="aaa"
                                                class="form-control form-control-lg form-control-solid">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>


                                        <div
                                            class=" col-lg-7 pb-lg-1 fv-row mb-4  fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <label class="form-label required">E-mail</label>
                                            <input name="email" autocomplete="off" value="example@gmail.com"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="example@gmail.com">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <div
                                            class=" col-lg-5 pb-lg-0 fv-row mb-4  fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <label class="form-label required">Téléphone</label>
                                            <input name="phone" autocomplete="off" value="aa"
                                                class="form-control form-control-lg form-control-solid" placeholder="+33 ">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <div
                                            class=" col-lg-4 pb-lg-1 fv-row mb-4  fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <label class="form-label required">Address</label>
                                            <input name="address" autocomplete="off" value="aa"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Address">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <div
                                            class="col-lg-4 pb-lg-1 fv-row mb-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <label class="form-label required">Ville</label>
                                            <input name="city" autocomplete="off" value="aa"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder=" Ville">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <div
                                            class=" pb-lg-1 col-lg-4 fv-row mb-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                            <label class="form-label required">Code postal</label>
                                            <input name="zip" autocomplete="off" value="aa"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="Code postal ">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>




                                        <!--end::Col-->
                                    </div>

                                    <div id="corport_info" style="display: none">

                                        <div class="pb-10 pb-lg-1">
                                            <!--begin::Title-->
                                            <h2 class="fw-bolder d-flex align-items-center text-dark">Information de
                                                l'entreprise
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                    title=""
                                                    data-bs-original-title="Billing is issued based on your selected account type"
                                                    aria-label="Billing is issued based on your selected account type"></i>
                                            </h2>
                                        </div>

                                        <div class="row gx-5 mb-4">

                                            <div
                                                class="col-lg-6 pb-lg-1 fv-row mb-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                                <label class="form-label required">Raison sociale</label>
                                                <input name="company_name" autocomplete="off"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder=" Raison sociale">
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <div
                                                class=" pb-lg-1 col-lg-6 fv-row mb-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                                <label class="form-label required">Siège social</label>
                                                <input name="company_head_office" autocomplete="off"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Siège social ">
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <div
                                                class=" pb-lg-1 col-lg-5  fv-row mb-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                                <label class="form-label required">Numero SIRET</label>
                                                <input name="siret" autocomplete="off"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Numero SIRET ">
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <div
                                                class=" pb-lg-1 col-lg-4 fv-row mb-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                                <label class="form-label required">Numéro de TVA</label>
                                                <input name="num_tva" autocomplete="off"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Num de TVA intercommunautaire ">
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                            <div
                                                class=" pb-lg-1 col-lg-3 fv-row mb-4 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                                <label class="form-label">Tél</label>
                                                <input name="company_phone" autocomplete="off"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Tél. de l'entreprise">
                                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 1-->


                            <!--begin::Step 2-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="w-100">
                                    <!--begin::Heading-->
                                    <div class="pb-3 pb-lg-5">
                                        <!--begin::Title-->
                                        <h2 class="fw-bolder text-dark">Choissez de votre porjet</h2>
                                        <!--end::Title-->
                                        <!--begin::Notice-->
                                        <div class="text-muted fw-bold fs-6">If you need more info, please check out
                                            <a href="#" class="link-primary fw-bolder">Help Page</a>.
                                        </div>
                                        <!--end::Notice-->
                                    </div>
                                    <!--end::Heading-->

                                    <div class="row form-group" data-kt-buttons="true">
                                        <div class=" mb-5  fv-row fv-plugins-icon-container">
                                            @foreach ($offers as $offer)
                                                <h4 class="fw-bolder text-dark">{{ $offer->name }}
                                                    @if ($offer->description)

                                                        <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="{{ $offer->description }}">
                                                        </i>
                                                    @endif
                                                </h4>
                                                <div class="row mb-5">
                                                    @foreach ($offer->categories as $categorie)
                                                        <div class="col-4 pb-2 ">

                                                            <label
                                                                class="btn btn-outline btn-outline-dashed btn-outline-default w-100 p-40">

                                                                <input type="radio" class="btn-check" name="categorie"
                                                                    value=" {{ $categorie->id }}">

                                                                <span>{{ ucfirst($categorie->name) }}</span>

                                                            </label>
                                                            <!--end::Option-->
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach


                                        </div>

                                        {{-- <div class="mb-8 fv-row ">
                                            <!--begin::Label-->
                                            <h4 class="fw-bolder text-dark ">Annexe
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                    title=""
                                                    data-bs-original-title="Provide your team size to help us setup your billing"
                                                    aria-label="Provide your team size to help us setup your billing"></i>
                                            </h4>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row mb-5" data-kt-buttons="true">
                                                <!--begin::Col-->
                                                <div class="col-3 pb-2">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-outline-default w-100 p-50">
                                                        <input type="radio" class="btn-check" name="type_project"
                                                            value="1-1">
                                                        <span class="fw-bolder">Abris de jardin</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-3 pb-2">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-outline-default w-100 p-50 ">
                                                        <input type="radio" class="btn-check" name="type_project"
                                                            checked="checked" value="2-10">
                                                        <span class="fw-bolder">Carport/Garage</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-3  pb-2">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-outline-default w-100 p-50">
                                                        <input type="radio" class="btn-check" name="type_project"
                                                            value="10-50">
                                                        <span class="fw-bolder ">Panneaux solaire </span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-3 pb-2">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-outline-default w-100 p-50">
                                                        <input type="radio" class="btn-check" name="type_project"
                                                            value="50+">
                                                        <span class="fw-bolder ">Picine </span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <div class="col-3 pb-2">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-outline-default w-100 p-50">
                                                        <input type="radio" class="btn-check" name="type_project"
                                                            value="50+">
                                                        <span class="fw-bolder ">Potail </span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <div class="col-3 pb-2">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-outline-default w-100 p-50">
                                                        <input type="radio" class="btn-check" name="type_project"
                                                            value="50+">
                                                        <span class="fw-bolder ">Terasse</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <div class="col-3 pb-2">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-outline-default w-100 p-50">
                                                        <input type="radio" class="btn-check" name="account_team_size"
                                                            value="50+">
                                                        <span class="fw-bolder ">Autre</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                            <!--begin::Hint-->

                                            <!--end::Hint-->
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div> --}}
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>


                                    <!--end::Input group-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 2-->
                            <!--begin::Step 3-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="w-100">

                                    <!--begin::Heading-->
                                    <div class="pb-10 pb-lg-12">
                                        <!--begin::Title-->
                                        <h2 class="fw-bolder text-dark">Information requis</h2>
                                        <!--end::Title-->
                                        <!--begin::Notice-->
                                        <div class="text-muted fw-bold fs-6">If you need more info, please check out
                                            <a href="#" class="link-primary fw-bolder">Help Page</a>.
                                        </div>
                                        <!--end::Notice-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Input group-->

                                    @foreach ($questions as $question)
                                        <div class="fv-row mb-10 fv-plugins-icon-container">
                                            <!--begin::Label-->
                                            <label
                                                class="form-label required">{{ get_array_value($question, 'question') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea placeholder="..." name="{{ get_array_value($question, 'name') }}"
                                                class="form-control form-control-lg form-control-solid"
                                                data-kt-autosize="true"
                                                rows="{{ get_array_value($question, 'rows') ?? '1' }}">aaa</textarea>
                                            <!--end::Input-->
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                    @endforeach

                                    <!--begin::Col-->

                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Step 3-->

                            <!--begin::Step 5-->
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                <div class="w-100">
                                    <!--begin::Heading-->
                                    <div class="pb-8 pb-lg-10">
                                        <!--begin::Title-->
                                        <h2 class="fw-bolder text-dark">Documents</h2>
                                        <!--end::Title-->
                                        <!--begin::Notice-->

                                        <div class="text-muted fw-bold fs-6">Docs: Esquisse, plan, photo, courrier de la
                                            mairie</div>
                                        <!--end::Notice-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div class="mb-0 fv-row form-group">
                                        <!--begin::Text-->
                                        <div class="form-group fs-6 text-gray-600 mb-5"></div>
                                        <!--end::Text-->
                                        <!--begin::Alert-->
                                        <script>
                                            var max = 1
                                             function del(params) {
                                               
                                                if(max > 1){
                                                    max--
                                                    $(params).closest('.file-input').remove()
                                                }
                                            }
                                            function add() {
                                                if(max < 6 ){
                                                    max++
                                                    $("#div").clone().insertBefore("#div").find("input[type='file']").val("");
                                                }
                                            }
                                        </script>
                                         <div class="row mb-2 ">
                                            <div class="col-lg-4" id="add" onClick="add()">
                                                <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                                <i class="la la-plus"></i></a>
                                            </div>
                                        </div>
                                       
                                        <div class="row  mb-1 file-input" id="div">
                                            <div class="col-md-11">
                                                <input class="form-control form-control-sm" name="files[]" type="file">
                                            </div>
                                            <button type="button" onClick="del(this)" class="btn btn-sm btn-icon btn-light-danger col-1 "><i class="la la-trash-o"></i></button>
                                        </div>
                                     
                                        <div class="fv-plugins-icon-container">
                                            <!--begin::Option-->
                                            <div class="pt-5 form-check form-check-custom form-check-solid"
                                                style="display: block;">
                                                <input class="form-check-input" type="checkbox" name="accept"
                                                    value="accept" id="accept" />
                                                <label class="form-check-label col-12" for="accept"
                                                    style=" display: inline;">
                                                    En soumettant ce formulaire, j'accepte que mes informations sont
                                                    utilisées dans la cadre de ma demande.
                                                </label><br>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end::Body-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <div data-kt-stepper-element="content">
                                <!--begin::Wrapper-->
                                
                                <div class="w-100">
                                    <div class="pb-8 pb-lg-10">
                                        <!--begin::Title-->
                                        <h2 class="fw-bolder text-dark">Nous avons besoin de votre attention!</h2>
                                        <!--end::Title-->
                                        <!--begin::Notice-->

                                        
                                        <!--end::Notice-->
                                    </div>
                                    <!--begin::Heading-->
                                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                        <!--begin::Icon-->
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                        <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
                                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black"></rect>
                                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black"></rect>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <!--end::Icon-->
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <!--begin::Content-->
                                            <div class="fw-bold">
                                                <h4 class="text-gray-900 fw-bolder"></h4>
                                                <div class="fs-6 text-gray-700">Des e-mails seront envoyés sur l'email precedente. Et vous aurrez un espace d'utilisateur liée a votre e-mail pour que vous puissez suivre et supervier le traitretement de votre dossier. 
                                                {{-- <a href="#" class="fw-bolder">Create Team Platform</a>--}}
                                            </div> 
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                  
                                </div>
                                <!--end::Wrapper-->
                            </div>

                            <!--end::Step 5-->
                            <!--begin::Actions-->
                            <div class="separator my-1"></div>

                            <div class="d-flex flex-stack pt-15">
                                <!--begin::Wrapper-->
                                <div class="mr-2">
                                    <button type="button" class="btn btn-lg btn-light-primary me-3"
                                        data-kt-stepper-action="previous">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                                        <span class="svg-icon svg-icon-4 me-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="black">
                                                </rect>
                                                <path
                                                    d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                                    fill="black"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->@lang('lang.prev')
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Wrapper-->
                                <div>
                                    <button type="button" id="submit" class="btn btn-lg btn-primary me-3"
                                        data-kt-stepper-action="submit">
                                        <span class="indicator-label">@lang('lang.send')
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                            <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                        transform="rotate(-180 18 13)" fill="black"></rect>
                                                    <path
                                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                        fill="black"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <span class="indicator-progress"> @lang('lang.waiting')
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <button type="button" class="btn btn-lg btn-primary"
                                        data-kt-stepper-action="next">@lang('lang.next')
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                        <span class="svg-icon svg-icon-4 ms-1 me-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                                    transform="rotate(-180 18 13)" fill="black"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="black"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Stepper-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
<style>
    .file-preview {
    border: 1px dashed #3699FF !important;
    padding: 8px;
    width: 100%;
    margin-bottom: 5px;
}
    .explorer-frame:hover{
        background-color: #2B2B40;
    }
    .theme-explorer .file-preview-frame {
    border: 0px dashed #2B2B40 !important; 
    margin: 2px 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.file-drop-zone {
    border: 0px dashed #3699FF !important;
    min-height: 260px;
    border-radius: 4px;
    text-align: center;
    vertical-align: middle;
    margin: 12px 15px 12px 12px;
    padding: 5px;
}
.kv-file-upload{
    /* display: none  !important */
}
.file-upload-indicator{
    /* display: none  !important */
}
.btn.btn-flex {
    display: list-item;
    align-items: center;
}
</style>
    
@endsection
@section('scripts')
    @include('home.step-script',["questions" => count($questions)])
<script>
    $(document).ready(function () {
   
    })
</script>
@endsection
