 <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Upgrade your account</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <i class="ti-close"></i>
                 </button>
             </div>
             <div class="modal-body">
                 <form>
                     <div class="form-group">
                         <label for="recipient-name" class="col-form-label">Product Code:</label>
                         <input type="text" class="form-control" id="recipient-name">
                     </div>
                     <div class="form-group">
                         <label for="message-text" class="col-form-label">Product Pin:</label>
                         <input type="text" class="form-control" id="message-text">
                     </div>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                 </button>
                 <button type="button" class="btn btn-primary">Submit</button>
             </div>
         </div>
     </div>
 </div>


 <footer class="content-footer">
     <div>© {{ date('Y') }} {{ env('APP_NAME') }} - All Right Reserve - Innovation Japan</div>

 </footer>
