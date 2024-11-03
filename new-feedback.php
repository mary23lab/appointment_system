<div class="modal fade" id="feedback">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>Send Us Feedback!</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" onsubmit="showLoaderAnimation()" action="feedback-function.php">
                    <div class="row">
                        <div class="col-xl-12">
                            <label class="small">Type here:</label>

                            <div class="input-group mb-2">
                                <input type="email" class="form-control form-control-sm" name="email" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-at"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <label class="small">Type here <span class="text-danger">*</span>:</label>
                            <textarea class="form-control form-control-sm" required name="feedback" rows="3" placeholder="Enter ..."></textarea>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border btn-sm" data-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-light border btn-sm">
                    <div class="d-flex align-items-center">
                        <span class="material-icons-outlined text-danger mr-1">send</span>
                        Submit Feedback
                    </div>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>