/**
 * 09-04-2021
 * DOM Ready Section Will go below
 */
$(function () {

    /**
     * This is ajax pagination control for groups
     */
    $(document).on('click', '#roles_default_pagination .pagination a', function (event) {
        event.preventDefault();
        // var group_status = $("#group_status").val();
        var page = $(this).attr('href').split('page=')[1];

        fetch_data(page, 1);
    });




}); //END of DOM ON READY <<-------------------


/**
 * roleearch
 * @Controller index
 * @returns data for: RolesManagement.partials.showroles
 */
function rolesearch() {
    var search_q = $("#search_roles").val();
    //var group_status = $("#group_status").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/roles',
        method: "get",
        //cache: false,
        data: {
            search_q: search_q,
            //   status : group_status

        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                $('#roles_data').html(data.view);
            }
        }, //end of success
        error: function (error) {
            console.log(error);
            if (typeof error.responseJSON.message != 'undefined') {
                toastcolor = "#dc3545";
                toast_message = error.responseJSON.message;

                //HandleAjaxResponsesToast(1050, toastcolor, mess_count, toast_message, 422);

                $.each(error.responseJSON.errors, function (index, val) {
                    HandleAjaxResponsesToast(2300, toastcolor, index, val, error.status);

                });
            }

        } //end of error
    }); //end of ajax
}


/**
 * {Groups}
 * @param int page
 * @controller GroupsAjaxPaginationdata
 * @returns Blade view: RolesManagement.partials.showroles
 */
function fetch_data(page, status) {
    var url = "";

    url = "/admin/roles?page=" + page + "&status=" + status;

    $.ajax({
        url: url,
        success: function (data) {
            $('#roles_data').html(data.view); //Must be html not replaceWith
        }
    });
}


/**
 * 09-01-2021
 * @param Int role_id
 * @param Int group_id
 * @Controller updatewithSelect2
 * @returns Blade view: GroupsManagement.partials.rolesgroupspagination
 */
function UpdateModuleAccessforRolesSelect2(role_id, module_id, permission_id, flag) {

    //var current_page = $("#roles_groups_current_page").val();
    //Submit form
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: "/admin/roles/store",
        method: "get",
        //cache: false,
        data: {
            role_id: role_id,
            module_id: module_id,
            permission_id: permission_id,
            flag: flag
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                if (typeof data.add_remove_flag) {

                    //When the select2 options have been updated, refresh the groups role table view
                    $('#roles_modules_permission').html(data.view);
                }


                if (typeof data.response.error != 'undefined') {
                    toastcolor = "#dc3545";
                    toast_message = data.response.error;
                } else {
                    toastcolor = "#04AA6D";
                    toast_message = data.response.success;
                }

                HandleAjaxResponsesToast(850, toastcolor, role_id, toast_message, 200);
            }
        }, //end of success
        error: function (error) {
            console.log(error);
            if (typeof error.responseJSON.message != 'undefined') {


            }

        } //end of error
    }); //end of ajax






}

