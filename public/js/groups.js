/**
 *
 * @param int role_id
 * @param int group_id
 */

// $(function () {
//     $('input[type=checkbox]').on('change', function () {

//         if (this.checked) {
//             var role_id = $("#roles_for_groups input[type=checkbox]:checked").val();
//             var group_id = $('#use_for_group_id').val();
//             console.log(role_id);
//             //Submit form
//             $.ajaxSetup({
//                 headers: {
//                     'X-CSRF-TOKEN': $(
//                         'meta[name="csrf-token"]')
//                         .attr(
//                             'content')
//                 }

//             }); //End of ajax setup
//             $.ajax({
//                 url: '/admin/groups/update',
//                 method: "get",
//                 //cache: false,
//                 data: {
//                     role_id: role_id,
//                     group_id: group_id
//                 },
//                 success: function (data) {
//                     console.log(data.response.success);
//                     if (typeof data != 'undefined') {

//                         $('#group_roles_data').html(data.view);
//                         $('#ajax_message').text(data.response.success);
//                     }
//                 }, //end of success
//                 error: function (error) {
//                     console.log(error);
//                     if (typeof error.responseJSON.message != 'undefined') {


//                     }

//                 } //end of error
//             }); //end of ajax
//         }
//     });
// });

function UpdateGroupsRoles(role_id,group_id) {
   // var role_id = new Array();
   // $("#roles_for_groups input[type=checkbox]:checked").each(function () {
   //     role_id.push(this.value);
  //  });

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
        url: '/admin/groups/update',
        method: "get",
        //cache: false,
        data: {
            role_id: role_id,
            group_id: group_id
        },
        success: function (data) {
           // console.log(data.response.success);
            if (typeof data != 'undefined') {
                var page = $("#groups_roles_show_pagination .pagination a").attr('href').split('page=')[1];
                //console.log(page);
                fetch_data(page+1);
                //$('#group_roles_data').html(data.view);
                $('#ajax_messsage_updates').attr('class' , 'text-success');
                $('#ajax_messsage_updates').text(data.response.success);
            }
        }, //end of success
        error: function (error) {
            console.log(error);
            if (typeof error.responseJSON.message != 'undefined') {


            }

        } //end of error
    }); //end of ajax
}




function fetch_data(page) {
    $.ajax({
        url: "/admin/groups/groupspagination?page=" + page,
        success: function (data) {
            $('#groups_data').html(data); //Must be html not replaceWith
        }
    });
}





/**
 * This is ajax pagination control for groups
 */
$(function () {

    $(document).on('click', '#groups_default_pagination .pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    function fetch_data(page) {
        $.ajax({
            url: "/admin/groups/groupspagination?page=" + page,
            success: function (data) {
                $('#groups_data').html(data); //Must be html not replaceWith
            }
        });
    }

});
/**
 * This is ajax pagination control for roles in the groups section
 */
$(function () {

    $(document).on('click', '#groups_roles_show_pagination .pagination a', function (event) {
        event.preventDefault();
        var gp_id = $("#use_for_group_id").val();
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page, gp_id);
    });

    function fetch_data(page, id) {
        $.ajax({
            url: "/admin/groups/show/" + id + "/groupsrolespagination?page=" + page,
            success: function (data) {
                $('#group_roles_data').html(data); //Must be html not replaceWith
            }
        });
    }

});
