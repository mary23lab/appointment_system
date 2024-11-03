<div class="modal fade" id="medicine_history_<?= $a['pmid']; ?>">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>Medicine History Details</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <label class="small">Date/Time:</label> <small><?= date("F d, Y h:i A", strtotime($a['created_at'])); ?></small><br>
                <label class="small">Medicine:</label> <small><?= $a['medicine_name']; ?></small><br>
                <label class="small">Dosage:</label> <small><?= $a['dosage']; ?></small><br>
                <label class="small">Route of Administration:</label> <small><?= $a['route_of_administration']; ?></small><br>
                <label class="small">Frequency:</label> <small><?= $a['frequency']; ?></small><br>
                <label class="small">Duration:</label> <small><?= $a['duration']; ?></small><br>
                <label class="small">Pet Weight:</label> <small><?= $a['pet_weight']; ?></small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>