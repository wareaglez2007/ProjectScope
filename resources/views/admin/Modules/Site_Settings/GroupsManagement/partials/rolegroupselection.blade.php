<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="">Assigned roles to this group</label>
            <select multiple class="form-control" name="roles" id="roles_select" style="width: 100% !important;">
                @if (is_countable($roles2) && count($roles2) > 0)
                    @foreach ($roles2 as $role)

                        @php
                            $selected = '';

                            if (is_countable($roles_assigned) && count($roles_assigned) > 0) {
                                foreach ($roles_assigned as $role_assigned) {
                                    if ($role->id == $role_assigned->id) {
                                        $selected = 'selected';
                                    }
                                }
                            }

                        @endphp
                        <option value="{{ $role->id }}" {{ $selected }} data-group-id="{{ $id }}">
                            {{ $role->name }}</option>
                    @endforeach

                @endif
            </select>
        </div>
    </div>
</div>
<script>
    $(function() {

        /**
         * SELECT 2
         * ONLY use on specific elements that you want
         */
        $('#roles_select').select2({
            theme: "classic",
            width: 'resolve',
            placeholder: "Select roles for this group..."
        });
        $('#roles_select').on('select2:select', function(e) {
            var data = e.params.data;
            var group_id = $(data.element).data('group-id');
            console.log(group_id);
            UpdateRolesforGroupsSelect2(data.id, group_id);

        });
        $('#roles_select').on('select2:unselect', function(e) {
            var data_to_del = e.params.data;
            var group_id_to_del = $(data_to_del.element).data('group-id');
            console.log(group_id_to_del);
            UpdateRolesforGroupsSelect2(data_to_del.id, group_id_to_del);

        });

    });
</script>
