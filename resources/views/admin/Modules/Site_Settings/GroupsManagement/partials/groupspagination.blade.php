<div id="groups-section">


    @if (is_countable($groups) && count($groups) > 0)
        <table class="table table-inverse table-hover">
            <thead class="thead-inverse">
                <tr>
                    <th>Group Id</th>
                    <th>Group Name</th>
                    <th>Assigned Roles Count</th>
                    <th>Updated On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                    @php
                        foreach ($roles_count as $role_count) {
                            if ($group->id == $role_count->id) {
                                $assigned_roles_count = $role_count->Roles->count();
                            }
                        }
                    @endphp
                    <tr>
                        <td scope="row"><a href="{{ route('admin.groups.show', ['id' => $group->id]) }}"
                                class="text-muted">{{ $group->id }}</a></td>
                        <td><a href="{{ route('admin.groups.show', ['id' => $group->id]) }}" class="text-muted">
                                {{ $group->name }}</a>
                        </td>
                        <td><a href="{{ route('admin.groups.show', ['id' => $group->id]) }}"
                                class="badge badge-pill badge-dark">
                                {{ $assigned_roles_count }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.groups.show', ['id' => $group->id]) }}"
                                class="text-muted">{{ $group->updated_at }}</a>
                        </td>
                        <td>
                            <div class="dropdown open">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-gear-wide-connected"></i>&nbsp;
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item"
                                        href="{{ route('admin.groups.show', ['id' => $group->id]) }}"><i
                                            class="bi bi-pencil"></i>&nbsp;Edit</a>
                                    <a class="dropdown-item" href="{{ route('admin.groups') }}"><i
                                            class="bi bi-lightbulb-off"></i>&nbsp;Deactivate</a>
                                    <a class="dropdown-item" href="{{ route('admin.groups') }}"><i
                                            class="bi bi-trash"></i>&nbsp;Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div id="groups_default_pagination">
            {{ $groups->links() }}
        </div>
    @else
        <p>There no groups currently added to database.</p>
    @endif
</div>
