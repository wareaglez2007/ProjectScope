@if ($errors->any())
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
@if (session('update_response'))
    <div class="alert alert-success alert-dismissible fade show" role="alert"">
        <button type=" button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        {{ session('update_response') }}
    </div>
@endif

@if (session('response'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert"">
    <button type=" button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
        </button>
        {{ session('response') }}
    </div>
@endif

<form action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            {{-- Name --}}
            <div class="form-group">
                <label for="">Name <i class="text-danger">*</i></label>
                <input type="text" name="name" id="edit_name" class="form-control" value="{{ $user->name }}"
                    placeholder="" aria-describedby="helpId">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            {{-- Email --}}
            <div class="form-group">
                <label for="">Email <i class="text-danger">*</i></label>
                <input type="email" name="email" id="edit_email" class="form-control" value="{{ $user->email }}"
                    placeholder="" aria-describedby="helpId">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{-- password --}}
            <div class="form-group">
                <label for="">Password <i class="text-danger">*</i></label>
                <input type="password" name="pass" id="edit_password" class="form-control" value="" placeholder=""
                    aria-describedby="helpId">
            </div>
        </div>
    </div>


    {{-- Roles --}}
    @if (is_countable($roles) && count($roles) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Roles <i class="text-danger">*</i></label>
                    <select multiple class="custom-select users_roles_select2" name="user_role_select2[]"
                        id="role_select2" style="width: 100%">
                        @foreach ($roles as $role)
                            @php
                                $selected = '';
                            @endphp
                            @if (is_countable($user->roles) && count($user->roles) > 0)
                                @foreach ($user->roles as $role_assigned)
                                    @php
                                        if ($role_assigned->id == $role->id) {
                                            $selected = 'selected';
                                        }
                                    @endphp
                                @endforeach
                            @endif

                            <option value="{{ $role->id }}" data-mod-id="{{ $role->id }}" {{ $selected }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
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
        <div class="col-md-12">
            <input type="submit" class="btn btn-secondary btn-md col-md-3" value="Save" />
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
