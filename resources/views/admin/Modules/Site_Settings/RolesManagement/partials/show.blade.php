<div class="row">
    {{-- First show the option for updating the role name --}}
    <div class="col-md-4">
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
        </form>
    </div>
    {{-- Next we will show role -> module -> permissions --}}
    <div class="col-md-4">
        <form action="">
            {{-- Mdoules --}}
            <div class="form-group">
                <label for="">Modules</label>
                <select multiple class="custom-select roles_permissions_select2" name="modules_select2" id="modules_select2"
                    style="width: 75%">
                    @foreach ($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                    @endforeach


                </select>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        {{-- Permissions --}}
        <form action="">
            <div class="form-group">
                <label for="">permissions</label>
                <select multiple class="custom-select roles_permissions_select2" name="permissions_select2" id="permissions_select2"
                    style="width: 75%" placeholder="Select all permisions allowed for this role">
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->id }}">{{ $permission->access_type }}</option>
                    @endforeach


                </select>
            </div>
        </form>
    </div>
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
        $('#roles_select').on('select2:select', function(e) {
            var data = e.params.data;
            var role_id = $(data.element).data('role-id');
            console.log(role_id);
            UpdateRolesforrolesSelect2(data.id, role_id);

        });
        $('#roles_select').on('select2:unselect', function(e) {
            var data_to_del = e.params.data;
            var role_id_to_del = $(data_to_del.element).data('role-id');
            console.log(role_id_to_del);
            UpdateRolesforrolesSelect2(data_to_del.id, role_id_to_del);

        });

    });
</script>
