<div class="modal fade" id="feedback_<?= $row['id'] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>Feedback Details</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <label class="small">Email:</label> <small><?= $row['email']; ?></small><br>
                <label class="small">Message:</label> <small><?= $row['message']; ?></small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>