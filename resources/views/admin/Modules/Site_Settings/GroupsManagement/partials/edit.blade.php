{{-- Groups infor section --}}
<form id="do_update_gr" method="post" action="{{ route('admin.groups.update', ['id' => $group->id]) }}">
    @csrf
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse">
            <tr>
                <th>Id</th>
                <th>Group Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $group->id }}</td>
                <td><input type="text" class="form-control" value="{{ $group->name }}" name="name" id="gp_name" />
                </td>
                <td>
                    <input type="hidden" value="{{ $group->id }}" name="gp_id" id="gp_id" />
                    <input type="submit" value="Update" class="btn btn-primary" id="update_group_roles" onclick="event.preventDefault();updategroup({{ $group->id }});"/>
                </td>
            </tr>
        </tbody>
    </table>
    {{-- @dump($group->groles); --}}

    {{-- Show roles at this section --}}
    <table class="table table-bordered table-striped table-hover table-sm" id="groups_table_roles" style="width: 100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Role Name</th>
                <th>Updated At</th>

            </tr>
        </thead>
        <tbody>
            @if (is_countable($roles) && count($roles) > 0)

                @foreach ($roles as $role)

                    <tr class="{{ $selected }}">
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->updated_at }}</td>
                    </tr>

                @endforeach

            @else

            @endif
        </tbody>
    </table>

</form>

@if (is_countable($group->groles) && count($group->groles) > 0)


    @foreach ($group->groles as $gr)


        <input type="hidden" value="{{ $gr->id }}" id="get_role_id_{{ $gr->id }}" />


    @endforeach



@endif
<script>
    $(function() {

        var rolesTable = $('#groups_table_roles').DataTable({
            processing: true,
            serverSide: false,
            select: {
                style: 'multi'
            },
        });
        //Preselected the rows that have already been assigned to the group
        //10-04-2021
        //Help from: https://stackoverflow.com/questions/40664339/how-do-i-pre-select-rows-in-a-datatable-based-on-the-value-in-a-column
        $.each(rolesTable.rows().data(), function(index, value) {
            var row_ids = $("#get_role_id_" + value[0]).val();
            if (value[0] == row_ids) {
                rolesTable.rows(':eq(' + index + ')').select();
            }
        });





    }); //END of DOM ON READY <<-------------------
</script>
