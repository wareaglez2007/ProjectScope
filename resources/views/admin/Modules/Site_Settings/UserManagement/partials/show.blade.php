@if (is_countable($users) && count($users) > 0)
    <form action="">
        <table class="table table-bordered table-striped table-hover table-sm" id="users_table" style="width: 100%">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles ID</th>
                    <th>Created_at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        {{-- user id --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="text-muted">
                                {{ $user->id }}</a>
                        </td>
                        {{-- user Name --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="text-muted">
                                {{ $user->name }}</a>
                        </td>
                        {{-- user email --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="text-muted">
                                {{ $user->email }}</a>
                        </td>
                        {{-- user role id --}}
                        <td><a href="{{ route('admin.roles.edit', ['id' => $user->roles_id]) }}" class="text-muted">
                                {{ $user->roles_id }}</a></td>
                        {{-- created at --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="text-muted">
                                {{ $user->created_at }}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </form>

@else

@endif
