<div class="card card-flush mb-xl-3">
    <div class="card-header mt-5">
        <!--begin::Card title-->
        <div class="card-title flex-column">
            <h3 class="fw-bolder mb-0">Information préliminaire</h3>
        </div>
    </div>
    <div class="card-body d-flex flex-column p-10 pt-1 mb-2" id="files" class="collapse">
        @foreach ($project->descriptions as $description)
            <div class="d-flex align-items-center mb-3">
                <div class="fw-bold">
                    <span class="fw-bolder text-gray-800 "># <i>
                            {{ $description->questionnaire->question }}</i></a>
                        <p class="text-primary pl-5">>> {{ $description->answer ?? '-' }}</p>
                </div>
            </div>
        @endforeach
        @if ($count)

            <div role="button" data-bs-toggle="collapse" data-bs-target="#files-list" aria-expanded="true"
                aria-controls="files-list">
                <h3 class=" fw-bolder text-dark">Fichier(s) attachés</h3>
                <div class="fs-6 text-gray-400">Total {{ $count . ' ' . trans('lang.files') }} </div>
            </div>
            <div id="files-list" class="collapse">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="filesTable" class="table table-row-dashed table-row-gray-200  gs-0 gy-3"></table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
 @if ($project->estimate =="accepted")
    <div class="card card-flush mb-xl-3 ">
        <h3 class="card-title my-4 text-center fw-bolder text-primary">
            Information terrain
        </h3>
        <div class="card-header border-0">
            <h3 class="card-title fw-bolder text-dark fs-5">Adresse du terrain</h3>
        </div>
        <form class="form" id="info-ground-form" method="POST" action="{{ "/project/save_step2/info_ground/$project->id" }}">
            @csrf
            <input type="hidden" name="ground_info_id" value="{{ $project->infoGround->id }}">
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="card-body pt-2">
                <div class="row g-9 mb-8">
                    <div class="col-md-4 fv-row">
                        <div class="input-group mb-3">
                            <input type="text" name="street_number" value="{{$project->infoGround->street_number}}" class="form-control form-control-solid" placeholder="Numéro de voie"
                                aria-label="Numéro de voie" aria-describedby="basic-addon2">
                            <span class="input-group-text border border-transparent"><i class="fas fa-pen"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4 fv-row">
                        <div class="input-group mb-3">
                            <input type="text" name="place_said" value="{{$project->infoGround->place_said}}" autocomplete="off" class="form-control form-control-solid"
                                placeholder="Lieu dit" aria-label="Lieu dit" aria-describedby="basic-addon2">
                            <span class="input-group-text border border-transparent"><i class="fas fa-pen"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4 fv-row">
                        <div class="input-group mb-3">
                            <input type="text" name="zip" value="{{$project->infoGround->zip }}" autocomplete="off" class="form-control form-control-solid"
                                placeholder="Code postal" aria-label="Code postal" aria-describedby="basic-addon2">
                            <span class="input-group-text border border-transparent"><i class="fas fa-pen"></i></span>
                        </div>
                    </div>
    
                </div>
                <div class="row g-9 mb-8">
    
                    <div class="col-md-4 fv-row">
                        <div class="input-group mb-3">
                            <input type="text" name="community" value="{{$project->infoGround->community }}"  autocomplete="off" class="form-control form-control-solid"
                                placeholder="Commune" aria-label="commune" aria-describedby="basic-addon2">
                            <span class="input-group-text border border-transparent"><i class="fas fa-pen"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4 fv-row">
                        <div class="input-group mb-3">
                            <input type="text" name="section" value="{{$project->infoGround->section }}" autocomplete="off" class="form-control form-control-solid"
                                placeholder="Section" aria-label="Section" aria-describedby="basic-addon2">
                            <span class="input-group-text border border-transparent"><i class="fas fa-pen"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4 fv-row">
                        <div class="input-group mb-3">
                            <input type="text" name="parcel" value="{{$project->infoGround->parcel }}" autocomplete="off" class="form-control form-control-solid"
                                placeholder="Parcelle" aria-label="Parcelle" aria-describedby="basic-addon2">
                            <span class="input-group-text border border-transparent"><i class="fas fa-pen"></i></span>
                        </div>
                    </div>
    
                </div>
    
    
                <div class="separator mx-1 my-8"></div>
    
                <h3 class="card-title fw-bolder text-dark fs-5 my-9">Nature du terrain</h3>
                <div class="row g-9 mb-8">
                    <div class="col-4 fv-row">
                        <label>Lotissement</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->lotissement == "1") checked @endif  class="form-check-input" type="radio" name="lotissement" value="1">
                            <span></span>Oui</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->lotissement == "0") checked @endif class="form-check-input" type="radio" name="lotissement" value="0">
                            <span></span>Non</label>
                    </div>
    
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-4 fv-row">
                        <label>Copropriété</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->copropriete == "1") checked @endif class="form-check-input" type="radio" name="copropriete" value="1">
                            <span></span>Oui</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->copropriete == "0") checked @endif class="form-check-input" type="radio" name="copropriete" value="0">
                            <span></span>Non</label>
                    </div>
    
                </div>
    
                <div class="separator mx-1 my-8"></div>
    
                <h3 class="card-title fw-bolder text-dark fs-5 my-9">Connections aux réseaux publics</h3>
                <div class="row g-9 mb-8">
                    <div class="col-4 fv-row">
                        <label>Eau de pluie</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->eau_pluie == "1") checked @endif  class="form-check-input" type="radio" name="eau_pluie" value="1">
                            <span></span>Oui</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->eau_pluie == "0") checked @endif class="form-check-input" type="radio" name="eau_pluie" value="0">
                            <span></span>Non</label>
                    </div>
    
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-4 fv-row">
                        <label>Eau potable</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->eau_potable == "1") checked @endif class="form-check-input" type="radio" name="eau_potable" value="1">
                            <span></span>Oui</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->eau_potable == "0") checked @endif class="form-check-input" type="radio" name="eau_potable" value="0">
                            <span></span>Non</label>
                    </div>
    
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-4 fv-row">
                        <label>Elec</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->elec == "1") checked @endif class="form-check-input" type="radio" name="elec" value="1">
                            <span></span>Oui</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->elec == "0") checked @endif class="form-check-input" type="radio" name="elec" value="0">
                            <span></span>Non</label>
                    </div>
    
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-4 fv-row">
                        <label>Gaz</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input  @if($project->infoGround->gaz == "1") checked @endif class="form-check-input" type="radio" name="gaz" value="1">
                            <span></span>Oui</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->gaz == "0") checked @endif class="form-check-input" type="radio" name="gaz" value="0">
                            <span></span>Non</label>
                    </div>
    
                </div>
                <div class="row g-9 mb-8">
                    <div class="col-4 fv-row">
                        <label>Assainissement non collectif</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->assainissement == "1") checked @endif class="form-check-input" type="radio" name="assainissement" value="1">
                            <span></span>Oui</label>
                    </div>
    
                    <div class="col-4 fv-row">
                        <label class="radio radio-primary">
                            <input @if($project->infoGround->assainissement == "0") checked @endif class="form-check-input" type="radio" name="assainissement" value="0">
                            <span></span>Non</label>
                    </div>
    
                </div>
    
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  mr-2">@include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" =>trans("lang.sending")])</button>
            </div>
        </form>
    </div>
 @endif

