@if (is_countable($users) && count($users) > 0)




    <form action="">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    {{-- ('bi bi-sort-numeric-up-alt', 'bi bi-sort-numeric-down'); --}}
                    {{-- sortListsBy(selector, by, direction, icon_name, switch_icon) --}}
                    <th><a class="text-muted" id="sort-by_id_asc" onclick="sortListsBy('sort-by_id_asc', 'id', 'desc', 'bi bi-sort-numeric-down', 'bi bi-sort-numeric-up-alt' );">Id&nbsp;<i class="bi bi-sort-numeric-down h5"></i></a>
                    </th>
                    <th><a class="text-muted" id="sort-by_name_asc">Name&nbsp;<i
                                class="bi bi-sort-alpha-down h5"></i></a></th>
                    <th><a class="text-muted" id="sort-by_email_asc">Email&nbsp;<i
                                class="bi bi-sort-alpha-down h5"></i></a></th>
                    <th><a class="text-muted" id="sort-by_role_asc">Role Id&nbsp;<i
                                class="bi bi-sort-alpha-down h5"></i></a></th>
                    <th><a class="text-muted" id="sort-by_cd_asc">Created At&nbsp;<i
                                class="bi bi-sort-numeric-down h5"></i></a></th>
                </tr>
                <input type="hidden" id="current_page_num" value="{{ $users->currentPage() }}"/>
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
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="text-muted">
                                {{ $user->roles_id }}</a></td>
                        {{-- created at --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}" class="text-muted">
                                {{ $user->created_at }}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <div class="row">
        <div class="col-md-4">
            {!! $start_end !!}
        </div>
        <div id="users_default_pagination" class="col-md-8">
            {{ $users->links() }}
        </div>
    </div>
    <input type="hidden" value="{{ $search_q }}" id="search_query" />
@else
    <div class="row">
        <p>{{ $search_count }} results where found for {{ $search_q }}.</p>
    </div>
@endif
