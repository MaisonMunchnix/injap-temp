<div class="modal" tabindex="-1" role="dialog" id="claim_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Claim encashment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-12">

                            <p class="text-center"><strong>Encashment Details</strong></p>
                            <table class="table">
                                <tr>
                                    <td class="text-left">Amount requested : </td>
                                    <td class="text-right"><span id="details_ar"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Amount approved : </td>
                                    <td class="text-right"><span id="details_appr"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Tax({{$ayuda_tax}}%) : </td>
                                    <td class="text-right"><span id="details_tax"></span></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Processing fee : </td>
                                    <td class="text-right">{{$process_fee}}php</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Total Claim : </td>
                                    <td class="text-right"><span id="details_total_claim"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-process-claim">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
