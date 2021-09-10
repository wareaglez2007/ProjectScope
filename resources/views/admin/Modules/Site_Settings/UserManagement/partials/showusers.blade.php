@if (is_countable($users) && count($users) > 0)


    <div class="col-md-12">
        @if (request()->exists('search_q'))
            @php
                if ($search_count > 1) {
                    $res = 'results were ';
                } else {
                    $res = 'result was ';
                }

            @endphp

            <p><span class="text-primary">{{ $search_count }}</span> {{ $res }} found for
                {{ $search_q }}.</p>
        @else
            @php
                if ($search_count > 1) {
                    $user_label = 'users are';
                } else {
                    $user_label = 'user is';
                }

            @endphp

            <p><span class="text-primary">{{ $search_count }}</span> {{ $user_label }} registered with the system.
            </p>
        @endif

    </div>

    <form action="">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role Id</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        {{-- user id --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}"> {{ $user->id }}</a>
                        </td>
                        {{-- user Name --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}"> {{ $user->name }}</a>
                        </td>
                        {{-- user email --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}"> {{ $user->email }}</a>
                        </td>
                        {{-- user role id --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}">
                                {{ $user->roles_id }}</a></td>
                        {{-- created at --}}
                        <td><a href="{{ route('admin.users.show', ['id' => $user->id]) }}">
                                {{ $user->created_at }}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <div id="users_default_pagination">
        {{ $users->links() }}
    </div>
    <input type="hidden" value="{{ $search_q }}" id="search_query" />
@else
    <div class="row">
        <p>{{ $search_count }} results where found for {{ $search_q }}.</p>
    </div>
@endif
