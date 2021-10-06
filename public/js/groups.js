/**
 * These scripts are for Groups Mods
 */


/**
 * 09-01-2021
 * DOM Ready Section Will go below
 */
$(function () {







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
                    $("#ajax_message").text('');
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
function fetch_data(page, status) {
    console.log(status);
    var url = "";

    url = "/admin/groups/groupspagination?page=" + page + "&status=" + status;

    $.ajax({
        url: url,
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
    var group_status = $("#group_status").val();
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
            status: group_status

        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                $('#groups_data').html(data.view);
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

/**
 *
 * @param int group_id
 * @controller updateGroupName
 * @returns Blade view: GroupsManagement.partials.rolesgroupspagination
 */
function UpdateGroupName(group_id) {
    var current_page = $("#roles_groups_current_page").val();
    var group_name = $("#g_name").val();
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
        url: '/admin/groups/show/' + group_id + '/updategroup?page=' + current_page,
        method: "get",
        //cache: false,
        data: {
            group_id: group_id,
            name: group_name
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                var current_page = $("#roles_groups_current_page").val();
                $('#group_roles_data').html(data.view); //<< !!Attention: it returns the select2 see function details at top!!

                if (typeof data.response.error != 'undefined') {
                    toastcolor = "#dc3545";
                    toast_message = data.response.error;
                } else {
                    toastcolor = "#04AA6D";
                    toast_message = data.response.success;
                }
                HandleAjaxResponsesToast(850, toastcolor, group_id, toast_message, 200);
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
 * @controller store
 * @returns Blade view:GroupsManagement.partials.create
 */
function CreateNewGroup() {
    var group_name = $("#group_name").val();
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
        url: '/admin/groups/store',
        method: "post",
        //cache: false,
        data: {
            name: group_name
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                $('#create_group_div').html(data.view); //<< !!Attention: it returns the select2 see function details at top!!

                if (typeof data.response.error != 'undefined') {
                    toastcolor = "#dc3545";
                    toast_message = data.response.error;
                } else {
                    toastcolor = "#04AA6D";
                    toast_message = data.response.success;
                }
                HandleAjaxResponsesToast(1050, toastcolor, 1, toast_message, 200);
            }
        }, //end of success
        error: function (error) {

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
 * 09-02-2021
 * @param int group_id
 * @controller destroy
 * @returns Blade view: GroupsManagement.partials.groupspagination
 */
function DestoryGroup(group_id) {
    var current_page = $("#groups_current_page").val();
    var groups_per_page = $('#groups_per_page_count').val();
    var groups_last_page = $("#groups_last_page").val();
    var group_status = $("#group_status").val();
    if ((current_page == groups_last_page) && groups_per_page == 1) {
        current_page = 1; //end of the line
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/groups/destroy?page=' + current_page + "&status=" + group_status,
        method: "post",
        //cache: false,
        data: {
            id: group_id
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                $('#groups_data').html(data.view);

                if (typeof data.response.error != 'undefined') {
                    toastcolor = "#dc3545";
                    toast_message = data.response.error;
                } else {
                    toastcolor = "#04AA6D";
                    toast_message = data.response.success;
                }
                HandleAjaxResponsesToast(1050, toastcolor, 1, toast_message, 200);
            }
        }, //end of success
        error: function (error) {

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
 * 09-02-2021
 * @param int group_id
 * @controller delete
 * @returns Blade view: GroupsManagement.partials.groupspagination
 */
function DeleteGroup(group_id) {
    var current_page = $("#groups_current_page").val();
    var groups_per_page = $('#groups_per_page_count').val();
    var groups_last_page = $("#groups_last_page").val();
    var group_status = $("#group_status").val();
    if ((current_page == groups_last_page) && groups_per_page == 1) {
        current_page = 1; //end of the line
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/groups/delete?page=' + current_page + "&status=" + group_status,
        method: "post",
        //cache: false,
        data: {
            id: group_id
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                $('#groups_data').html(data.view);

                if (typeof data.response.error != 'undefined') {
                    toastcolor = "#dc3545";
                    toast_message = data.response.error;
                } else {
                    toastcolor = "#04AA6D";
                    toast_message = data.response.success;
                }
                HandleAjaxResponsesToast(1050, toastcolor, 1, toast_message, 200);
            }
        }, //end of success
        error: function (error) {

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
 * 09-02-2021
 * @param int group_id
 * @controller activate
 * @returns Blade view: GroupsManagement.partials.groupspagination
 */
function ActivateGroup(group_id) {
    var current_page = $("#groups_current_page").val();
    var groups_per_page = $('#groups_per_page_count').val();
    var groups_last_page = $("#groups_last_page").val();
    var group_status = $("#group_status").val();
    if ((current_page == groups_last_page) && groups_per_page == 1) {
        current_page = 1; //end of the line
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/groups/activate?page=' + current_page + "&status=" + group_status,
        method: "post",
        //cache: false,
        data: {
            id: group_id
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                $('#groups_data').html(data.view);

                if (typeof data.response.error != 'undefined') {
                    toastcolor = "#dc3545";
                    toast_message = data.response.error;
                } else {
                    toastcolor = "#04AA6D";
                    toast_message = data.response.success;
                }
                HandleAjaxResponsesToast(1050, toastcolor, 1, toast_message, 200);
            }
        }, //end of success
        error: function (error) {

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
 * This function submits data to update the groups and roles table
 * 10-04-2021
 */
function updategroup(group_id) {

    var gname = $("#gp_name").val();
    var select_data = $('#groups_table_roles').DataTable();
    var selected_role_ids = $.map(select_data.rows('.selected').data(), function (item) {
        return item[0]
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $(
                'meta[name="csrf-token"]')
                .attr(
                    'content')
        }

    }); //End of ajax setup
    $.ajax({
        url: '/admin/groups/' + group_id + '/update',
        method: "post",
        cache: false,
        data: {
            id: group_id,
            roles_id: selected_role_ids,
            name: gname
        },
        success: function (data) {
            if (typeof data.response.error != 'undefined') {
                var toast_message = '<ul>';
                var uid = getRandomInt(100);
                $.each(data.response.error, function (err_index, error_val) {
                    toastcolor = "#dc3545";
                    toast_message += '<li >' + error_val + '</li>';
                });
                toast_message += '</ul>';
                HandleAjaxResponsesToast(2500, toastcolor, uid, toast_message, 200);
            }
            if (typeof data.response.success != 'undefined') {
                var toast_message = '<ul>';
                var uid = getRandomInt(100);
                $.each(data.response.success, function (succ_index, success_val) {
                    toastcolor = "#04AA6D";
                    toast_message += '<li>' + success_val + '</li>';
                });
                toast_message += '</ul>';
                HandleAjaxResponsesToast(2500, toastcolor, uid, toast_message, 200);

            }
            //Warnings
            if (typeof data.response.warning != 'undefined') {
                var toast_message = '<ul>';
                var uid = getRandomInt(100);
                $.each(data.response.warning, function (err_index, error_val) {
                    toastcolor = "#ffc107";
                    toast_message += '<li >' + error_val + '</li>';
                });
                toast_message += '</ul>';
                HandleAjaxResponsesToast(2500, toastcolor, uid, toast_message, 200);
            }
            $('#do_edit_groups_role').html(data.view);

        }, //end of success
        error: function (error) {

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
// $('#do_update_gr').on('submit', function (e) {
//     console.log('click');
//     var group_id = $("#gp_id").val();
//     var gname = $("#gp_name").val();
//     e.preventDefault();
//     var select_data = $('#groups_table_roles').DataTable();
//     var selected_role_ids = $.map(select_data.rows('.selected').data(), function (item) {
//         return item[0]
//     });

//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $(
//                 'meta[name="csrf-token"]')
//                 .attr(
//                     'content')
//         }

//     }); //End of ajax setup
//     $.ajax({
//         url: '/admin/groups/' + group_id + '/update',
//         method: "post",
//         //cache: false,
//         data: {
//             id: group_id,
//             roles_id: selected_role_ids,
//             name: gname
//         },
//         success: function (data) {
//             var toastcolor = "";
//             var toast_message = "";
//             if (typeof data != 'undefined') {
//                 $('#do_update_gr').html(data.view);

//                 if (typeof data.response.error != 'undefined') {
//                     toastcolor = "#dc3545";
//                     toast_message = data.response.error;
//                 } else {
//                     toastcolor = "#04AA6D";
//                     toast_message = data.response.success;
//                 }
//                 HandleAjaxResponsesToast(1050, toastcolor, 1, toast_message, 200);
//             }
//         }, //end of success
//         error: function (error) {

//             if (typeof error.responseJSON.message != 'undefined') {
//                 toastcolor = "#dc3545";
//                 toast_message = error.responseJSON.message;

//                 //HandleAjaxResponsesToast(1050, toastcolor, mess_count, toast_message, 422);

//                 $.each(error.responseJSON.errors, function (index, val) {
//                     HandleAjaxResponsesToast(2300, toastcolor, index, val, error.status);

//                 });
//             }

//         } //end of error
//     }); //end of ajax



//     //console.log(dataArr);

// });
