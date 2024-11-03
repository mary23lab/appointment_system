<?php
    include 'session.php';

    $registrationSuccess = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $mi_no = $_POST['mi_no'];
        $breed = $_POST['breed'];
        $markings = $_POST['markings'];
        $spayed_neutered = $_POST['spayed_neutered'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $petType = $_POST['pet_type'];
        $healthNotes = $_POST['health_notes'];

        $profilePicture = $_FILES['profile_picture']['tmp_name'];
        $profilePicturePath = uniqid() . '-' . basename($_FILES['profile_picture']['name']);

        move_uploaded_file($profilePicture, '../../assets/uploaded-images/' . $profilePicturePath);

        $sql = "INSERT INTO pets (`user_id`, `microchip_no`, `profile_picture`, `name`, `gender`, `birthday`, `pet_type`, `breed`, `markings`, `spayed_neutered`, `health_notes`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'issssssssss', $userId, $mi_no, $profilePicturePath, $name, $gender, $birthday, $petType, $breed, $markings, $spayed_neutered, $healthNotes);
        
        if (!mysqli_stmt_execute($stmt)) {
            die("Error executing statement: " . mysqli_stmt_error($stmt));
        } else {
            $registrationSuccess = true;
        }

        mysqli_close($conn);
    }
?>

<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">pets</span>
                    <strong class="mt-1">Pet Register</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <?php if ($registrationSuccess): ?>
                <div class="alert alert-light text-bold small">Pets have been successfully registered!</div>
            <?php endif; ?>    

            <div class="card card-outline card-danger rounded-0">
                <div class="card-body">
                    <form method="POST" onsubmit="showLoaderAnimation()" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-6">
                                <label class="small">Name <span class="text-danger">*</span></label>

                                <div class="input-group mb-2">
                                    <input type="text" class="form-control form-control-sm" required name="name" placeholder="Name">
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
                                    <input type="text" class="form-control form-control-sm" required name="mi_no" placeholder="Microchip No./Identification No.">
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
                                    <input type="text" class="form-control form-control-sm" required name="breed" placeholder="Breed">
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
                                    <input type="text" class="form-control form-control-sm" required name="markings" placeholder="Color/Markings">
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
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="col-xl-6">
                                <label class="small">Date of Birth <span class="text-danger">*</span></label>

                                <div class="input-group mb-2">
                                    <input type="date" class="form-control form-control-sm" required name="birthday">
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
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                </select>
                            </div>

                            <div class="col-xl-6">
                                <label class="small">Gender <span class="text-danger">*</span></label>

                                <select required name="gender" class="select form-control form-control-sm">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="col-xl-12 my-2">
                                <label class="small">Health Notes <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-sm" required name="health_notes" rows="3" placeholder="Enter ..."></textarea>
                            </div>

                            <div class="col-xl-12 mb-3">
                                <label class="small">Profile Picture <span class="text-danger">*</span></label>

                                <div class="input-group mb-2">
                                    <input type="file" accept="image/*" class="form-control form-control-sm" required name="profile_picture">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-image"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <button type="submit" class="btn btn-danger btn-sm elevation-1">
                                    REGISTER PET
                                    <span class="fas fa-save pl-1"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include "../../footer.php"; ?>