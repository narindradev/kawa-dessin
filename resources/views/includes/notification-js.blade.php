<script>
    // initilisation file location assets/demo1/scripts.js

    function hadleNotification(notification = null) {
        console.log(notification)
        if (notification.classification == "bell") {
            incrementBell()
        }
        if (typeof notification.extra_data != "undefined" && notification.extra_data.type == "dataTable") {
            var instanceTable = dataTableInstance[notification.extra_data.table];
            console.log(notification.extra_data.table)
            console.log(instanceTable)
            if (!instanceTable) {
                console.log("bla");
                return false;
            }
            var newData = notification.extra_data.row;
            if (typeof notification.extra_data.row_id != "undefined" && $("#" + notification.extra_data.row_id)) {
                var row_id = notification.extra_data.row_id;
                dataTableUpdateRow(instanceTable, row_id, newData);
            } else {
                dataTableaddRowIntheTop(instanceTable, newData)
            }
        }
    }
    function incrementBell() {
        var notificationCount = $("#notifications-count").text();
        notificationCount = parseInt(notificationCount)
        if (notificationCount) {
            notificationCount = parseInt(notificationCount) + 1
        } else {
            notificationCount = 1
        }
        if (!$("#pulse-notification").hasClass("pulse-ring")) {
            $("#pulse-notification").addClass("pulse-ring")
        }
        $("#notifications-count").text(notificationCount)
    }

    $("#bell-icon").on("click", function() {
        if ($("#pulse-notification").hasClass("pulse-ring")) {
            $("#pulse-notification").addClass("pulse-ring")
        }
        $("#pulse-notification").removeClass("pulse-ring")
        $("#notifications-count").text("0")
    })
</script>
