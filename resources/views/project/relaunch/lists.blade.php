<div  id="timeline-relaunch"  class="scroll-y my-1" 
    data-kt-element="messages" 
    data-kt-scroll="true" 
    data-kt-scroll-activate="true"
    data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer"
    data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" 
    data-kt-scroll-offset="0px" 
    style="height: 660px;">
    {{-- @foreach ($relaunchs as $relaunch)
    
        @if ($relaunch->createdBy->id == auth()->id())
            <div class="d-flex justify-content-end mb-5 mx-2">
                <div class="d-flex flex-column align-items-end">
                    <div class="d-flex align-items-center mb-2">
                        <div class="ms-3">
                            <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-success ms-1">Moi</a>
                        </div>
                    </div>
                    <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">
                        {{ $relaunch->subject->description }}
                    <br>
                        @if ($relaunch->note)
                            <div class="text-muted me-2 fs-7"> <i>{{ $relaunch->note }}</i> </div>
                        @endif
                    </div>
                    <div class="text-muted me-2 fs-7">Ajouter le {{ $relaunch->created_at->format("d-m-Y") }}</div>
                       
                </div>
            </div>
        @else
            <div class="d-flex justify-content-start mb-5">
                <div class="d-flex flex-column align-items-start">
                    <div class="p-5 rounded bg-light-success text-success fw-bold mw-lg-400px text-start" data-kt-element="message-text">
                        {{ $relaunch->subject->description }}
                        <br>
                        @if ($relaunch->note)
                            <div class="text-muted me-2 fs-7"> <i>{{ $relaunch->note }}</i> </div>
                        @endif
                    </div>
                    </div>
                    <div class="d-flex align-items-center mt-1 fs-6">
                        <div class="text-muted me-2 fs-7">Ajouter le {{ $relaunch->created_at->format("d-m-Y") }} par</div>
                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ $relaunch->createdBy->name }}" data-bs-original-title="{{ $relaunch->createdBy->name }}">
                            <img src="{{ $relaunch->createdBy->avatar_url }}" alt="avatar">
                        </div>
                    </div>
                    
                
                </div>
            </div>

        @endif
    @endforeach --}}
    <div class="timeline">
        @foreach ($relaunchs as $relaunch)
          {!! view("project.relaunch.item" ,["relaunch" => $relaunch ,"for_user" =>  auth()->user() ])->render() !!}
        @endforeach
    </div>
</div>
<div class="separator my-5"></div>
<div  id="kt_chat_messenger_footer">
    <form class="form message-chat mt-5" id="form-relaunch" method="POST" action="{{ url("/project/relaunch/add2/$project_id") }}  " enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="input-group">
                <select name="subject" id="subject" data-rule-required="true" data-hide-search="true" 
                    data-msg-required="@lang('lang.required_input')" class="form-select form-select-solid"
                    data-control="select2" data-placeholder="@lang('lang.subject')">
                    <option value="0" disabled selected>-- @lang('lang.subject') --</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ get_array_value($subject, 'value') }}">
                            {{ get_array_value($subject, 'text') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <textarea class="form-control form-control-solid mb-3" name="note"  id="note" rows="3" data-kt-element="input" placeholder="Note ..."></textarea>
        <div class="d-flex flex-stack ">
            <div class="d-flex align-items-center mt-2">
                <input class="form-control form-control-sm form-control-white message-chat-input" name="files[]" type="file" id="relaunch-file-input" multiple>
            </div>
            <button type="submit" id="submit" class=" btn btn-sm btn-light-primary  ">
                @include('partials.general._button-indicator', ['label' => trans('lang.save'),"message" => "..."])
            </button>
        </div>
</form>
</div>

<script>
    $(document).ready(function() {
        KTApp.initSelect2();
        scrollBotton("#timeline-relaunch" , 4000)
        $("#form-relaunch").appForm({
            isModal: false,
            onSuccess: function(response) {
                $(".timeline-item:last").after(response.data)
                $("#subject").val("0") ; $("#note").val(""); $("#relaunch-file-input").val("");
                scrollBotton("#timeline-relaunch" , 4000)
                if (response.project) {
                    dataTableUpdateRow(dataTableInstance.projectsTable, response.row_id, response.project)
                }
            },
        })
    })
</script>