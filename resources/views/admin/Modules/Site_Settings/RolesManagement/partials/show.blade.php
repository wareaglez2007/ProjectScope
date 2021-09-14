<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>Group Id</th>
            <th>Group Name</th>
            <th>Role ID</th>
            <th>Role Name</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @if (is_countable($group_info) && count($group_info) > 0)

                @if (count($group_info) > 1)

                    <td scope="row">
                        <ol>
                            @foreach ($group_info as $group)
                                <li>
                                    {{ $group->name }}
                                </li>
                            @endforeach
                        </ol>
                    </td>

                @else
                    @foreach ($group_info as $gp)
                        <td>
                            {{ $gp->id }}
                        </td>
                        <td>
                            {{ $gp->name }}
                        </td>
                    @endforeach
                @endif

            @else
                <td scope="row" class="text-danger"><i class="bi bi-exclamation-circle-fill"></i>&nbsp;Group has NOT
                    been assigned!</td>
                <td scope="row" class="text-danger"><i class="bi bi-exclamation-circle-fill"></i>&nbsp;Group has NOT
                    been assigned!</td>
            @endif
            <td scope="row">{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered table-hover table-striped table-sm" id="show_roles_modules_permissions"
    style="width: 100%">
    <thead>
        <th>Moulde Id</th>
        <th>Module Name</th>
        <th>Permissions</th>
    </thead>
    <tbody>
        @foreach ($modules as $module)

            @if (is_countable($modules_roles) && count($modules_roles))
                @foreach ($modules_roles as $module_assigned)
                    @if ($module_assigned->id == $module->id)
                        <tr>
                            <td>{{ $module->id }}</td>

                            <td>{{ $module->name }}</td>
                            <td>

                                @foreach ($permissions as $permission)
                                    @if (is_countable($roles_permissions) && count($roles_permissions))

                                        @foreach ($roles_permissions as $role_perm)
                                            @if ($role_perm->permissions_id == $permission->id && $role_perm->modules_id == $module_assigned->id)

                                                <button class="btn btn-info btn-sm disabled"
                                                    value="{{ $permission->id }}">{{ $permission->access_type }}</button>

                                            @endif
                                        @endforeach

                                    @endif
                                @endforeach

                            </td>
                        </tr>

                    @endif
                @endforeach
            @else
            @endif
        @endforeach
    </tbody>
</table>
