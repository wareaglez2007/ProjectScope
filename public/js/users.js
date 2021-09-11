/**
 * 09-04-2021
 * DOM Ready Section Will go below
 */
$(function () {

    /**
     * This is ajax pagination control for groups
     */
    $(document).on('click', '#users_default_pagination .pagination a', function (event) {
        event.preventDefault();
        // var group_status = $("#group_status").val();
        var page = $(this).attr('href').split('page=')[1];
        var search_q = $('#search_query').val();
        fetch_data(page, search_q);
    });

    //Ajax sort (default order by id ascending)





}); //END of DOM ON READY <<-------------------



function sortListsBy(selector, by, direction, icon_name, switch_icon){
    var search_q = $("#search_users").val();
    var page = $('#current_page_num').val();
    $('#'+selector).find('i').toggleClass(switch_icon, icon_name);
}
// $('#sort-by_id_asc').on('click', function () {




// });
$('#sort-by_name_asc').on('click', function () {
    $(this).find('i').toggleClass('bi bi-sort-alpha-up-alt', 'bi bi-sort-alpha-down');
});
$('#sort-by_email_asc').on('click', function () {
    $(this).find('i').toggleClass('bi bi-sort-alpha-up-alt', 'bi bi-sort-alpha-down');
});
$('#sort-by_role_asc').on('click', function () {
    $(this).find('i').toggleClass('bi bi-sort-alpha-up-alt', 'bi bi-sort-alpha-down');
});
$('#sort-by_cd_asc').on('click', function () {
    $(this).find('i').toggleClass('bi bi-sort-numeric-up-alt', 'bi bi-sort-numeric-down');
});



/**
 * roleearch
 * @Controller index
 * @returns data for: RolesManagement.partials.showroles
 */
function usersearch() {
    var search_q = $("#search_users").val();
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
        url: '/admin/users',
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
                $('#users_data').html(data.view);
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
function fetch_data(page, search, sort_by = null, sort_direction = null) {
    var url = "";
    if (sort_by !== null && sort_direction !== null) {
        url = "/admin/users?page=" + page + "&search_q=" + search + "&sortBy=" + sort_by + "&sortDir=" + sort_direction;
    } else {
        url = "/admin/users?page=" + page + "&search_q=" + search;
    }


    $.ajax({
        url: url,
        success: function (data) {

            $('#users_data').html(data.view); //Must be html not replaceWith
        }
    });
}
