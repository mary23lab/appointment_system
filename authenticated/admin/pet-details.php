<?php
    include 'session.php'; 

    $pet_id = $_GET['id'];
    
    $this_pet = $conn->query("SELECT pets.*, users.*, pets.profile_picture AS ppp FROM pets INNER JOIN users ON pets.user_id = users.id WHERE pets.id=$pet_id")->fetch_assoc(); 
    $medical_records = $conn->query("SELECT `pet_med_history`.*, `pet_diseases`.*, `pet_med_history`.`id` AS pmid FROM `pet_med_history` LEFT JOIN `pet_diseases` ON `pet_med_history`.`disease_diagnosed` = `pet_diseases`.`id` WHERE `pet_med_history`.`pet_id`=$pet_id ORDER BY `pet_med_history`.`id` DESC");
    $medicine_history = $conn->query("SELECT `pet_medicine_history`.*, `pet_medicine_history`.`id` AS pmid FROM `pet_medicine_history` WHERE `pet_medicine_history`.`pet_id`=$pet_id ORDER BY `pet_medicine_history`.`id` DESC");
    $diseases = $conn->query("SELECT * FROM `pet_diseases`");

    if (isset($_GET['method']) && $_GET['method'] == "edit_pet_details") {
        $edit_name = $_POST['name'];
        $edit_type = $_POST['pet_type'];
        $edit_gender = $_POST['gender'];
        $edit_birthday = $_POST['birthday'];
        $edit_health_notes = $_POST['health_notes'];
        $edit_profile_picture = "";

        if($_FILES['profile_picture']['tmp_name'] !== ""){
            unlink('../../assets/uploaded-images/' . $this_pet['profile_picture']);

            $profilePicture = $_FILES['profile_picture']['tmp_name'];
            $profilePicturePath = uniqid() . '-' . basename($_FILES['profile_picture']['name']);

            if (!move_uploaded_file($profilePicture, '../../assets/uploaded-images/' . $profilePicturePath)) {
                die("Failed to move file " . $profilePicturePath);
            }

            $edit_profile_picture = $profilePicturePath;
        } else {
            $edit_profile_picture = $this_pet['ppp'];
        }
    
        $query = "UPDATE pets SET name = ?, gender = ?, profile_picture = ?, pet_type = ?, birthday = ?, health_notes = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        $stmt->bind_param('ssssssi', $edit_name, $edit_gender, $edit_profile_picture, $edit_type, $edit_birthday, $edit_health_notes, $pet_id);
        $executeResult = $stmt->execute();

        if (!$executeResult) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        $stmt->close();
    
        header("location: pet-details.php?id=" . $pet_id);
        exit();
    }

    if(isset($_GET['method']) && $_GET['method'] == "add_medical_record"){
        $service = $_POST['service'];
        $disease = $_POST['disease'] ?? 0;
        $treatment = $_POST['treatment'];
        $notes = $_POST['notes'];
        $date_of_visit = $_POST['date_of_visit'];
        $date_of_return = $_POST['date_of_return'];

        $conn->query("INSERT INTO `pet_med_history` (`pet_id`, `service`, `disease_diagnosed`, `treatment_given`, `notes`, `date_of_return`, `date_of_visit`) VALUES ('$pet_id', '$service', '$disease', '$treatment', '$notes', '$date_of_return', '$date_of_visit')");
        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Creates new medical history. ID#" . $conn->insert_id . "')");
        $conn->close();
        header("location: pet-details.php?id=$pet_id");
    }
    
    if(isset($_GET['method']) && $_GET['method'] == "add_medicine_history"){
        $medicine_name = $_POST['medicine_name'];
        $dosage = $_POST['dosage'];
        $route_of_administration = $_POST['route_of_administration'];
        $frequency = $_POST['frequency'];
        $duration = $_POST['duration'];
        $pet_weight = $_POST['pet_weight'];

        $conn->query("INSERT INTO `pet_medicine_history` (`pet_id`, `medicine_name`, `dosage`, `route_of_administration`, `frequency`, `duration`, `pet_weight`) VALUES ('$pet_id', '$medicine_name', '$dosage', '$route_of_administration', '$frequency', '$duration', '$pet_weight')");
        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Creates new medicine history. ID#" . $conn->insert_id ."')");
        $conn->close();
        header("location: pet-details.php?id=$pet_id");
    }

    if(isset($_GET['method']) && $_GET['method'] == "delete_medical_record"){
        $pmr_id = $_GET['pmr_id'];

        $conn->query("DELETE FROM `pet_med_history` WHERE id=".$pmr_id);
        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Deletes a pet medical record. ID# $pmr_id')");
        header("Location: pet-details.php?id=$pet_id");
        exit();
    }

    if(isset($_GET['method']) && $_GET['method'] == "delete_medicine_history"){
        $pmh_id = $_GET['pmh_id'];

        $conn->query("DELETE FROM `pet_medicine_history` WHERE id=".$pmh_id);
        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Deletes a pet medicine history. ID# $pmh_id')");
        header("Location: pet-details.php?id=$pet_id");
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
                                            <input value="<?= $this_pet['name']; ?>" type="text" class="form-control form-control-sm" required name="name" placeholder="Name">
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
                                            <input value="<?= $this_pet['microchip_no']; ?>" type="text" class="form-control form-control-sm" required name="mi_no" placeholder="Microchip No./Identification No.">
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
                                            <input value="<?= $this_pet['breed']; ?>" type="text" class="form-control form-control-sm" required name="breed" placeholder="Breed">
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
                                            <input value="<?= $this_pet['markings']; ?>" type="text" class="form-control form-control-sm" required name="markings" placeholder="Color/Markings">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="material-icons-outlined" style="font-size: 15px;">pets</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Spayed/Neutered <span class="text-danger">*</span></label>

                                        <select required name="spayed_neutered" class="select form-control form-control-sm">
                                            <option <?= $this_pet['spayed_neutered'] == "1" ? 'selected' : '' ?> value="Yes">Yes</option>
                                            <option <?= $this_pet['spayed_neutered'] == "0" ? 'selected' : '' ?> value="No">No</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Date of Birth <span class="text-danger">*</span></label>

                                        <div class="input-group mb-2">
                                            <input value="<?= $this_pet['birthday']; ?>" type="date" class="form-control form-control-sm" required name="birthday">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="material-icons-outlined" style="font-size: 15px;">date_range</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Pet Type <span class="text-danger">*</span></label>

                                        <select required name="pet_type" class="select form-control form-control-sm">
                                            <option <?= $this_pet['pet_type'] == "Dog" ? 'selected' : '' ?> value="Dog">Dog</option>
                                            <option <?= $this_pet['pet_type'] == "Cat" ? 'selected' : '' ?> value="Cat">Cat</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-6">
                                        <label class="small">Gender <span class="text-danger">*</span></label>

                                        <select required name="gender" class="select form-control form-control-sm">
                                            <option <?= $this_pet['gender'] == "Male" ? 'selected' : '' ?> value="Male">Male</option>
                                            <option <?= $this_pet['gender'] == "Female" ? 'selected' : '' ?> value="Female">Female</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-12 my-2">
                                        <label class="small">Health Notes <span class="text-danger">*</span></label>
                                        <textarea value="<?= $this_pet['health_notes']; ?>" class="form-control form-control-sm" required name="health_notes" rows="3" placeholder="Enter ..."><?= $this_pet['health_notes']; ?></textarea>
                                    </div>

                                    <div class="col-xl-12 mb-3">
                                        <label class="small">New Profile Picture</label>

                                        <div class="input-group mb-2">
                                            <input type="file" accept="image/*" class="form-control form-control-sm" name="profile_picture">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-image"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <button type="submit" class="btn btn-danger btn-sm elevation-1">
                                            SAVE CHANGES
                                            <span class="fas fa-save pl-1"></span>
                                        </button>

                                        <a href="pets.php" class="btn btn-light border btn-sm">
                                            <span class="fas fa-arrow-left pr-1"></span>
                                            Return to List
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-four-medical-history" role="tabpanel" aria-labelledby="custom-tabs-four-medical-history-tab">
                            <button class="btn btn-light border btn-sm mb-4" data-target="#new_medical_record" data-toggle="modal">
                                New Record
                                <i class="fas fa-plus text-danger ml-1"></i>
                            </button>

                            <?php include "new-medical-record-modal.php"; ?>

                            <table class="table table-sm table-bordered table-striped data-table small">
                                <thead>
                                    <tr>
                                        <th class="text-bold">ID#</th>
                                        <th class="text-bold">Record Date</th>
                                        <th class="text-bold">Date Of Return</th>
                                        <th class="text-bold">Service</th>
                                        <th class="text-bold">View</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while($a = $medical_records->fetch_assoc()): ?>
                                        <tr>
                                            <td style="padding-top: 10px"><?= $a['pmid']; ?></td>
                                            <td style="padding-top: 10px"><?= date("F d, Y h:i A", strtotime($a['created_at'])); ?></td>
                                            <td style="padding-top: 10px"><?= $a['date_of_return'] ? date("F d, Y h:i A", strtotime($a['created_at'])) : 'N/A'; ?></td>
                                            <td style="padding-top: 10px"><?= $a['service']; ?></td>
                                            <td>
                                                <button data-toggle="modal" data-target="#medical_history_<?= $a['pmid']; ?>" class="btn btn-sm btn-light border small">
                                                    <span class="fas fa-eye mr-1 text-success"></span> View
                                                </button>

                                                <a href="/vet/authenticated/admin/pet-details.php?id=<?= $pet_id ?>&method=delete_medical_record&pmr_id=<?= $a['pmid']; ?>" class="btn btn-sm btn-light border small">
                                                    <span class="fas fa-trash text-danger"></span>
                                                </a>
                                            </td>

                                            <?php include 'pet-medical-history-modal.php'; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="custom-tabs-four-medicine-history" role="tabpanel" aria-labelledby="custom-tabs-four-medicine-history-tab">
                            <button class="btn btn-light border btn-sm mb-4" data-target="#new_medicine_record" data-toggle="modal">
                                New Medicine History
                                <i class="fas fa-plus text-danger ml-1"></i>
                            </button>

                            <?php include "new-medicine-record-modal.php"; ?>

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

                                                <a href="/vet/authenticated/admin/pet-details.php?id=<?= $pet_id ?>&method=delete_medicine_history&pmh_id=<?= $a['pmid']; ?>" class="btn btn-sm btn-light border small">
                                                    <span class="fas fa-trash text-danger"></span>
                                                </a>
                                            </td>

                                            <?php include 'pet-medicine-history-modal.php'; ?>
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

<?php include "../../footer.php"; ?>