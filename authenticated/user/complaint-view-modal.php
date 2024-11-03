<div class="modal fade" id="complaint_<?= $row['id'] ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>Update Complaint</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="complaints.php?update=true&id=<?= $row['id'] ?>">
                    <div class="row">
                        <div class="col-xl-6 mb-2">
                            <label class="small">Category <span class="text-danger">*</span></label>

                            <select required name="complaint" class="select form-control form-control-sm">
                                <option <?= $row['category'] == "Complaint" ? 'selected' : ''; ?> value="Complaint">Complaint</option>
                                <option <?= $row['category'] == "Report" ? 'selected' : ''; ?> value="Report">Report</option>
                            </select>
                        </div>

                        <div class="col-xl-12 mb-3">
                            <label class="small">Message <span class="text-danger">*</span></label>
                            <textarea value="<?= $row['message'] ?>" class="form-control form-control-sm" required name="message" rows="3" placeholder="Enter ..."><?= $row['message'] ?></textarea>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border btn-sm" data-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-light border btn-sm">
                    <div class="d-flex align-items-center">
                        <span class="material-icons-outlined text-warning mr-1">save</span>
                        Save Changes
                    </div>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>