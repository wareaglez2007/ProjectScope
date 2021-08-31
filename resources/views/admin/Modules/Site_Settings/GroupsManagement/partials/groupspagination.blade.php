<div id="groups-section">
    @if (is_countable($groups) && count($groups) > 0)
        <table class="table table-striped table-inverse table-hover">
            <thead class="thead-inverse">
                <tr>
                    <th>Group Id</th>
                    <th>Group Name</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                    <tr>
                        <td scope="row"><a href="{{ route('admin.groups.show', ['id' => $group->id]) }}"
                                class="text-muted">{{ $group->id }}</a></td>
                        <td><a href="{{ route('admin.groups.show', ['id' => $group->id]) }}" class="text-muted">
                                {{ $group->name }}</a>
                        </td>
                        <td><a href="{{ route('admin.groups.show', ['id' => $group->id]) }}"
                                class="text-muted">{{ $group->created_at }}</a></td>
                        <td>
                            <div class="dropdown open">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-gear-wide-connected"></i>&nbsp;
                                </button>
                                <div class="dropdown-menu" aria-labelledby="triggerId">
                                    <a class="dropdown-item"
                                        href="{{ route('admin.groups.show', ['id' => $group->id]) }}">Edit</a>
                                    <a class="dropdown-item disabled" href="{{ route('admin.groups') }}">Delete</a>
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
