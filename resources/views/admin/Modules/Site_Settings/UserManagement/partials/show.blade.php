{{-- @if ($role_view == 'show_roles_modules') --}}
@if (is_countable($user_roles) && count($user_roles))

    <form action="">
        <input type="hidden" value="{{ $get_mods_count }}" id="mods_count" />
        <table class="table table-bordered table-inverse">
            <thead class="thead-inverse">
                <tr>
                    <th>User</th>
                    <th>Group(s) Belongs to</th>
                    <th>Role</th>
                    <th>Module Assignment</th>
                    <th>Permissions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                @endphp
                @foreach ($user_roles as $assigned_mods)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        @if (is_countable($group_info) && count($group_info) > 0)

                            @if (count($group_info) > 1)

                                <td scope="row">
                                    <ol>
                                        @foreach ($group_info as $group)
                                            <li>
                                                <a
                                                    href="{{ route('admin.groups.show', ['id' => $group->id]) }}">{{ $group->name }}</a>
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            @else
                                @foreach ($group_info as $gp)
                                    <td><a
                                            href="{{ route('admin.groups.show', ['id' => $gp->id]) }}">{{ $gp->name }}</a>
                                    </td>
                                @endforeach
                            @endif

                        @else
                            <td scope="row" class="text-danger"><i
                                    class="bi bi-exclamation-circle-fill"></i>&nbsp;Group has NOT been assigned!</td>
                        @endif

                        {{-- Role Name --}}
                        <td>{{ $role->name }}</td>
                        {{-- Module Name --}}
                        <td> {{ $assigned_mods->name }}</td>
                        <td>
                            <div class="form-group">
                                <label for="">permissions</label>
                                <select multiple class="custom-select module_permissions_select2"
                                    name="permissions_select2" id="permissions_select2_{{ $i }}"
                                    style="width: 75%">
                                    @foreach ($permissions as $permission)
                                        @php
                                            $perm_selected = '';
                                        @endphp
                                        @if (is_countable($roles_permissions) && count($roles_permissions))
                                            @php
                                                foreach ($roles_permissions as $role_perm) {
                                                    if ($role_perm->permissions_id == $permission->id && $role_perm->modules_id == $assigned_mods->id) {
                                                        $perm_selected = 'selected';
                                                    }
                                                }
                                            @endphp
                                        @endif
                                        <option value="{{ $permission->id }}" data-mod-id="{{ $assigned_mods->id }}"
                                            {{ $perm_selected }}>{{ $permission->access_type }}
                                        </option>
                                    @endforeach


                                </select>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>

@else
    <div class="row">
        <p>There are no modules assigned to this role. Select a module for this role.</p>
    </div>
@endif
{{-- @endif --}}
<script>
    $(function() {
        /**
         * SELECT 2
         * ONLY use on specific elements that you want
         */
        $('.module_permissions_select2').select2({
            theme: "classic",
            width: 'resolve',
            placeholder: 'Select all the permissions for this module per role.'

        });
        var mod_count = $('#mods_count').val();
        for (x = 1; x <= mod_count; x++) {
            $('#permissions_select2_' + x).on('select2:select', function(e) {
                var data = e.params.data;
                var mod_id = $(data.element).data('mod-id');
                var role_id = $("#use_for_role_id").val();

                UpdateModuleAccessforRolesSelect2(role_id, mod_id, data.id, "add_permissions");

            });
            $('#permissions_select2_' + x).on('select2:unselect', function(e) {
                var data = e.params.data;
                var mod_id = $(data.element).data('mod-id');
                var role_id = $("#use_for_role_id").val();

                UpdateModuleAccessforRolesSelect2(role_id, mod_id, data.id, "add_permissions");

            });
        }




    });
</script>
