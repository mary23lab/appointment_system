<div class="modal fade" id="appointment_<?= $a['id']; ?>">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>Appointment Details</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <label class="small">Date/Time:</label> <small><?= $a['appointment_datetime']; ?></small><br>
                <label class="small">Service:</label> <small><?= $a['service_needed']; ?></small><br>
                <label class="small">Status:</label> <small><?= $a['status']; ?></small><br>
                <label class="small">Remarks:</label> <small><?= $a['reason_for_declined'] ?? "N/A"; ?></small><br>
                <label class="small">Price:</label> <small><?= $a['price'] ?? "N/A"; ?></small><br>
                <label class="small">Payment Option:</label> <small><?= $a['payment_option'] ?? "N/A"; ?></small><br>
                <label class="small">Payment#:</label> <small><?= $a['payment_number'] ?? "N/A"; ?></small><br>
                <label class="small">Reference#:</label> <small><?= $a['reference_number'] ?? "N/A"; ?></small><br>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>