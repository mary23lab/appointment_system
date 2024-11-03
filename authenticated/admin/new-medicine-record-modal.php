<div class="modal fade" id="new_medicine_record">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>New Medicine History</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="pet-details.php?id=<?= $pet_id; ?>&method=add_medicine_history">
                    <div class="row">
                        <div class="col-xl-6 mb-2">
                            <label class="small">Medicine Name <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="medicine_name" placeholder="Medicine Name" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-file"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Dosage <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="dosage" placeholder="Dosage" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-tag"></span>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <div class="col-xl-6 mb-2">
                            <label class="small">Frequency <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="frequency" placeholder="Frequency" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-calendar-week"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Duration <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="duration" placeholder="Duration" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-calendar-week"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Weight of Pet <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" name="pet_weight" placeholder="Weight of Pet" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-tag"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mb-2">
                            <label class="small">Route of Administration <span class="text-danger">*</span></label>

                            <select required name="route_of_administration" class="select form-control form-control-sm">
                                <option value="Oral">Oral</option>
                                <option value="Topical">Topical</option>
                                <option value="Injection">Injection</option>
                            </select>
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