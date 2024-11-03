<?php
    include 'session.php'; 

    $pet_id = $_GET['id'];
    
    $this_pet = $conn->query("SELECT pets.*, users.*, users.id AS pet_owner, pets.profile_picture AS ppp FROM pets INNER JOIN users ON pets.user_id = users.id WHERE pets.id=$pet_id")->fetch_assoc(); 
    $medical_records = $conn->query("SELECT `pet_med_history`.*, `pet_diseases`.*, `pet_med_history`.`id` AS pmid FROM `pet_med_history` LEFT JOIN `pet_diseases` ON `pet_med_history`.`disease_diagnosed` = `pet_diseases`.`id` WHERE `pet_med_history`.`pet_id`=$pet_id ORDER BY `pet_med_history`.`id` DESC");
    $medicine_history = $conn->query("SELECT `pet_medicine_history`.*, `pet_medicine_history`.`id` AS pmid FROM `pet_medicine_history` WHERE `pet_medicine_history`.`pet_id`=$pet_id ORDER BY `pet_medicine_history`.`id` DESC");
    $appointments = $conn->query("SELECT * FROM appointment WHERE `pet_id`=$pet_id ORDER BY id DESC");

    if (isset($_GET['method']) && $_GET['method'] == "new_appointment_pet") {
        $visit_type = $_POST['visit_type'];
        $appointment_datetime = $_POST['appointment_datetime'];
        $address = $_POST['address'];
        $service_needed = $_POST['service'];
        $price = $_POST['price'] ?? "0.0";
        $payment = $_POST['payment_option'] ?? "";
        $payment_number = $_POST['payment_number'] ?? "";
        $reference = $_POST['reference'] ?? "";
        $appointment = "appointment";
    
        $query = "INSERT INTO appointment (visit_type, appointment_datetime, address, service_needed, user_id, pet_id, price, payment_option, payment_number, reference_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssiiisss', $visit_type, $appointment_datetime, $address, $service_needed, $this_pet['pet_owner'], $pet_id, $price, $payment, $payment_number, $reference);
        $executeResult = $stmt->execute();

        if (!$executeResult) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        } else {
            $_SESSION['success_message'] = "New appointment recorded successfully.";
        }

        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Creates new $visit_type appointment. ID#". $conn->insert_id ."')");
        
        if($visit_type == 'appointment'){
            $appointmentDate = date('Y-m-d', strtotime($appointment_datetime));
            $appointmentTime = date('h:i A', strtotime($appointment_datetime)); // 12-hour format with AM/PM

            // Send email to the user
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = 'smtp.gmail.com';
                $mail->Username = 'easternvdcc@gmail.com';
                $mail->Password = 'ugmpqofzgnulglmv';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('easternvdcc@gmail.com', 'EVDCC Team');
                $mail->addAddress($this_pet['email'], $this_pet['username']);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Appointment Confirmation';
                $mail->Body    = "
                Dear " . $this_pet['username'] . ",<br><br>

                Thank you for scheduling an appointment with us. Here are your appointment details:<br><br>

                <strong>Owner Information:</strong><br>
                Full Name: " . $this_pet['username'] . "<br>
                Email: " . $this_pet['email'] . "<br>
                Number: " . $this_pet['contact_number'] . "<br>
                Address: $address<br><br>

                <strong>Pet Information:</strong><br>
                Pet Name: " . $this_pet['name'] . "<br>
                Pet Type: " . $this_pet['pet_type'] . "<br>
                Pet Gender: " . $this_pet['gender'] . "<br>
                DOB: " . $this_pet['birthday'] . "<br>
                Service Needed: $service_needed<br><br>

                <strong>Payment Information:</strong><br>
                Payment Method: $payment<br>
                Payment Number: $payment_number<br>
                Reference Number: $reference<br>
                Price: $price<br><br>

                <strong>Appointment Date and Time:</strong><br>
                Date: $appointmentDate<br>
                Time: $appointmentTime<br><br>

                We look forward to serving you!<br><br>

                Best regards,<br>
                The EVDCC Team
                ";

                $mail->send();

                // Set success message in session
                $_SESSION['message'] = 'New appointment recorded successfully. An email has been sent to you.';
            } catch (Exception $e) {
                $_SESSION['message'] = "New appointment recorded successfully, but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        $stmt->close();

        header("location: pet-details.php?id=$pet_id");
        exit();
    }

    if (isset($_GET['method']) && $_GET['method'] == "delete_appointment_pet") {
        $conn->query("DELETE FROM `appointment` WHERE id=" . $_GET['appointment_id']);
        header("location: pet-details.php?id=$pet_id");
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
                    <span class="material-icons-outlined mr-1 text-muted">description</span>
                    <strong class="mt-1"><span class="text-muted">Pet Records •</span> Show Details</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-outline-tabs card-danger rounded-0">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs small" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active d-flex align-content-center" id="custom-tabs-four-details-tab" data-toggle="pill" href="#custom-tabs-four-details" role="tab" aria-controls="custom-tabs-four-details" aria-selected="true">
                                <span class="material-icons-outlined mr-1" style="font-size: 18px">info</span>
                                Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-content-center" id="custom-tabs-four-medical-history-tab" data-toggle="pill" href="#custom-tabs-four-medical-history" role="tab" aria-controls="custom-tabs-four-medical-history" aria-selected="false">
                                <span class="material-icons-outlined mr-1" style="font-size: 18px">medical_services</span>
                                Medical Records
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-content-center" id="custom-tabs-four-medicine-history-tab" data-toggle="pill" href="#custom-tabs-four-medicine-history" role="tab" aria-controls="custom-tabs-four-medicine-history" aria-selected="false">
                                <span class="material-icons-outlined mr-1" style="font-size: 18px">vaccines</span>
                                Medicine History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-content-center" id="custom-tabs-four-appointment-tab" data-toggle="pill" href="#custom-tabs-four-appointment" role="tab" aria-controls="custom-tabs-four-appointment" aria-selected="false">
                                <span class="material-icons-outlined mr-1" style="font-size: 18px">event</span>
                                Appointments
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-details" role="tabpanel" aria-labelledby="custom-tabs-four-details-tab">
                            <img src="../../assets/uploaded-images/<?= $this_pet['ppp']; ?>" class="mb-3" height="150" alt="">    

                            <form action="?id=<?= $pet_id; ?>&method=edit_pet_details" method="POST" onsubmit="showLoaderAnimation()" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <label class="small">Name <span class="text-danger">*</span></label>

                                        <div class="input-group mb-2">
                                            <input disabled value="<?= $this_pet['name']; ?>" type="text" class="form-control form-control-sm" required name="name" placeholder="Name">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="material-icons-outlined" style="font-size: 15px;">pets</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Microchip No./Identification No. <span class="text-danger">*</span></label>

                                        <div class="input-group mb-2">
                                            <input disabled value="<?= $this_pet['microchip_no']; ?>" type="text" class="form-control form-control-sm" required name="mi_no" placeholder="Microchip No./Identification No.">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="material-icons-outlined" style="font-size: 15px;">tag</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Breed <span class="text-danger">*</span></label>

                                        <div class="input-group mb-2">
                                            <input disabled value="<?= $this_pet['breed']; ?>" type="text" class="form-control form-control-sm" required name="breed" placeholder="Breed">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="material-icons-outlined" style="font-size: 15px;">pets</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Color/Markings <span class="text-danger">*</span></label>

                                        <div class="input-group mb-2">
                                            <input disabled value="<?= $this_pet['markings']; ?>" type="text" class="form-control form-control-sm" required name="markings" placeholder="Color/Markings">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="material-icons-outlined" style="font-size: 15px;">pets</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Spayed/Neutered <span class="text-danger">*</span></label>

                                        <select required disabled name="spayed_neutered" class="select form-control form-control-sm">
                                            <option <?= $this_pet['spayed_neutered'] == "1" ? 'selected' : '' ?> value="Yes">Yes</option>
                                            <option <?= $this_pet['spayed_neutered'] == "0" ? 'selected' : '' ?> value="No">No</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Date of Birth <span class="text-danger">*</span></label>

                                        <div class="input-group mb-2">
                                            <input disabled value="<?= $this_pet['birthday']; ?>" type="date" class="form-control form-control-sm" required name="birthday">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="material-icons-outlined" style="font-size: 15px;">date_range</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Pet Type <span class="text-danger">*</span></label>

                                        <select disabled required name="pet_type" class="select form-control form-control-sm">
                                            <option <?= $this_pet['pet_type'] == "Dog" ? 'selected' : '' ?> value="Dog">Dog</option>
                                            <option <?= $this_pet['pet_type'] == "Cat" ? 'selected' : '' ?> value="Cat">Cat</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Gender <span class="text-danger">*</span></label>

                                        <select disabled required name="gender" class="select form-control form-control-sm">
                                            <option <?= $this_pet['gender'] == "Male" ? 'selected' : '' ?> value="Male">Male</option>
                                            <option <?= $this_pet['gender'] == "Female" ? 'selected' : '' ?> value="Female">Female</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-12 my-2">
                                        <label class="small">Health Notes <span class="text-danger">*</span></label>
                                        <textarea disabled value="<?= $this_pet['health_notes']; ?>" class="form-control form-control-sm" required name="health_notes" rows="3" placeholder="Enter ..."><?= $this_pet['health_notes']; ?></textarea>
                                    </div>

                                    <div class="col-xl-12">
                                        <a href="pet-records.php" class="btn btn-light border btn-sm">
                                            <span class="fas fa-arrow-left pr-1"></span>
                                            Return to List
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-four-medical-history" role="tabpanel" aria-labelledby="custom-tabs-four-medical-history-tab">
                            <table class="table table-sm table-bordered table-striped data-table small">
                                <thead>
                                    <tr>
                                        <th class="text-bold">ID#</th>
                                        <th class="text-bold">Date</th>
                                        <th class="text-bold">Service</th>
                                        <th class="text-bold">View</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while($a = $medical_records->fetch_assoc()): ?>
                                        <tr>
                                            <td style="padding-top: 10px"><?= $a['pmid']; ?></td>
                                            <td style="padding-top: 10px"><?= date("F d, Y h:i A", strtotime($a['created_at'])); ?></td>
                                            <td style="padding-top: 10px"><?= $a['service']; ?></td>
                                            <td>
                                                <button data-toggle="modal" data-target="#medical_history_<?= $a['pmid']; ?>" class="btn btn-sm btn-light border small">
                                                    <span class="fas fa-eye mr-1 text-success"></span> View
                                                </button>
                                            </td>

                                            <?php include 'pet-medical-history-modal.php'; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-four-medicine-history" role="tabpanel" aria-labelledby="custom-tabs-four-medicine-history-tab">
                            <table class="table table-sm table-bordered table-striped data-table small">
                                <thead>
                                    <tr>
                                        <th class="text-bold">ID#</th>
                                        <th class="text-bold">Name</th>
                                        <th class="text-bold">Dosage</th>
                                        <th class="text-bold">View</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while($a = $medicine_history->fetch_assoc()): ?>
                                        <tr>
                                            <td style="padding-top: 10px"><?= $a['pmid']; ?></td>
                                            <td style="padding-top: 10px"><?= $a['medicine_name']; ?></td>
                                            <td style="padding-top: 10px"><?= $a['dosage']; ?></td>
                                            <td>
                                                <button data-toggle="modal" data-target="#medicine_history_<?= $a['pmid']; ?>" class="btn btn-sm btn-light border small">
                                                    <span class="fas fa-eye mr-1 text-success"></span> View
                                                </button>
                                            </td>

                                            <?php include 'pet-medicine-history-modal.php'; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-four-appointment" role="tabpanel" aria-labelledby="custom-tabs-four-appointment-tab">
                            <button class="btn btn-light border btn-sm mb-4" data-target="#new_appointment" data-toggle="modal">
                                New Appointment
                                <i class="fas fa-plus text-danger ml-1"></i>
                            </button>

                            <?php include "new-appointment-modal.php"; ?>

                            <table class="table table-sm table-bordered table-striped data-table small">
                                <thead>
                                    <tr>
                                        <th class="text-bold">ID#</th>
                                        <th class="text-bold">Visit Type</th>
                                        <th class="text-bold">Date</th>
                                        <th class="text-bold">Service</th>
                                        <th class="text-bold">Status</th>
                                        <th class="text-bold">Remarks</th>
                                        <th class="text-bold">Remove</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        while($a = $appointments->fetch_array()) : 
                                            $status_color = ($a['status'] == "Pending") ? 'warning' : (($a['status'] == "Approved") ? 'success' : 'danger');
                                    ?>
                                        <tr>
                                            <td style="padding-top: 10px"><?= $a['id']; ?></td>
                                            <td style="padding-top: 10px"><?= $a['visit_type']; ?></td>
                                            <td style="padding-top: 10px"><?= $a['appointment_datetime']; ?></td>
                                            <td style="padding-top: 10px"><?= $a['service_needed']; ?></td>
                                            <td style="padding-top: 10px" class="text-center text-bold bg-<?= $status_color; ?>"><?= $a['status']; ?></td>
                                            <td style="padding-top: 10px"><?= $a['reason_for_declined'] ?? "N/A"; ?></td>
                                            <td>
                                                <button data-toggle="modal" data-target="#appointment_<?= $a['id']; ?>" class="btn btn-sm btn-light border small">
                                                    <span class="fas fa-eye mr-1 text-success"></span> View
                                                </button>

                                                <button onclick="deleteAppointment(<?= $pet_id; ?>, <?= $a['id']; ?>)" class="btn btn-sm btn-light border small">
                                                    <span class="fas fa-times mr-1 text-danger"></span> Remove
                                                </button>
                                            </td>

                                            <?php include 'pet-details-view-appointment-modal2.php'; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function deleteAppointment(pet_id, appointment_id){
        let ask = confirm("Are you sure you want to remove this appointment?");

        if(ask == true){
            window.location.href = "pet-details.php?id="+ pet_id +"&appointment_id="+ appointment_id +"&method=delete_appointment_pet";
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