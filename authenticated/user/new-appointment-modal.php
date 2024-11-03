<div class="modal fade" id="new_appointment">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title small">
                    <strong>New Appointment</strong>
                </h6>
                
                <button type="button" class="close btn-sm small" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" onsubmit="showLoaderAnimation()" action="pet-details.php?id=<?= $pet_id; ?>&method=new_appointment_pet">
                    <div class="row">
                        <div class="col-xl-12 mb-2">
                            <label class="small">Date/Time <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="datetime-local" min="<?= date('Y-m-d\TH:i'); ?>" class="form-control form-control-sm" required name="appointment_datetime">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="material-icons-outlined" style="font-size: 15px;">date_range</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 mb-2">
                            <label class="small">Service <span class="text-danger">*</span></label>

                            <select required id="service_needed" onchange="toggleConditionalFields()" name="service" class="select form-control form-control-sm">
                                <option value="Laboratory">Laboratory</option>
                                <option value="Grooming">Grooming</option>
                                <option value="Consultations">Consultations</option>
                                <option value="Anti_rabbies">Anti_rabbies</option>
                                <option value="Deworm">Deworm</option>
                            </select>
                        </div>

                        <div class="col-xl-12">
                            <label class="small">My Address <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm" required name="address" rows="3" placeholder="Enter ..."></textarea>
                        </div>

                        <div class="col-xl-12 other_data">
                            <div class="row">
                                <div class="col-xl-12 my-2">
                                    <label class="small">Price</label>

                                    <div class="input-group">
                                        <input type="number" id="price" placeholder="Price" class="form-control form-control-sm" name="price">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="material-icons-outlined" style="font-size: 15px;">money</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 mb-2">
                                    <label class="small">Payment Option</label>

                                    <select name="payment_option" onchange="setPaymentNumber()" id="payment_option" class="select form-control form-control-sm">
                                        <option disabled selected>N/A</option>
                                        <option value="Gcash">Gcash</option>
                                        <option value="PayMaya">PayMaya</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                </div>

                                <div class="col-xl-12 my-2" id="payment_number_g">
                                    <label class="small">Payment#</label>

                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" id="payment_number" placeholder="Payment#" name="payment_number">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="material-icons-outlined" style="font-size: 15px;">tag</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <label class="small">Reference#</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="Reference#" name="reference">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="material-icons-outlined" style="font-size: 15px;">tag</span>
                                            </div>
                                        </div>
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
                        <span class="material-icons-outlined text-danger mr-1">send</span>
                        Submit Appointment
                    </div>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>