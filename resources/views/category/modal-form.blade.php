<div class="card card-custom ">
    <form class="form" id="category-form" method="POST" action="{{ "/category/store/$offer->id/$category->id" }}">
        <div class="card-body ">
            @csrf
            <div class="form-group">
                <div class="mb-10">
                    <label for="name" class="required form-label">@lang('lang.name')</label>
                    <input type="text" value="{{ $category->name }}" autocomplete="off" name="name" class="form-control form-control-solid"
                        placeholder="Nom du categorie" data-rule-required="false"
                        data-msg-required="@lang('lang.required_input')" />
                </div>
            </div>
            <div class="form-group">
                <div class="mb-10">
                    <label for="description" class="form-label">@lang('lang.description')</label>
                    <textarea name="description" autocomplete="off" class="form-control form-control-solid" rows="5"
                        placeholder="Description du categorie ...">{{ $category->description ?? '' }}</textarea>
                </div>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light-light btn-sm mr-2 "> @lang('lang.cancel')</button>
            <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  mr-2">
                @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" => trans('lang.sending')])
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {

        $("#category-form").appForm({
            onSuccess: function(response) {
                dataTableInstance.categoryTable.ajax.reload();
            },
        })

    })
</script>
