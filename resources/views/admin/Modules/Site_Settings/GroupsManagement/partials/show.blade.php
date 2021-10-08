<div id="do_edit_groups_role">
    {{-- Groups infor section --}}

    @csrf
    <table class="table table-striped table-inverse">
        <thead class="thead-inverse">
            <tr>
                <th>Id</th>
                <th>Group Name</th>
                @if (count($group->groles) == 0)
                <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $group->id }}</td>
                <td>{{ $group->name }}</td>
                @if (count($group->groles) == 0)
                <td class="text-danger">No roles have been assigned to this group!</td>
                @endif
            </tr>
        </tbody>
    </table>

    {{-- Show roles at this section --}}
    @if (is_countable($roles) && count($roles) > 0)
        <table class="table table-bordered table-striped table-sm" id="show_groups_table_roles" style="width: 100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Role Name</th>
                    <th>Updated At</th>
                    <th>is_selected</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->updated_at }}</td>
                        <td>
                            @if (is_countable($group->groles) && count($group->groles) > 0)
                                @foreach ($group->groles as $rga)
                                    @php
                                        $selected = 0;

                                        if ($role->id == $rga->id) {
                                            $selected = 1;
                                        } else {
                                            $selected = null;
                                        }
                                        echo $selected;
                                    @endphp
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data is available!</p>
    @endif

    @if (is_countable($group->groles) && count($group->groles) > 0)


        @foreach ($group->groles as $gr)


            <input type="hidden" value="{{ $gr->id }}" id="get_role_id_{{ $gr->id }}" />


        @endforeach



    @endif

    <script>
        $(function() {

            var rolesTable = $('#show_groups_table_roles').DataTable({
                processing: false,
                serverSide: false,
                select: false,

                order: [
                    [3, 'desc']
                ], // sort the default to selected rows
                columnDefs: [{
                        targets: [3], //Hides the column
                        visible: false,
                        searchable: false,
                        //orderData: [3,1]
                    },

                ],



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
</div>
