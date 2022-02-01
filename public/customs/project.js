
    $(document).on("click" ,".project-status",function(){
        var project_id  = $(this).attr("data-project_id")
        var new_project_status  = $(this).attr("data-status")
        // var project_status  = $(this).attr("data-project-status")
        $.ajax({
            url: url("/project/set_status/" + project_id),
            type: 'POST',
            data: {
                "new_project_status" :  new_project_status,
                "_token" : _token
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message)
                    return dataTableInstance.projectsTable.ajax.reload(); 
                    // dataTableUpdateRow(dataTableInstance.projectsTable,response.row_id,response.data ,true);
                }
            },
            error: function () {
            }
        });
    })