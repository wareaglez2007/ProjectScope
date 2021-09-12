<thead id="users_table_data">
    <tr>
        {{-- ('bi bi-sort-numeric-up-alt', 'bi bi-sort-numeric-down'); --}}
        {{-- sortListsBy(selector, by, direction, icon_name, switch_icon) --}}
        <th
            onclick="sortListsBy('sort-by_id_asc', 'id', '{{ $direction }}', 'bi bi-sort-numeric-down', 'bi bi-sort-numeric-up-alt' );">
            <a class="text-muted" id="sort-by_id_asc">Id&nbsp;
                <i class="bi bi-sort-numeric-{{ $icon_directions->id_icon }} h5">
                </i>
            </a>
        </th>
        <th
            onclick="sortListsBy('sort-by_name_asc', 'name', '{{ $direction }}', 'bi bi-sort-alpha-down', 'bi bi-sort-alpha-up-alt' );">
            <a class="text-muted" id="sort-by_name_asc">Name&nbsp;
                <i class="bi bi-sort-alpha-{{ $icon_directions->name_icon }} h5">
                </i>
            </a>
        </th>
        <th
            onclick="sortListsBy('sort-by_email_asc', 'email', '{{ $direction }}', 'bi bi-sort-alpha-down', 'bi bi-sort-alpha-up-alt' );">
            <a class="text-muted" id="sort-by_email_asc">Email&nbsp;
                <i class="bi bi-sort-alpha-{{ $icon_directions->email_icon }} h5"></i>
            </a>
        </th>


        <th
            onclick="sortListsBy('sort-by_role_asc', 'roles_id', '{{ $direction }}', 'bi bi-sort-alpha-down', 'bi bi-sort-alpha-up-alt' );">
            <a class="text-muted" id="sort-by_role_asc">RoleId&nbsp;
                <i class="bi bi-sort-alpha-{{ $icon_directions->role_icon }} h5"></i>
            </a>
        </th>
        <th
            onclick="sortListsBy('sort-by_cd_asc', 'created_at', '{{ $direction }}', 'bi bi-sort-numeric-down', 'bi bi-sort-numeric-up-alt' );">
            <a class="text-muted" id="sort-by_cd_asc">CreatedAt&nbsp;
                <i class="bi bi-sort-numeric-{{ $icon_directions->cd_icon }} h5"></i>
            </a>
        </th>
    </tr>
    <input type="hidden" id="current_page_num" value="{{ $users->currentPage() }}" />
    <input type="hidden" id="current_sort_direction" value="{{ $current_direction }}" />
    <input type="hidden" id="current_sort_by" value="{{ $sortby }}" />
</thead>
