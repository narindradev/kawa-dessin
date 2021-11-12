<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
    <div class="d-flex flex-column bgi-no-repeat rounded-top"
        style="background-image:url('{{ asset(theme()->getMediaUrlPath() . 'misc/pattern-1.jpg') }}')">
        <h3 class="text-white fw-bold px-9 mt-10 mb-6">
            Notifications
        </h3>
        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
            <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab"
                    href="#topbar_notifications_1">info</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a>
            </li> --}}
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="topbar_notifications_1" role="tabpanel">
            <div class="scroll-y mh-325px my-5 px-8">
                @foreach (auth()->user()->notifications as $notification)
                <div id="notification-item">
                        {!! view('notifications.template', ['notification' => $notification])->render() !!}
                </div>
                @endforeach
            </div>
            <div class="py-3 text-center border-top">
                <a href="{{ theme()->getPageUrl('pages/profile/activity') }}"class="btn btn-color-gray-600 btn-active-color-primary">
                    View All
                    {!! theme()->getSvgIcon('icons/duotune/arrows/arr064.svg', 'svg-icon-5') !!}
                </a>
            </div>
        </div>
       
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".notification-item").on("click", function() {
            var target =  $(this)
            var notificationId =target.attr("data-notification-id")
            var notificationIsUnread = target.attr("data-notification-is-unread")
            if (notificationIsUnread) {
                $.ajax({
                    url: url("/notification/set/seen"),
                    type: 'POST',
                    dataType: 'json',
                    data: {"_token" : _token ,"id" : notificationId},
                    success: function(result) {
                        target.replaceWith(result.data)
                    },
                });
            }

        })
    })
</script>
