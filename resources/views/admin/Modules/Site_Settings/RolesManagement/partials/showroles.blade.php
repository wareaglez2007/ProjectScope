<div>
    @if (is_countable($roles) && count($roles) > 0)
        <table class="table table-bordered table-hover">
            <thead class="thead-inverse">
                <tr>
                    <th>Role Id</th>
                    <th>Role Name</th>
                    <th>Created On</th>
                    <th>Actions</th>
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
                                        $attention = '<i class="bi bi-exclamation-circle-fill text-danger h5" data-toggle="tooltip" data-placement="right" title="Attention! No Group has been assigned to this role."></i>';
                                    }
                                }
                            }
                        }
                    @endphp

                    <tr>
                        <td scope="row"><a href="{{ route('admin.roles.show', ['id' => $role->id]) }}"
                            class="btn btn-link {{ $disable }}" aria-disabled="true" >{{ $role->id }}</a></td>
                        <td><a href="{{ route('admin.roles.show', ['id' => $role->id]) }}" class="btn btn-link {{ $disable }}" aria-disabled="true" >
                                {{ $role->name }}</a> &nbsp;{!! $attention !!}&nbsp;
                        </td>
                        <td><a href="{{ route('admin.roles.show', ['id' => $role->id]) }}"
                            class="btn btn-link {{ $disable }}" aria-disabled="true" >{{ $role->created_at }}</a></td>
                        <td>
                            <div class="dropdown open">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-gear-wide"></i>&nbsp;
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item"
                                        href="{{ route('admin.roles.show', ['id' => $role->id]) }}">Edit</a>
                                    <a class="dropdown-item disabled" href="{{ route('admin.roles') }}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="roles_default_pagination">
            {{ $roles->links() }}
        </div>
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
