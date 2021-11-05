<form class="form" id="member-form" method="POST" action="{{ "/project_member/assign/" }}">
    @csrf
    <div class="card-body ">
        <div class="mb-1">
            <input class="form-control form-control form-control-solid my-5" id="search_member" autocomplete="off" data-kt-autosize="true" placeholder="{{ trans('lang.search') }}" rows="1">
        </div>
        <div class="mb-2">
            <div class="mh-300px scroll-y me-n7 pe-7">
                <div class="table-responsive">
                    <table id="memberTable" class="table table-row-dashed align-middle table-hover"></table>
                </div>
            </div>
        </div>
    </div>
    <div class="separator mx-1 my-8"></div>
        <div class="d-flex justify-content-end" >
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light-light btn-sm mr-2 "> @lang('lang.close')</button>
            <button type="submit" id="add-member"   class=" btn btn-sm btn-light-primary  mr-2">
                @include('partials.general._button-indicator', ['label' => trans('lang.save') , "message" => trans("lang.sending")])
            </button>
        </div>
</form>
<style>
    #memberTable thead {
    display:none;
}
</style>
<script>
    $(document).ready(function() {
        dataTableInstance.memberTable = $("#memberTable").DataTable({
                    dom : 'tr',
                    processing: true,
                    columns: [
                        {data: 'member_info',"class":"text-left","orderable":false,"searchable":true},
                        {data: 'select',"class":"text-right","orderable":false,"searchable":false},
                    ],
                    ajax: {
                        url: url("/project_member/data_list_member"),
                        data: function(data){
                            data.project_id = @json($project_id);
                            data.user_type_id = @json($user_type_id);
                            return data;
                        }
                    },
        });
        $('#search_member').on('keyup', function() {
            dataTableInstance.memberTable.search(this.value).draw();
        });

        $("#member-form").appForm({
            onSuccess: function(response) {
                if (response.data) {
                    dataTableUpdateRow(dataTableInstance.projectsTable, response.row_id, response.data)
                }
            },
        })

    } );
</script>
