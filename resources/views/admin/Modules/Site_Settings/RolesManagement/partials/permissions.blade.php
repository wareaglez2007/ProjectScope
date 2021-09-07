{{-- @if ($role_view == 'show_roles_modules') --}}
@if (is_countable($modules_roles) && count($modules_roles))
    <input type="hidden" value="{{ $get_mods_count }}" id="mods_count" />
    @php
        $i = 0;
    @endphp
    @foreach ($modules_roles as $assigned_mods)
        @php
            $i++;
        @endphp
        <div class="card" style="margin-top: 15px">
            <div class="card-body">
                <div class="row">

                    {{-- Module Name --}}
                    <div class="col-md-4">
                        {{ $assigned_mods->name }}
                    </div>

                    <div class="col-md-4">
                        {{-- Permissions --}}
                        <form action="">

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
                        </form>
                    </div>
                </div>
            </div>
        </div>


    @endforeach
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
