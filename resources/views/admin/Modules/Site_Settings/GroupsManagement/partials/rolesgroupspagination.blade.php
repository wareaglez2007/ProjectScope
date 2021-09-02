   <form action="" method="get" id="show_group_in">
       @csrf
       <table class="table">
           <thead class="thead-inverse">
               <tr>
                   <th>Group ID</th>
                   <th>Group Name</th>
                   <th class="only-desktop">Created at</th>
                   <th class="only-desktop">Updated at</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>
               <tr>
                   <td scope="row">{{ $group->id }}</td>
                   <td class="col-md-3">
                       <div class="form-group">
                           <input type="text" name="group_name" id="g_name" value="{{ $group->name }}"
                               class="form-control" placeholder="" aria-describedby="helpId">
                           <input type="hidden" name="group_id" id="use_for_group_id" value="{{ $group->id }}" />
                       </div>

                   </td>

                   <td class="only-desktop">{{ $group->created_at }}</td>
                   <td class="only-desktop">{{ $group->updated_at }}</td>
                   <td>
                       <button type="submit" class="btn btn-primary"
                           onclick="event.preventDefault();UpdateGroupName({{ $group->id }});">Update Group Name</button>
                   </td>
               </tr>
           </tbody>
       </table>
       <div>
           @if (count($roles_assigned) == 0)
               <p class="text-danger" id="ajax_message">There are no assigned roles for this group!</p>
           @endif

       </div>
       <p id="ajax_messsage_updates"></p>
       <div class="col-md-6">
           @if (is_countable($roles) && count($roles) > 0)

               <table class="table" id="roles_for_groups">
                   <thead>
                       <tr>
                           <th>Select</th>
                           <th>Role Id</th>
                           <th>Role Name</th>
                       </tr>
                   </thead>
                   <tbody>
                       {{-- if there are roles then it should be checked --}}
                       @foreach ($roles as $role)
                           @php
                               $checked = '';

                               if (is_countable($roles_assigned) && count($roles_assigned) > 0) {
                                   foreach ($roles_assigned as $role_assigned) {
                                       if ($role->id == $role_assigned->id) {
                                           $checked = 'checked';
                                       }
                                   }
                               }

                           @endphp
                           <tr>
                               <td>
                                   <label class="switch">

                                       <input type="checkbox" data-toggle="toggle" data-on="Yes" name="roles"
                                           data-off="No" id="role_{{ $role->id }}" value="{{ $role->id }}"
                                           {{ $checked }}
                                           onchange="UpdateGroupsRoles({{ $role->id }}, {{ $id }})">

                                       <span class="slider round"></span>
                                   </label>
                               </td>
                               <td scope="row">{{ $role->id }}</td>
                               <td>{{ $role->name }}</td>

                           </tr>



                       @endforeach
                   </tbody>
               </table>
               <div id="groups_roles_show_pagination">
                   {{-- {{ $roles->links() }} --}}

                   {{ $roles->links() }}

                <input type="hidden" id="roles_groups_current_page" value="{{ $roles->currentPage() }}"/>
               </div>
           @else
               <p>There are no roles in the roles database.</p>
           @endif
       </div>
