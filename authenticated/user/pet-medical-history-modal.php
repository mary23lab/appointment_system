<div class="modal fade" id="medical_history_<?= $a['pmid']; ?>">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>Medical History Details</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <label class="small">Date/Time:</label> <small><?= date("F d, Y h:i A", strtotime($a['created_at'])); ?></small><br>
                <label class="small">Service:</label> <small><?= $a['service']; ?></small><br>
                <label class="small">Disease Diagnosed:</label> <small><?= $a['disease'] ?? "<i class='text-muted'>(None)</i>"; ?></small><br>
                <label class="small">Treatment Given:</label> <small><?= $a['treatment_given'] ?? "N/A"; ?></small><br>
                <label class="small">Notes:</label> <small><?= $a['notes'] ?? "N/A"; ?></small><br>
                <label class="small">Date of Visit:</label> <small><?= date("F d, Y h:i A", strtotime($a['date_of_visit'])); ?></small><br>
                <label class="small">Date of Return:</label> <small><?= $a['date_of_return'] ? date("F d, Y h:i A", strtotime($a['date_of_return'])) : "N/A"; ?></small><br>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>