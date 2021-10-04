<script>
    function hadleNotification(notification = null) {
        console.log("aaa")
        console.log(dataTableInstance)
        console.log(notification.extra_data)
        console.log(notification.extra_data.type)
        console.log(dataTableInstance[notification.extra_data.table])
        console.log(notification.extra_data.row_id)
        console.log(notification.extra_data.row)


        if (notification.classification == "bell") {
            incrementBell()
        }

        if (typeof notification.extra_data != "undefined" && notification.extra_data.type == "dataTable") {
            console.log("ato")

            var instanceTable = dataTableInstance[notification.extra_data.table];
            var newData = notification.extra_data.row;

            if (typeof notification.extra_data.row_id != "undefined" && $("#" + notification.extra_data.row_id)) {
                var row_id = notification.extra_data.row_id;
                dataTableUpdateRow(instanceTable, row_id, newData);
            } else {
                dataTableaddRowIntheTop(instanceTable, newData)
            }
        }
        console.log(notification);
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
</script>
