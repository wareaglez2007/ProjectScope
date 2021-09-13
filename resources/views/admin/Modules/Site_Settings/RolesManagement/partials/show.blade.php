<div>
    @if (is_countable($roles) && count($roles) > 0)
        <table class="table table-bordered table-striped table-hover table-sm" id="roles_table"  style="width: 100%">
            <thead>
                <tr>
                    <th>Role Id</th>
                    <th>Role Name</th>
                    <th>Created On</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)


                    @php
                        $attention = '';
                        $disable = '';
                        if (is_countable($group_info) && count($group_info) > 0) {
                            foreach ($group_info as $gp_info) {
                                if ($gp_info->id == $role->id) {
                                    if (is_countable($gp_info->GetGroups) && count($gp_info->GetGroups)) {
                                        //    dump($gp_info->GetGroups);
                                    } else {
                                        $disable = "disabled";
                                        $attention = '<i class="bi bi-exclamation-circle-fill text-danger" data-toggle="tooltip" data-placement="right" title="Attention! No Group has been assigned to this role."></i>';
                                    }
                                }
                            }
                        }
                    @endphp

                    <tr>
                        <td scope="row">
                            <a href="{{ route('admin.roles.edit', ['id' => $role->id]) }}"
                            class="text-muted" aria-disabled="true" >{{ $role->id }}</a></td>
                        <td><a href="{{ route('admin.roles.edit', ['id' => $role->id]) }}" class="text-muted" aria-disabled="true" >
                                {{ $role->name }}</a> &nbsp;{!! $attention !!}&nbsp;
                        </td>
                        <td><a href="{{ route('admin.roles.edit', ['id' => $role->id]) }}"
                            class="text-muted" aria-disabled="true" >{{ $role->created_at }}</a></td>
                        <td style="text-align:center">
                            {{-- <div class="btn-group" role="group" aria-label="Basic example"> --}}
                                <a href="{{ route('admin.roles.show', ['id' => $role->id]) }}" type="button" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.roles.edit', ['id' => $role->id]) }}" type="button" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="" type="button" class="btn btn-danger btn-sm">Delete</a>
                              {{-- </div> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <p>0 results were found!</p>
    @endif
</div>
<script>
    /** Bootstrap popover 09-08-2021 */
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
