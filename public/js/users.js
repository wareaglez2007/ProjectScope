/**
 * 09-04-2021
 * DOM Ready Section Will go below
 */
$(function () {



    $('.users_roles_select2').select2({
        theme: "classic",
        width: 'resolve',
        placeholder: 'Select all roles for this new user!'

    });

    $('#role_select2').on('select2:select', function (e) {

        var data = e.params.data;

        //UpdateModuleAccessforRolesSelect2(role_id, data.id, null, "add_roles_modules_access");


    });


}); //END of DOM ON READY <<-------------------



$('#create_new_user').on('click', function (e) {
    e.preventDefault();
    var roles = $('#role_select2').val();
    var string_roles = JSON.stringify(roles);
    var full_name = $("#user_name").val();
    var email = $("#user_email").val();
    var pass = $("#user_pass").val();
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
        url: "/admin/users/store",
        method: "get",
        //cache: false,
        data: {
            roles: string_roles,
            name: full_name,
            email: email,
            pass: pass
        },
        success: function (data) {
            var toastcolor = "";
            var toast_message = "";
            if (typeof data != 'undefined') {

                var uid = getRandomInt(100);
                //When the select2 options have been updated, refresh the groups role table view
                $('#create_new_user_section').html(data.view);

                if (typeof data.response.error != 'undefined') {
                    toastcolor = "#dc3545";
                    toast_message = data.response.error;
                } else {
                    toastcolor = "#04AA6D";
                    toast_message = data.response.success;
                }

                HandleAjaxResponsesToast(2300, toastcolor, uid, toast_message, 200);
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
})

