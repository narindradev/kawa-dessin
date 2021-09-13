<div class="card card-custom ">
    <form class="form" id="offer-form" method="POST" action="{{ "/offer/store/$offer->id" }}"
        enctype="multipart/form-data">
        <div class="card-body ">
            @csrf
            <div class="form-group">
                <div class="mb-10">
                    <label for="title" class="required form-label">@lang('lang.title')</label>
                    <input type="text" value="{{ $offer->name }}" autocomplete="off" name="title"
                        class="form-control form-control-solid" placeholder="Titre de l'offre" data-rule-required="true"
                        data-msg-required="@lang('lang.required_input')" />
                </div>
            </div>
            <div class="form-group">
                <div class="mb-10">
                    <label for="description" class="form-label">@lang('lang.description')</label>
                    <textarea name="description" autocomplete="off" class="form-control form-control-solid" rows="5"
                        placeholder="Description de l'offre ...">{{ $offer->description ?? '' }}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light-light btn-sm mr-2 ">
                @lang('lang.cancel')</button>
            <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  mr-2">
                @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" =>
                trans("lang.sending")])
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#offer-form").appForm({
            onSuccess: function(response) {
                // dataTableInstance.offerTable.row(0).data(response.data).draw();
                dataTableInstance.offerTable.ajax.reload();
            },
        })
    })
</script>
