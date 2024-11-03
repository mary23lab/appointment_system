<?php include 'session.php'; ?>

<?php 
    $updateSuccess = null;

    if (isset($_GET['update_account'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $contact_number = $_POST['contact_number'];
        $password = "";
        $edit_profile_picture = "";

        if($_POST['password'] !== ""){
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        } else {
            $password = $userProfile['password'];
        }

        if($_FILES['profile_picture']['tmp_name'] !== ""){
            if($userProfile['profile_picture'] !== "default-profile-avatar.png"){
                unlink('../../assets/user-images/' . $userProfile['profile_picture']);
            }

            $profilePicture = $_FILES['profile_picture']['tmp_name'];
            $profilePicturePath = uniqid() . '-' . basename($_FILES['profile_picture']['name']);

            if (!move_uploaded_file($profilePicture, '../../assets/user-images/' . $profilePicturePath)) {
                die("Failed to move file " . $profilePicturePath);
            }

            $edit_profile_picture = $profilePicturePath;
        } else {
            $edit_profile_picture = $userProfile['profile_picture'];
        }

        $getIfEmailExistsFromOther = $conn->query("SELECT * FROM users WHERE email LIKE BINARY '$email' AND id != '$userId'");

        if($getIfEmailExistsFromOther->num_rows <= 0){
            if($conn->query("UPDATE users SET username='$username', email='$email', contact_number='$contact_number', password='$password', profile_picture='$edit_profile_picture' WHERE id='$userId'")){
                $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Updated profile information.')");
                $_SESSION['updateSuccess'] = true;
    
                header("location: my-account.php");
                exit();
            } else {
                die("Error occured.");
            }
        } else {
            die("Email already exists.");
        }
    }
?>

<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">manage_accounts</span>
                    <strong class="mt-1">My Account</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <?php if (isset($_SESSION['updateSuccess'])) { ?>
                <div class="alert alert-light text-bold small">Account has been updated successfully!</div>
            <?php unset($_SESSION['updateSuccess']); } ?>    

            <div class="card card-outline card-danger rounded-0">
                <div class="card-body">
                    <img src="../../assets/user-images/<?= $userProfile['profile_picture']; ?>" class="mb-3" height="150" alt="">    

                    <form method="POST" action="my-account.php?update_account=true" onsubmit="showLoaderAnimation()" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-6">
                                <label class="small">Username <span class="text-danger">*</span></label>

                                <div class="input-group mb-2">
                                    <input type="text" value="<?= $userProfile['username']; ?>" class="form-control form-control-sm" name="username" placeholder="Username" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <label class="small">Contact# <span class="text-danger">*</span></label>

                                <div class="input-group mb-2">
                                    <input type="number" value="<?= $userProfile['contact_number']; ?>" class="form-control form-control-sm" name="contact_number" placeholder="Contact#" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-phone"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <label class="small">Email <span class="text-danger">*</span></label>

                                <div class="input-group mb-2">
                                    <input type="email" value="<?= $userProfile['email']; ?>" class="form-control form-control-sm" name="email" placeholder="Email" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-at"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <label class="small">New Password</label>

                                <div class="input-group mb-2">
                                    <input type="password" class="form-control form-control-sm" name="password" placeholder="Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-key"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
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

                            <div class="col-xl-12 mt-3">
                                <button type="submit" class="btn btn-danger btn-sm elevation-1">
                                    SAVE CHANGES
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