@if (0)
    <div class="card card-xl-stretch mb-xl-8 ">
        <h3 class="card-title my-4 text-center fw-bolder text-primary">
            Information des bâtiments existants
        </h3>
        <div class="card-body pt-2">
            <div class="row">
                @foreach ($project->categories as $categorie)
                    @if ($categorie->offer->questionnaires->count())
                        <div class="col-md-5">
                            <p class="text-primary pl-5">{{ $categorie->offer->name }} </p>
                            @foreach ($categorie->offer->questionnaires as $questionnaire)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="fw-bold col-9">
                                        <p class="fw-bolder text-gray-800 "># <i>{{ $questionnaire->question }}</i></p>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-solid" placeholder="@lang("lang.response")" aria-label="@lang("lang.response")"aria-describedby="basic-addon2">
                                            <span class="input-group-text border border-transparent"><i class="fas fa-pen"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="card card-xxl-stretch mb-xl-3">
        <h3 class="card-title my-4 text-center fw-bolder text-primary">
            Questionnaires pour chaque type de projet
        </h3>
        <div class="card-body d-flex flex-column">
            <div class="row g-9 mb-8">
                @foreach ($project->categories as $categorie)
                    @if ($categorie->questionnaires->count())
                        <div class="col-md-4 fv-row">
                            <h3 class="card-title text-center fw-bolder text-dark fs-5 my-9">{{ $categorie->name }}</h3>
                            @foreach ($categorie->questionnaires as $questionnaire) 
                                <div class="row my-4">
                                    <p class="fw-bolder text-gray-800 "># <i>{{ $questionnaire->question }}</i></p>
                                    <textarea class="form-control form-control-solid" data-kt-autosize="true" rows="2"></textarea>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <!--end::Body-->
    </div>
@endif
<style>
    .dataTables_wrapper table thead {
        display: none;
    }
</style>
@if ($count)
    <script>
        $(document).ready(function() {
            dataTableInstance.filesTable = $("#filesTable").DataTable({
                processing: true,
                dom: "t",
                columns: [{
                        title: '',
                        "class": "text-left"
                    },
                    {
                        title: '',
                        "class": "text-center"
                    },
                ],
                ajax: {
                    url: url("/project/files/list/{{ $project->id }}"),
                },
            });
        })
    </script>
@endif

<script>
    $(document).ready(function() {
        $("#info-ground-form").appForm({
            //submitBtn :"#submit-info-groun",
            onSuccess: function(response) {
                console.log(response)
            },
        })
    })
</script>
