<button type="button" id="trigger-ajax-modal" data-bs-toggle="modal" data-bs-target="#ajax-modal"
    style="display: none"></button>
<div class="modal fade" tabindex="-1" id="ajax-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajax-modal-title"></h4>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span class="svg-icon svg-icon-2x">x</span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" id="ajax-modal-callback" style="display: none">
               
            </div>
            <div class="modal-body modal-body-content" id="ajax-modal-content">
                
            </div>
            <div id='ajax-modal-original-content' class='center-align'>
                <div class="original-modal-body ">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
