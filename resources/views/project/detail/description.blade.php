<div class="row g-6 g-xl-9">
    <div class="col-lg-6">
        <div class="card card-flush h-lg-100">
            <!--begin::Card header-->
            <div class="card-header mt-5">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bolder mb-0">Information préliminaire</h3>
                </div>
            </div>
            
            <div class="card-body d-flex flex-column p-10 pt-1 mb-2">
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
                    <div class="table-responsive">
                        <h3 class=" fw-bolder text-dark">Fichier(s) attachés</h3>
                        <div class="fs-6 text-gray-400">Total {{ $count . ' ' . trans('lang.files') }} </div>
                        <table id="filesTable" class="table table-row-dashed table-row-gray-200  gs-0 gy-3"></table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
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
                columns: [
                    {title: '',"class":"text-left"},
                    {title: '',"class":"text-center"},
                ],
                ajax: {
                    url: url("/project/files/list/{{ $project->id }}"),
                },
            });
        })
    </script>
@endif
