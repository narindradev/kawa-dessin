<x-base-layout>
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-6">
            <h3 class="card-data align-items-start flex-column">
                Liste des projects
            </h3>
        </div>
    </div>
    <div class="card card-flush ">
        <div class="card-header mt-5">
            <div class="card-data flex-column">
                <h3 class="fw-bolder mb-1"></h3>
                <div class="fs-6 text-gray-400"></div>
            </div> 
        </div>
        <div class="card-body">
            <table id="projectClientTable" class="table table-row-dashed align-middle table-hover gy-1"></table>
        </div>
    </div>
    @section('scripts')
        <script>
            $(document).ready(function() {
                dataTableInstance.projectClientTable = $("#projectClientTable").DataTable({
                    dom : 'tir',
                    processing: true,
                    columns: [
                        {data: 'badge',"title" :"","class":"text-left","orderable":false,"searchable":false},
                        {data: 'offer',"title" :"Project","class":"text-left","orderable":false,"searchable":false},
                        {data: 'categories',"title" :"Type de projet","class":"text-left","orderable":false,"searchable":false},
                        {data: 'status',"title" :"Statut","orderable":true,"searchable":false,"class":"text-center"},
                        {data: 'messenger',"title" :"","orderable":true,"searchable":false,"class":"text-center w-2"},
                        {data: 'estimate',"title" :"Devis","orderable":true,"searchable":false,"class":"text-center"},
                        {data: 'version',"title" :"version","orderable":true,"searchable":false,"class":"text-center w-2"},
                        {data: 'end_date',"title" :"Date de livraison","orderable":true,"searchable":false,"class":"text-center"},
                    ],
                    ajax: {
                        url: url("/client/project/list"),
                    }
                });
                $('#search_project').on('keyup', function() {
                    dataTableInstance.projectClientTable.search(this.value).draw();
                });
                $('#do-search-project').on('click', function() {
                    dataTableInstance.projectClientTable.ajax.reload();
                });
            })
        </script>
    @endsection
</x-base-layout>
