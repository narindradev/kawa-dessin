<div class="card card-flush ">
    <div class="card-header border-0 pt-2">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">@lang('lang.projects_list')</span>
            <span class="text-muted mt-1 fw-bold fs-7">Over 500 members</span>
        </h3>
        <div class="card-toolbar" >
            <div class="mr-2 me-4 my-2" >
                <a href="javascript:void(0)" id="refresh-project-list" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                data-bs-original-title="@lang('lang.refresh')" class=""><i class="fas fa-sync-alt fs-1x"></i></a>
            </div>
            @php
                echo modal_anchor(url('/category/modal_form/'), '<i class="fas fa-plus"></i>' . trans('lang.add_new_project'), ['class' => 'btn btn-sm btn-light-primary  me-4 my-2']);
            @endphp
        </div>
    </div>
    <div class="card-body pt-1">
        <div class=" table-responsive">
            <table id="projectsTable" class="table table-row-dashed align-middle  table-hover"></table>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        $(document).ready(function() {
            dataTableInstance.projectsTable = $("#projectsTable").DataTable({
                dom: 'tir',
                processing: true,
                columns: [
                    {data: 'badge',"title" :"","class":"text-left","orderable":false,"searchable":false},
                    {data: 'offer',"title" :"Project","class":"text-left","orderable":false,"searchable":false},
                    {data: 'categories',"title" :"Type de projet","class":"text-left","orderable":false,"searchable":false},
                    {data: 'status',"title" :"Statut","orderable":true,"searchable":false,"class":"text-center"},
                    // {data: 'messenger',"title" :"","orderable":true,"searchable":false,"class":"text-center w-2"},
                    {data: 'estimate',"title" :"Devis","orderable":true,"searchable":false,"class":"text-center"},
                    {data: 'version',"title" :"version","orderable":true,"searchable":false,"class":""},
                    {data: 'invoice',"title" :"Facture","orderable":true,"searchable":false,"class":""},
                    {data: 'payment',"title" :"Paiment","orderable":true,"searchable":false,"class":"text-center"},
                    {data: 'end_date',"title" :"Date de livraison","orderable":true,"searchable":false,"class":"text-center"},
                ],
                ajax: {
                    url: url("/client/project/list"),
                }
            });
            $('#refresh-project-list').on('click', function() {
                dataTableInstance.projectsTable.ajax.reload();
            });
        })
    </script>
@endsection
