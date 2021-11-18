<div class="card card-custom ">
    <form class="form" id="start-form" method="POST" action="{{ "/project/start/add/$project->id" }}"
        enctype="multipart/form-data">
        <div class="card-body ">    
            <div class="mb-5">
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
                <div class="row mb-5">
                    <label class="col-form-label text-right col-lg-5">@lang('lang.start_end_date')  </label>
                    <div class="col-md-7">
                        <?php 
                            $default_date = "";
                            if($project->start_date) {
                                $default_date = $project->start_date->format('d/m/Y').' - '.$project->due_date->format('d/m/Y');
                            }
                        ?>
                        <input class="form-control form-control-solid" autocomplete="off" name="dates" placeholder="@lang('lang.start_end_date')  " value="{{$default_date}}" id="date-start-project"/>
                    </div>
                </div>
                <div class="row mb-5">
                    <label class="col-form-label text-right col-lg-5">@lang('lang.delivery_date')</label>
                    <div class="col-md-7">
                        <?php 
                            $deliver_date = "";
                            if($project->delivery_date) {
                                $deliver_date = $project->delivery_date->format('d/m/Y');
                            }
                        ?>
                        <input class="form-control form-control-solid" autocomplete="off" name="delivery_date" value="{{$deliver_date}}" placeholder="@lang('lang.delivery_date')" id="date_delivery"/>
                    </div>
                </div>
                <div class="row mb-5">
                    <label class="col-form-label text-right col-lg-5">@lang('lang.status')</label>
                    <div class="col-md-7">
                        <select class="form-select form-select-solid" name="status" data-hide-search="true" data-control="select2" data-placeholder="Select an option">
                            <option value="0" disabled >-- @lang('lang.status') --</option>
                                @foreach ($status as $s)
                                    <option @if($project->status_id ===  get_array_value($s, 'value') ) selected @endif value="{{ get_array_value($s, 'value') }}">{{ get_array_value($s, 'text') }}</option>
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
        var format = 'DD/MM/YYYY';
        $("#date-start-project").daterangepicker({
            locale: {
                format: format,
            },
        });
        var monthNames = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        var daysOfWeek =['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven','Sam'];
        var start = $("#date-start-project").daterangepicker({
            drops: 'auto',
            autoUpdateInput: false,
            locale: {
                format: format,
                applyLabel: "{{ trans('lang.apply') }}",
                cancelLabel: "{{ trans('lang.cancel') }}",
                daysOfWeek: daysOfWeek,
                monthNames: monthNames,
            },
        });
        var deliver = $("#date_delivery").daterangepicker({
            drops: 'auto',
            singleDatePicker: true,
            autoUpdateInput: false,
            autoApply: false,
            locale: {
                defaultValue: "",
                format: format,
                applyLabel: "{{ trans('lang.apply') }}",
                cancelLabel: "{{ trans('lang.cancel') }}",
                daysOfWeek: daysOfWeek,
                monthNames: monthNames,
            },
        });
        deliver.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format(format))
        });
        start.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format(format) + " - " +  picker.endDate.format(format))
        });
        // deliver.on('cancel.daterangepicker', function(ev, picker) {
        //     $(this).val('');
        // });
        <?php if(empty($project->start_date) && empty($project->due_date)) { ?>
            start.val('');
        <?php } ?>

        <?php if($project->delivery_date == null) { ?>
            deliver.val('');
        <?php } ?>
    })
</script>
