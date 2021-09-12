<div class="row">
    {{-- First show the option for updating the role name --}}
    <div class="col-md-6">
        <form action="">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="role_name" id="role_name" value="{{ $role->name }}"
                    aria-describedby="button-addon2">
                <input type="hidden" name="role_id" id="use_for_role_id" value="{{ $role->id }}" />
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"
                        onclick="event.preventDefault();UpdateRoleName({{ $role->id }});">Update</button>
                </div>
            </div>

    </div>
    {{-- Next we will show role -> module -> permissions --}}
    <div class="col-md-6">

        {{-- Mdoules --}}
        <div class="form-group">
            <label for="">Modules</label>
            <select multiple class="custom-select roles_permissions_select2" name="modules_select2" id="modules_select2"
                style="width: 75%">
                @foreach ($modules as $module)
                    @php
                        $selected = '';
                    @endphp
                    @if (is_countable($modules_roles) && count($modules_roles))
                        @foreach ($modules_roles as $module_assigned)
                            @php

                                if ($module_assigned->id == $module->id) {
                                    $selected = 'selected';
                                }

                            @endphp

                        @endforeach
                    @else
                    @endif
                    <option value="{{ $module->id }}" {{ $selected }}>{{ $module->name }}</option>
                @endforeach


            </select>
        </div>
        </form>
    </div>

</div>


<div id="roles_modules_permission">

    @include('admin.Modules.Site_Settings.RolesManagement.partials.permissions')
</div>







<script>
    $(function() {

        /**
         * SELECT 2
         * ONLY use on specific elements that you want
         */
        $('.roles_permissions_select2').select2({
            theme: "classic",
            width: 'resolve',

        });
        $('#modules_select2').on('select2:select', function(e) {
            var data = e.params.data;
            //var role_id = $(data.element).data('role-id');
            var role_id = $("#use_for_role_id").val();
            console.log(role_id);
            console.log(data.id);
            UpdateModuleAccessforRolesSelect2(role_id, data.id, null, "add_roles_modules_access");


        });
        $('#modules_select2').on('select2:unselect', function(e) {
            var data_to_del = e.params.data;
            //var role_id_to_del = $(data_to_del.element).data('role-id');
            var role_id = $("#use_for_role_id").val();
            console.log(role_id);
            UpdateModuleAccessforRolesSelect2(role_id, data_to_del.id, null,
            "add_roles_modules_access");

        });

    });
</script>
