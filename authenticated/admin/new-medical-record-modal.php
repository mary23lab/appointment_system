<div class="modal fade" id="new_medical_record">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>New Medical Record</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="pet-details.php?id=<?= $pet_id; ?>&method=add_medical_record">
                    <div class="row">
                        <div class="col-xl-6 mb-2">
                            <label class="small">Service <span class="text-danger">*</span></label>

                            <select required id="service_needed" name="service" class="select form-control form-control-sm">
                                <option value="Laboratory">Laboratory</option>
                                <option value="Grooming">Grooming</option>
                                <option value="Consultations">Consultations</option>
                                <option value="Anti_rabbies">Anti Rabbies</option>
                                <option value="Deworm">Deworm</option>
                            </select>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Disease Diagnosed</label>

                            <select name="disease" class="select form-control form-control-sm" id="disease" required>
                                <option value="N/A" disabled selected>N/A</option>
                                
                                <?php while($row = $diseases->fetch_assoc()) : ?>
                                    <option value="<?= $row['id']; ?>">
                                        <strong><?= $row['disease']; ?></strong> - <small><?= $row['description']; ?></small>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Treatment <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" required name="treatment" rows="3" placeholder="Enter ..."></textarea>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Notes</label>
                            <textarea class="form-control form-control-sm" name="notes" rows="3" placeholder="Enter ..."></textarea>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Date of Visit <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="date" class="form-control form-control-sm" required name="date_of_visit">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-calendar-week"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Date of Return</label>

                            <div class="input-group">
                                <input type="date" class="form-control form-control-sm" name="date_of_return">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-calendar-week"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border btn-sm" data-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-light border btn-sm">
                    <div class="d-flex align-items-center">
                        <span class="material-icons-outlined text-danger mr-1">save</span>
                        Save Record
                    </div>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>