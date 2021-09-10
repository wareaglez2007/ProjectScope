<form action="">
    <div class="row" id="search_users_div">
        <div class="col-md-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                </div>
                <input type="text" name="" id="search_roles" class="form-control"
                    placeholder="type (i.e. admin, human resources ...)" aria-describedby="helpId"
                    onkeyup="usersearch();" autocomplete="off">
                <div id="search_results" class="dropdown" style="position: static !important">
                </div>
            </div>
        </div>
    </div>
</form>
<div id="roles_data">
    @include('admin.Modules.Site_Settings.UserManagement.partials.showusers')
</div>
