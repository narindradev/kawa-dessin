<div class="card card-xxl-stretch scroll h-550px px-5">
    <div class="card-header align-items-center border-0 mt-4">
        <h3 class="card-title align-items-start flex-column">
            <span class="fw-bolder mb-2 text-dark">Activités</span>
        </h3>
    </div>
    <div class="card-body pt-3">
        <div class="timeline-label">
            @foreach ($activities as $data)
                @if ($data)
                    {!! view('dashboard.widgets.activities.item', ['data' => $data]) !!}
                @endif
            @endforeach
        </div>
    </div>
    <div class="card-footer text-center" style="padding: 0rem 2.25rem;">
        <form class="form" id="load-more-activity" method="POST" action="{{ url("/load/more/activities") }} ">
                @csrf
                <input type="hidden" name="offset" id="offest-activity"  value=8>
                <button type="submit" id="submit-load-more" class=" text-muted btn-sm btn btn-active-light mt-2">
                    @include('partials.general._button-indicator', ['label' => trans('lang.load_more') ,"message" => "..."])
                </button>
        </form>
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        $("#load-more-activity").appForm({
            isModal: false,
            showAlertSuccess : false,
            onSuccess: function(response) {
                $("#offest-activity").val(response.offset)
                if (response.html) {
                    $(".activity-item:last").after(response.html)
                }else{
                    $("#submit-load-more").css("display" , "none")
                }
                return false;
            },
        })
    })
</script> 
@endsection


