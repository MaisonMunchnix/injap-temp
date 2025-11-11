<div aria-hidden="true" class="onboarding-modal modal fade animated" id="upgrade-account-modal"
role="dialog" tabindex="-1">
<div class="modal-dialog modal-lg modal-centered" role="document">
    <div class="modal-content text-center"><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="close-label">Close</span><span class="os-icon os-icon-close"></span></button>
        <div class="onboarding-side-by-side">
            <div class="onboarding-media"><img alt="" src="{{asset('img/bigicon5.png')}}" width="200px"></div>
            <div class="onboarding-content with-gradient">
                <h4 class="onboarding-title">Upgrade your account</h4>
                <div class="onboarding-text">Description here</div>
                <form>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="upgrade_code">Product Code</label>
                                <input class="form-control up-acc-input" id="upgrade_code" placeholder="Enter product code" type="text" value="">
                                <span class="text-danger d-none display-error">Error</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="upgrade_pin">Pin</label>
                                <input class="form-control up-acc-input" id="upgrade_pin" placeholder="Enter pin" type="text" value="">
                                <span class="text-danger d-none display-error"></span>
                            </div>
                        </div>
                        <div class="col-sm-12 d-none" id="up-error">
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert"><strong>Warning! </strong>Please check empty or invalid fields.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary pull-right" id="btn-upgrade">Submit</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
