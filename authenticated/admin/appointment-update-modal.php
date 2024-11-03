<div class="modal fade" id="appointment_<?= $a['aid']; ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>Update Appointment Status</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="appointments.php?edit_appointment_id=<?= $a['aid']; ?>">
                    <label class="small">Visit Type:</label> <small><?= $a['visit_type']; ?></small><br>
                    <label class="small">Date/Time:</label> <small><?= date("F d, Y h:i A", strtotime($a['appointment_datetime'])); ?></small><br>
                    <label class="small">Service:</label> <small><?= $a['service_needed']; ?></small><br>
                    <label class="small">Remarks:</label> <small><?= $a['reason_for_declined'] ?? "N/A"; ?></small><br>
                    <label class="small">Price:</label> <small><?= $a['price'] ?? "N/A"; ?></small><br>
                    <label class="small">Payment Option:</label> <small><?= $a['payment_option'] ?? "N/A"; ?></small><br>
                    <label class="small">Payment#:</label> <small><?= $a['payment_number'] ?? "N/A"; ?></small><br>
                    <label class="small">Reference#:</label> <small><?= $a['reference_number'] ?? "N/A"; ?></small><br>

                    <div class="row">
                        <div class="col-xl-12 mb-2">
                            <label class="small">Status <span class="text-danger">*</span></label>

                            <select required name="status" class="select form-control form-control-sm">
                                <option <?= $a['status'] == "Approved" ? 'selected' : ''; ?> value="Approved">Approved</option>
                                <option <?= $a['status'] == "Declined" ? 'selected' : ''; ?> value="Declined">Declined</option>
                            </select>
                        </div>

                        <div class="col-xl-12">
                            <label class="small">Remarks</label>
                            <textarea value="<?= $a['reason_for_declined'] ?>" class="form-control form-control-sm" name="remarks" rows="3" placeholder="Enter ..."><?= $a['reason_for_declined'] ?></textarea>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border btn-sm" data-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-light border btn-sm">
                    <div class="d-flex align-items-center">
                        <span class="material-icons-outlined text-danger mr-1">save</span>
                        Save Changes
                    </div>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>