
    <form action="">
        <table class="table table-bordered table-striped table-hover table-sm" id="users_table" style="width: 100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
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
                        <td  class="text-muted">
                                {{ $user->name }}
                        </td>
                        {{-- user email --}}
                        <td class="text-muted">
                                {{ $user->email }}
                        </td>
                        {{-- user role id --}}
                        <td><a href="" class="text-muted">
                              </a></td>
                        {{-- created at --}}
                        <td><a href="" class="text-muted">
                                </a></td>
                    </tr>

            </tbody>
        </table>

    </form>

