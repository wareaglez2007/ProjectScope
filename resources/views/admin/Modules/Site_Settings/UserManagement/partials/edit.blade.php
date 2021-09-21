<form action="">
    <table class="table table-bordered table-striped table-hover table-sm" id="show_user_table" style="width: 100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Modules</th>
                <th>Permissions</th>
                <th>Created_at</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                {{-- user id --}}
                <td class="text-muted">
                    {{ $user->id }}
                </td>
                {{-- user Name --}}
                <td class="text-muted">
                    <div class="form-group">
                      <label for="">Name:</label>
                      <input type="text" name="" id="" class="form-control" placeholder="" value="{{ $user->name }}" aria-describedby="helpId">
                      <small id="helpId" class="text-muted hide" ></small>
                    </div>

                </td>
                {{-- user email --}}
                <td class="text-muted">
                    {{ $user->email }}
                </td>
                {{-- user role id --}}
                <td class="text-muted">
                    @if (is_countable($user->roles) && count($user->roles) > 0)

                        @foreach ($user->roles as $role)
                            @if (count($user->roles) > 1)
                                {{-- User has more than one role --}}
                                <h5><span class="badge badge-primary"> {{ $role->name }}</span></h5>
                            @else
                                <h5><span class="badge badge-primary"> {{ $role->name }}</span></h5>

                            @endif
                        @endforeach
                    @else
                        <span class="text-danger">There are no roles assigned to this user.</span>
                    @endif
                </td>
                <td>
                    <table class="table table-striped" >
                        @foreach ($mprs as $user_mods)

                            @foreach ($modules as $mods)

                                @if ($mods->id == $user_mods->modules_id)
                                    <tr>
                                        <td class="badge badge-info">{{ $mods->name }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach

                    </table>

                </td>

                <td>
                    <table class="table table-striped">
                        @foreach ($mprs as $user_mods)
                            @foreach ($permissions as $perm)
                                @if ($perm->id == $user_mods->permissions_id)
                                    <tr>
                                        <td class="badge badge-secondary">{{ $perm->access_type }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach

                    </table>
                </td>
                       {{-- created at --}}
                       <td>
                           {{ $user->created_at }}
                       </td>
            </tr>

        </tbody>
    </table>

</form>
