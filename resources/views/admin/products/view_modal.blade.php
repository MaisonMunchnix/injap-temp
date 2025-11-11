<div id="view-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-modal-title">View Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th>Name:</th>
                            <td id="view_name"></td>
                        </tr>
                        <tr>
                            <th>Cost Price:</th>
                            <td id="view_cost_price"></td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td id="view_price"></td>
                        </tr>
                        <tr>
                            <th>Reward Points Percentage:</th>
                            <td id="view_reward_points_percentage"></td>
                        </tr>
                        <tr>
                            <th>Critical Level:</th>
                            <td id="view_critical_level"></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td id="view_description"></td>
                        </tr>
                        <tr class="text-center">
                            <td colspan="2"><img class="img-fluid" id="product-view-image"></td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->

<div id="picture_preview-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="add-modal-title"
    aria-hidden="true" style="z-index:9999;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-modal-title">Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> <!-- // END .modal-header -->
            <div class="modal-body text-center">
                <img src="" id="product-img-tag" class="img-fluid">
            </div> <!-- // END .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div> <!-- // END .modal-footer -->
        </div> <!-- // END .modal-content -->
    </div> <!-- // END .modal-dialog -->
</div> <!-- // END .modal -->
