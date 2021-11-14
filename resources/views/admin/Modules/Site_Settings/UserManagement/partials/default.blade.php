<div class="row">
    {{-- user options --}}
    <div class="col-md-12">
        <div class="card" style="margin-bottom: 15px;">
            <div class="card-body">
                <form action="">
                    <input type="hidden" name="draw" value=""/>
                    <input type="hidden" name="columns[]" value=""/>
                    <input type="hidden" name="" value=""/>
                    <input type="hidden" name="" value=""/>
                    <input type="hidden" name="" value=""/>
                </form>
                @foreach ($cats as $cat)


                    <a href="#" class="btn btn-outline-dark btn-sm" style="margin-bottom: 3px;"
                    onclick="filtercat('{{ $cat->name }}');">

                        <span class="p" style="font-weight: bold !important">{{ $cat->name }}</span> ({{ $cat->users_count }})</a>
                @endforeach

            </div>
        </div>
    </div>
</div>

<table class="table table-bordered table-striped table-hover table-sm" id="users_table" style="width: 100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role(s)</th>
            <th>Created_at</th>
            <th></th>

        </tr>
    </thead>
</table>
<input type="hidden" name="role_cat" value="" id="role_cat">




<!-- Modal -->
<div class="modal fade" id="confirmdestroyuser" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Attention</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to delete?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" value="del" id="do_del">Delete</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" value="cancel"
                    id="cancel_del">Cancel</button>
            </div>
        </div>
    </div>
</div>
