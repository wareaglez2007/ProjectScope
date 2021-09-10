<form action="">
    <div class="row" id="search_users_div">
        <div class="col-md-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                </div>
                <input type="text" name="" id="search_users" class="form-control"
                    placeholder="search for users in the database" aria-describedby="helpId"
                    onkeyup="usersearch();" autocomplete="off">
                <div id="search_results" class="dropdown" style="position: static !important">
                </div>
            </div>
        </div>
    </div>
</form>

<div id="users_data">
    @include('admin.Modules.Site_Settings.UserManagement.partials.showusers')
</div>
