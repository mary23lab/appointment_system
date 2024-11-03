<?php
    include 'session.php'; 

    $appointments = $conn->query("SELECT appointment.*, users.*, pets.*, appointment.id AS aid FROM appointment INNER JOIN users ON appointment.user_id = users.id INNER JOIN pets ON pets.id = appointment.pet_id WHERE appointment.visit_type = 'walk-in' ORDER BY appointment.id DESC");

    if(isset($_GET['delete_appointment_id'])){
        $appointment_delete_id = $_GET['delete_appointment_id'];

        $conn->query("DELETE FROM `appointment` WHERE id=$appointment_delete_id");
        header("Location: appointments.php");
        exit();
    }
?>

<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">event</span>
                    <strong class="mt-1">Appointments</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger rounded-0">
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped data-table small">
                        <thead>
                            <tr>
                                <th class="text-bold">ID#</th>
                                <th class="text-bold">Visit Type</th>
                                <th class="text-bold">Owner</th>
                                <th class="text-bold">Service</th>
                                <!-- <th class="text-bold">Status</th> -->
                                <th class="text-bold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                                while($a = $appointments->fetch_array()) : 
                                    $status_color = ($a['status'] == "Pending") ? 'warning' : (($a['status'] == "Approved") ? 'success' : 'danger');
                            ?>
                                <tr>
                                    <td style="padding-top: 8px"><?= $a['aid']; ?></td>
                                    <td style="padding-top: 8px"><?= ucwords($a['visit_type']); ?></td>
                                    <td style="padding-top: 8px"><?= $a['username']; ?></td>
                                    <td style="padding-top: 8px"><?= $a['service_needed']; ?></td>
                                    <!-- <td style="padding-top: 8px" class="text-center text-bold bg-<?= $status_color; ?>"><?= $a['status']; ?></td> -->
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#appointment_<?= $a['aid']; ?>">
                                            <span class="material-icons-outlined text-success mr-2">visibility</span>
                                        </a>

                                        <a href="#" onclick="deleteAppointment(<?= $a['aid']; ?>)">
                                            <span class="material-icons-outlined text-danger">delete</span>
                                        </a>
                                    </td>

                                    <?php include 'pet-details-view-appointment-modal.php'; ?>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function deleteAppointment(appointment_id){
        let ask = confirm("Are you sure you want to remove this appointment?");

        if(ask == true){
            window.location.href = "appointments.php?delete_appointment_id=" + appointment_id;
        }
    }

    var serviceSelect = document.getElementById('service_needed');
    var paymentOptionSelect = document.getElementById('payment_option');
    var conditionalFields = document.querySelector('.other_data');
    var priceField = document.getElementById('price');
    var paymentNumberFieldG = document.getElementById('payment_number_g');
    var paymentNumberField = document.getElementById('payment_number');

    var prices = {
        'Anti_rabbies': '20', // Adjust the prices as needed
        'Deworm': '15' // Adjust the prices as needed
    };

    var paymentNumbers = {
        'Gcash': '09999999999', // Replace with actual number
        'PayMaya': '09988888888' // Replace with actual number
    };

    function toggleConditionalFields() {
        var selectedService = serviceSelect.value;

        if (selectedService === 'Anti_rabbies' || selectedService === 'Deworm') {
            conditionalFields.style.display = 'block';
            priceField.value = prices[selectedService] || '';
        } else {
            conditionalFields.style.display = 'none';
            priceField.value = '';
        }
    }

    function setPaymentNumber() {
        var selectedPaymentOption = paymentOptionSelect.value;

        if (selectedPaymentOption === 'Gcash' || selectedPaymentOption === 'PayMaya') {
            paymentNumberField.value = paymentNumbers[selectedPaymentOption] || ''; 
            paymentNumberFieldG.style.display = 'block';
        } else {
            paymentNumberField.value = '';
            paymentNumberFieldG.style.display = 'none'; 
        }
    }
</script>

<?php include "../../footer.php"; ?>