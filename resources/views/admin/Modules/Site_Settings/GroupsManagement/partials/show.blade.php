<form action="" method="post">
    @csrf
    <table class="table table-inverse table-hover">
        <thead class="thead-inverse">
            <tr>
                <th>Group ID</th>
                <th>Group Name</th>
                <th class="only-desktop">Created at</th>
                <th class="only-desktop">Updated at</th>
                <th >Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">{{ $group->id }}</td>
                <td class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="g_name" id="g_name" value="{{ $group->name }}" class="form-control"
                            placeholder="" aria-describedby="helpId">
                    </div>
                </td>
                
                <td class="only-desktop">{{ $group->created_at }}</td>
                <td class="only-desktop">{{ $group->updated_at }}</td>
                <td >
                    <a href="#" class="btn btn-primary active" role="button">Update</a>
                </td>
            </tr>
        </tbody>
    </table>

</form>
