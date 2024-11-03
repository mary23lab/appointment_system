<?php
    include 'session.php'; 

    $appointments = $conn->query("SELECT appointment.*, users.*, pets.*, appointment.id AS aid FROM appointment INNER JOIN users ON appointment.user_id = users.id INNER JOIN pets ON pets.id = appointment.pet_id ORDER BY appointment.id DESC");

    if (isset($_GET['edit_appointment_id'])) {
        $edit_appointment_id = $_GET['edit_appointment_id'];
        $status = $_POST['status'];
        $remarks = $_POST['remarks'];

        $conn->query("UPDATE appointment SET `status`='$status', `reason_for_declined`='$remarks' WHERE id='$edit_appointment_id'");
        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Updates an appointment. ID# $edit_appointment_id')");

        header("location: appointments.php");
        exit();
    }

    if(isset($_GET['delete_appointment_id'])){
        $appointment_delete_id = $_GET['delete_appointment_id'];

        $conn->query("DELETE FROM `appointment` WHERE id=$appointment_delete_id");
        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Deletes an appointment. ID# $appointment_delete_id')");
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
                                <th class="text-bold">Status</th>
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
                                    <td style="padding-top: 8px" class="text-center text-bold bg-<?= $status_color; ?>"><?= $a['status']; ?></td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#appointment_<?= $a['aid']; ?>">
                                            <span class="material-icons-outlined text-success mr-2">visibility</span>
                                        </a>

                                        <a href="#" onclick="deleteAppointment(<?= $a['aid']; ?>)">
                                            <span class="material-icons-outlined text-danger">delete</span>
                                        </a>
                                    </td>

                                    <?php include 'appointment-update-modal.php'; ?>
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
</script>

<?php include "../../footer.php"; ?>