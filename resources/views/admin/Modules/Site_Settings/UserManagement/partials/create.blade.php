{{-- Create new user form --}}

    <form action="{{ route('admin.users.store') }}">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Name <i class="bi bi-asterisk text-danger"></i></label>
                    <input type="text" name="user_name" id="user_name" class="form-control" placeholder=""
                        aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Enter your name</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="user_email" class="h6">Email <i
                            class="bi bi-asterisk text-danger"></i></label>
                    <input type="email" name="user_email" id="user_email" class="form-control"
                        placeholder="youremail@domain.com" aria-describedby="helpId">
                    <small id="helpId" class="text-muted">Enter your email address</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Password <i class="bi bi-asterisk text-danger"></i></label>
                    <input type="password" name="user_pass" id="user_pass" class="form-control" placeholder=""
                        aria-describedby="helpId" minlength="8">
                    <small id="helpId" class="text-muted">Must be 8 charecters minimum</small>
                </div>
            </div>
        </div>
        @if (is_countable($roles) && count($roles) > 0)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Roles</label>
                        <select multiple class="custom-select users_roles_select2" name="user_role_select2"
                            id="role_select2" style="width: 100%">
                            @foreach ($roles as $role)

                                <option value="{{ $role->id }}" data-mod-id="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach


                        </select>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="single_role" id="single_role"
                                    value="checkedValue" checked>
                                Guest
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-primary" id="create_new_user" onclick=" event.preventDefault();CreateNewUser();">Create User</a>
            </div>
        </div>
    </form>


<script>
    $(function() {



        $('.users_roles_select2').select2({
            theme: "classic",
            width: 'resolve',
            placeholder: 'Select all roles for this new user!'

        });
        $('#role_select2').on('select2:select', function(e) {
            var data = e.params.data;
        });


    }); //END of DOM ON READY <<-------------------
</script>
