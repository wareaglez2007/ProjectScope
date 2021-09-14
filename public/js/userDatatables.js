$(function () {
    $('#users_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": '/admin/users/getusers',
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'created_at' },
            { data: 'actions' }
        ],
        'columnDefs': [{
            'targets': [4], /* column index  actions column*/
            'orderable': false, /* true or false */
            "render": function (data, type, row) {
                var view_button = '<div style="text-align:center"> <a href="users/show/' + data + '" class="btn btn-info btn-sm">View</a>';
                view_button += ' <a href="users/edit/' + data + '" class="btn btn-secondary btn-sm">Edit</a>';
                view_button += ' <a href="users/destroy/' + data + '" class="btn btn-danger btn-sm">Delete</a></div>';
                return view_button;
            },
        }],


    });
});
