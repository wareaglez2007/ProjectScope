/**
 * These scripts are for Groups Mods
 */

/**
 * 09-01-2021
 * DOM Ready Section Will go below
 */
$(function () {

    /**
     * This is ajax pagination control for groups
     */
    $(document).on('click', '#groups_default_pagination .pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });


    /**
     * This is ajax pagination control for roles in the groups section
     */
    $(document).on('click', '#groups_roles_show_pagination .pagination a', function (event) {
        event.preventDefault();
        var gp_id = $("#use_for_group_id").val();
        var page = $(this).attr('href').split('page=')[1];
        fetch_role_data(page, gp_id);
    });


}); //END of DOM ON READY <<-------------------

/**
 * @controller update
 * @param {*} role_id
 * @param {*} group_id
 * @returns Blade view GroupsManagement.partials.rolegroupselection
 * (it refreshes the Select2 option group)
 */
function UpdateGroupsRoles(role_id, group_id) {
    var current_page = $("#roles_groups_current_page").val();
    console.log(role_id);
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
        url: '/admin/groups/update?page=' + current_page,
        method: "get",
        //cache: false,
        data: {
            role_id: role_id,
            group_id: group_id
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                var current_page = $("#roles_groups_current_page").val();
                $('#roles_groups_select2_index').html(data.view); //<< !!Attention: it returns the select2 see function details at top!!

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

/**
 * {Groups}
 * @param int page
 * @controller GroupsAjaxPaginationdata
 * @returns Blade view: GroupsManagement.partials.groupspagination
 */
function fetch_data(page) {
    $.ajax({
        url: "/admin/groups/groupspagination?page=" + page,
        success: function (data) {
            $('#groups_data').html(data); //Must be html not replaceWith
        }
    });
}
/**
 * {Roles}
 * @param int page
 * @param int id
 * @controller GroupsRolesAjaxPaginationdata
 * @returns Blade view: GroupsManagement.partials.rolesgroupspagination
 */
function fetch_role_data(page, id) {
    $.ajax({
        url: "/admin/groups/show/" + id + "/groupsrolespagination?page=" + page,
        success: function (data) {
            $('#group_roles_data').html(data); //Must be html not replaceWith
        }
    });
}

/**
 * GroupSearch
 * @Controller Search
 * @returns data for: GroupsManagement.partials.groupspagination
 */
function groupsearch() {
    var search_q = $("#search_groups").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/groups/search',
        method: "post",
        //cache: false,
        data: {
            search_q: search_q,

        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                $('#groups_data').html(data);
            }
        }, //end of success
        error: function (error) {
            console.log(error);
            if (typeof error.responseJSON.message != 'undefined') {
            }

        } //end of error
    }); //end of ajax
}

/**
 * 09-01-2021
 * @param Int role_id
 * @param Int group_id
 * @Controller updatewithSelect2
 * @returns Blade view: GroupsManagement.partials.rolesgroupspagination
 */
function UpdateRolesforGroupsSelect2(role_id, group_id) {

    var current_page = $("#roles_groups_current_page").val();
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
        url: "/admin/groups/show/" + group_id + "/rolesupdate?page=" + current_page,
        method: "get",
        //cache: false,
        data: {
            role_id: role_id,
            group_id: group_id
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                //When the select2 options have been updated, refresh the groups role table view
                $('#group_roles_data').html(data.view);

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





