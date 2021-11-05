<div class="card card-custom ">
    <form class="form" id="start-form" method="POST" action="{{ "/project/start/add/$project->id" }}"
        enctype="multipart/form-data">
        <div class="card-body ">    
            <div class="mb-10">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-40px symbol-circle me-5">
                        <span class="symbol-label bg-primary text-inverse-primary fw-bolder">{{ strtoupper($project->client->user->name[0]) }}</span>
                        {{-- <img src="http://127.0.0.1:8000/demo1/media/avatars/150-11.jpg" alt=""> --}}
                    </div>
                    <div class="d-flex justify-content-start flex-column">
                        @if (isset($link))
                            <a href="{{ "/project/detail/$project->id" }}" class="text-dark fw-bolder text-hover-primary fs-6">{{ $project->client->user->name }}
                            </a>
                        @else
                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{ $project->client->user->name }}
                        </a>
                     
                        @endif
                        <span class="text-muted fw-bold text-muted d-block fs-7">
                            @php
                                // echo mailing($project->client->user->email, ['class' => 'text-gray-600', 'data-mail' => true, 'mail' => $project->client->user->email,'title' => trans('lang.mail-to')]);
                            @endphp
                        </span>
                    </div>
                </div>
            </div>
            @csrf
            <div class="form-group">
                <div class="row mb-10">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Date</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <?php 
                            $default_date = "";
                            if(!empty($project->start_date)) {
                                $default_date = $project->start_date->format('d/m/Y').' - '.$project->due_date->format('d/m/Y');
                            }
                        ?>
                        <input class="form-control form-control-solid" name="dates" placeholder="" value="{{$default_date}}" id="date-start-project"/>
                    </div>
                </div>
                <div class="row mb-10">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">@lang('lang.status')</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <select class="form-select form-select-solid" name="status" data-hide-search="true" data-control="select2" data-placeholder="Select an option">
                            <option value="0" selected >-- @lang('lang.status') --</option>
                            @foreach ($status as $statu)
                                <option value="{{ get_array_value($statu, 'value') }}">{{ get_array_value($statu, 'text') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light-light btn-sm mr-2 ">
                @lang('lang.cancel')</button>
            <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  mr-2">
                @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" => trans("lang.sending")])
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        KTApp.initSelect2();
        $("#users-form").appForm({
            onSuccess: function(response) {
                dataTableaddRowIntheTop(dataTableInstance.usersTable,response.data)
            },
        })
    })
</script>
<style>
    .modal-content{
        margin-top: 5%;
    }
</style>
<script>
    $(document).ready(function() {
        $("#start-form").appForm({
            onSuccess: function(response) {
                if (response.project) {
                    dataTableUpdateRow(dataTableInstance.projectsTable, response.row_id, response.project)
                }
            },
        })
        $("#date-start-project").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            },
        });
    })
</script>
