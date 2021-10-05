$(function () {

    $('#groups_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/groups/getgroups',

        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'roles count' },
            { data: 'updated_at' },
            { data: 'actions' },

        ],
        'columnDefs': [{
            'targets': [4], /* column index  actions column*/
            'orderable': false, /* true or false */
            "render": function (data, type, row) {
                var view_button = '<div style="text-align:center"><div class="btn-group"> <a href="groups/' + row.id + '/show" class="btn btn-info btn-sm">View</a>';
                view_button += ' <a href="groups/' + row.id + '/edit" class="btn btn-secondary btn-sm">Edit</a>';
                view_button += '<form method="post" onsubmit="event.preventDefault();confirm(' + row.id + ');">'
                    + '<input type="hidden" name="uid" value="' + row.id + '"/><input type="hidden" name="_token" value="' + row.token + '"/>'
                    + '<input type="submit" class="btn btn-danger btn-sm" value="Delete" /></form></div></div>';
                return view_button;

            },
        }],


    });








});

function confirm(id) {

    $('#confirmdestroygroup').modal('show');
    $('#do_del').on('click', function (e) {
        e.preventDefault();
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
        url: "/admin/users/"+id+"/destroy",
        method: "post",
        cache: false,
        data: {
            id: id,
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {
                var uid = getRandomInt(100);
                //When the select2 options have been updated, refresh the groups role table view
               // $('#create_new_user_section').html(data.view);

                if (typeof data.response.error != 'undefined') {
                    toastcolor = "#dc3545";
                    toast_message = data.response.error;
                } else {
                    toastcolor = "#04AA6D";
                    toast_message = data.response.success;
                }
                if(data.code == 202){
                    location.reload();
                }

                HandleAjaxResponsesToast(500000, toastcolor, uid, toast_message, 200);
            }
        }, //end of success
        error: function (error) {

            if (typeof error.responseJSON.message != 'undefined') {
                toastcolor = "#dc3545";
                toast_message = error.responseJSON.message;

                //  HandleAjaxResponsesToast(2300, toastcolor, 1, toast_message, 422);

                $.each(error.responseJSON.errors, function (index, val) {
                    HandleAjaxResponsesToast(2300, toastcolor, index, val, error.status);

                });



            }

        } //end of error
    }); //end of ajax
    });

}

