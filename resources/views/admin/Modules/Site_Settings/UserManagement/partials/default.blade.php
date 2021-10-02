   <table class="table table-bordered table-striped table-hover table-sm" id="users_table" style="width: 100%">
       <thead>
           <tr>
               <th>Id</th>
               <th>Name</th>
               <th>Email</th>
               <th>Created_at</th>
               <th></th>
           </tr>
       </thead>
   </table>





  <!-- Modal -->
  <div class="modal fade" id="confirmdestroyuser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
          <button type="button" class="btn btn-danger"  value="del" id="do_del">Delete</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" value="cancel" id="cancel_del">Cancel</button>
        </div>
      </div>
    </div>
  </div>
