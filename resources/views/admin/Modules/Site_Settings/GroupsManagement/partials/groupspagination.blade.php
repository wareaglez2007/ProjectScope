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
                                    @if (request()->status == 1)
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault();DestoryGroup({{ $group->id }});"><i
                                                class="bi bi-lightbulb-off"></i>&nbsp;Deactivate</a>
                                    @endif
                                    @if (request()->status == 2)
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault();ActivateGroup({{ $group->id }});"><i
                                                class="bi bi-lightbulb-fill"></i>&nbsp;Activate</a>
                                    @endif

                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault();DeleteGroup({{ $group->id }});"><i
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

        <input type="hidden" id="groups_current_page" value="{{ $groups->currentPage() }}" />
        <input type="hidden" id="groups_last_page" value="{{ $groups->lastPage() }}" />
        <input type="hidden" id="groups_per_page_count" value="{{ $groups->count() }}" />
    @else
        <p>0 results were found.</p>
    @endif
    <input type="hidden" id="group_status" value="{{ request()->status }}" />
</div>
