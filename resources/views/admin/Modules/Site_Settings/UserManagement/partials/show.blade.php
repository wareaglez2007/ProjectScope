{{-- @if ($role_view == 'show_roles_modules') --}}

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
@endauth
