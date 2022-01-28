<script>
    // initilisation file location assets/demo1/scripts.js
    function hadleNotification(notification = null) {
        console.log(notification)
        
        if (notification.classification === "bell") {
            incrementBell()
            addItemNotification(notification)
        }
        if (notification.classification === "chat") {
            if ($("#chat-form-" + notification.form + "-id-" + notification.target).length) {
                if (notification.need_load_more) {
                    load_more(notification.message_id)
                } else {
                    addItemMessage(notification)
                }
                return false; // Dont add notification in dataTable row;
            } else {
                if (notification.form === "private") {
                    incrementChatPrivate(notification)
                    if (typeof notification.toast != "undefined") {
                        pushPopNotification(notification.toast)
                    }
                    return false;
                }
                if (notification.form === "project") {
                    if (typeof notification.toast != "undefined") {
                        pushPopNotification(notification.toast)
                    }
                }
            }
        }
        /** Notififcation not a chat*/ 
        pushPopNotification(notification.toast)
        if (typeof notification.extra_data != "undefined" && notification.extra_data.type == "dataTable") {
            updateTableInstance(notification);
        }
    }
    function pushPopNotification(message) {
        toastr.options.closeButton = true; 
        toastr.options.closeDuration = 6000;
        toastr.info(message.content, message.title);
        // toastr.info(" Un nouveau message  <a href='#' class='new-item-message-detected' data-message-id = " + notification.message_id + "> <u> Voir</u><a>");
    }
    function incrementBell() {
        var notificationCount = $("#notifications-count").text();
        notificationCount = parseInt(notificationCount)
        if (notificationCount) {
            notificationCount ++;
        } else {
            notificationCount = 1
        }
        $("#notifications-count").text(notificationCount)
        if (!$("#pulse-notification").hasClass("pulse-ring")) {
            $("#pulse-notification").addClass("pulse-ring")
        }
    }

    function incrementChatPrivate(notification) {
        var target = $("#chat-private-id-notfication-count-" + notification.target)
        target.css("display", "")
        console.log($("#chat-private-id-notfication-count-" + notification.target).length);
        var count = target.text();
        count = parseInt(count)
        if (count) {
            count++;
        } else {
            count = 1
        }
        target.text(count)
    }

    function addItemNotification(notification = null) {
        if ($(".notification-item").length) {
            $(".notification-item:last").prepend(notification.item)
        } else {
            $("#notification-item").html(notification.item)
        }
    }

    function addItemMessage(notification = null, ) {
      
        if ($("#message-item-" + notification.message_id).length) {
            $("#message-item-" + notification.message_id).replaceWith(notification.message)
            return false;
        }
        if ($(".message-item").length) {
            $(".message-item:last").after(notification.message)
        } else {
            $("#messages-list").html(notification.message)
        }
    }

    function updateTableInstance(notification) {
        var instanceTable = dataTableInstance[notification.extra_data.table];
        if (!instanceTable) {
            return false;
        }
        var newData = notification.extra_data.row;
        if (typeof notification.extra_data.row_id != "undefined" && $("#" + notification.extra_data.row_id)) {
            var row_id = notification.extra_data.row_id;
            if ($("#" + row_id).length) {
                dataTableUpdateRow(instanceTable, row_id, newData, true);
            } else {
                dataTableaddRowIntheTop(instanceTable, newData, true)
            }
        } else {
            dataTableaddRowIntheTop(instanceTable, newData, true)
        }
    }

    function load_more(message_id = 0) {
        $.ajax({
            url: url("/message/get_message"),
            type: 'POST',
            dataType: 'json',
            data: {
                id: message_id,
                _token: _token
            },
            success: function(result) {
                addItemMessage(result)
            },
        });
    }
    $("#bell-icon").on("click", function() {
        if ($("#pulse-notification").hasClass("pulse-ring")) {
            $("#pulse-notification").removeClass("pulse-ring")
        }
        $("#notifications-count").text("0")
    })
    $(document).on("click", '.new-item-message-detected', function() {
        var id = $(this).attr("data-message-id");
        $('#messages-list').animate({
            scrollTop: $("#message-item-" + id).offset().top
        }, 2000);
    })
</script>
