<div id="roles-section">
    @if (is_countable($roles) && count($roles) > 0)
        <table class="table table-striped table-inverse table-hover">
            <thead class="thead-inverse">
                <tr>
                    <th>Role Id</th>
                    <th>Role Name</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td scope="row"><a href="{{ route('admin.roles.show', ['id' => $role->id]) }}"
                                class="text-muted">{{ $role->id }}</a></td>
                        <td><a href="{{ route('admin.roles.show', ['id' => $role->id]) }}" class="text-muted">
                                {{ $role->name }}</a>
                        </td>
                        <td><a href="{{ route('admin.roles.show', ['id' => $role->id]) }}"
                                class="text-muted">{{ $role->created_at }}</a></td>
                        <td>
                            <div class="dropdown open">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-gear-wide"></i>&nbsp;
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item"
                                        href="{{ route('admin.roles.show', ['id' => $role->id]) }}">Edit</a>
                                    <a class="dropdown-item disabled"
                                        href="{{ route('admin.roles') }}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="published_pagination">
            {{ $roles->links() }}
        </div>
    @else
        <p>There no roles currently added to database.</p>
    @endif
</div>
