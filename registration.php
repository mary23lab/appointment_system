<?php 
    include 'db.php'; // Include your database connection

    $error_message = '';
    $profilePicturePath = ''; // Initialize variable for profile picture path
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = "user";
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
        // Handle the profile picture upload
        $profilePictureName = $_FILES['profile_picture']['name'];
        $profilePictureTmpName = $_FILES['profile_picture']['tmp_name'];
        $profilePictureSize = $_FILES['profile_picture']['size'];
        $profilePictureError = $_FILES['profile_picture']['error'];
        $profilePictureType = $_FILES['profile_picture']['type'];
    
        // Define allowed file types and max size (e.g., 5MB)
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($profilePictureName, PATHINFO_EXTENSION));
    
        if (in_array($fileExtension, $allowedTypes) && $profilePictureError === 0 && $profilePictureSize <= 5000000) {
            // Generate a unique name for the picture and move it to the uploads folder
            $profilePictureNewName = uniqid('', true) . "." . $fileExtension;
            $profilePictureDestination = 'assets/user-images/' . $profilePictureNewName;
            move_uploaded_file($profilePictureTmpName, $profilePictureDestination);
    
            // Insert the user data into the database, including the profile picture name
            $sql = "INSERT INTO users (username, email, password, profile_picture, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $username, $email, $password, $profilePictureNewName, $role);
    
            if ($stmt->execute()) {
                header("Location: index.php");
                exit(); // Ensure no further code is executed
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        } else {
            $error_message = "There was an error uploading your profile picture. Please make sure it is a valid file type and size.";
        }
    }
?>

<?php include 'header.php'; ?>
<?php include 'homepage-navbar.php'; ?>

<div class="login-page first-container">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 px-2 pt-2">
                <h1 class="text-bold" style="font-family: Lobster">Welcome to Pet Plus - Where Your Pets Feel at Home!</h1>
                Expert care for your furry friends.
            </div>

            <?php if ($error_message): ?>
                <div class="alert alert-danger small"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <div class="col-xl-6">
                <div class="card card-outline rounded-0 card-dark text-dark mt-3 mb-4 elevation-4">
                    <div class="card-body px-4">
                        <p class="login-box-msg small">
                            <img src="assets/system-images/logo.png" class="mb-2" height="50" /><br>
                            <strong>Pet Plus</strong><br>
                            Create Your Account
                        </p>

                        <form method="POST" onsubmit="showLoaderAnimation()" enctype="multipart/form-data">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control form-control-sm" name="username" placeholder="Username" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-2">
                                <input type="email" class="form-control form-control-sm" name="email" placeholder="Email" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-at"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-2">
                                <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-key"></span>
                                    </div>
                                </div>
                            </div>

                            <label class="small">Add Profile Picture *</label>

                            <div class="input-group mb-3">
                                <input type="file" accept="image/*" class="form-control form-control-sm" name="profile_picture" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-image"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <button type="submit" class="btn btn-danger btn-sm btn-block elevation-1">
                                        REGISTER
                                        <span class="fas fa-save pl-1"></span>
                                    </button>
                                </div>

                                <div class="col-12 mb-3">
                                    <a href="index.php" type="button" class="btn btn-light border btn-sm btn-block">
                                        Already have an account? <b class="text-danger">Login Now!</b>
                                        <span class="fas fa-sign-in-alt pl-1"></span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-light" id="services">
    <div class="container">
		<div class="row">
            <div class="col-xl-12 text-center mb-5">
                <h3 class="text-bold" style="font-family: Lobster">OUR SERVICES</h3>
            </div>

            <div class="col-xl-6">
                <div class="card card-outline card-hover-zoom card-dark rounded-0 elevation-4">
                    <div class="card-body text-center text-dark">
                        <img src="assets/system-images/grooming.jpg" class="mb-3" height="100" /><br>

                        <strong>Grooming</strong><br>
                        Keep your pets looking their best.
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card card-outline card-hover-zoom card-dark rounded-0 elevation-4">
                    <div class="card-body text-center text-dark">
                        <img src="assets/system-images/laboratory.png" class="mb-3" height="100" /><br>

                        <strong>Laboratory</strong><br>
                        Comprehensive lab tests for accurate diagnosis.
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card card-outline card-hover-zoom card-dark rounded-0 elevation-4">
                    <div class="card-body text-center text-dark">
                        <img src="assets/system-images/consultations.png" class="mb-3" height="100" /><br>

                        <strong>Consultations</strong><br>
                        Professional advice and consultations for your pets.
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card card-outline card-hover-zoom card-dark rounded-0 elevation-4">
                    <div class="card-body text-center text-dark">
                        <img src="assets/system-images/anti.jpg" class="mb-3" height="100" /><br>

                        <strong>Anti-Rabies</strong><br>
                        Protect your pets with our anti-rabies services.
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex align-content-center justify-content-center">
            <div class="col-xl-6">
                <div class="card card-outline card-hover-zoom card-dark rounded-0 elevation-4">
                    <div class="card-body text-center text-dark">
                        <img src="assets/system-images/deworm.jpg" class="mb-3" height="100" /><br>

                        <strong>Deworming</strong><br>
                        Ensuring timely deworming can lead to healthier lives and improved well-being.
                    </div>
                </div>
            </div>
        </div>
    </div>   
</div>

<div class="py-5 bg-danger" id="about-us">
    <div class="container">
		<div class="row">
            <div class="col-xl-12 text-center mb-5">
                <h3 class="text-bold" style="font-family: Lobster">ABOUT US</h3>
            </div>

            <div class="col-xl-5 pr-4 pt-3 text-bold h1">
                We are committed to providing the best care for your pets. Our experienced team offers a range of services designed to keep your pets healthy and happy.
            </div>

            <div class="col-xl-7">
                <img src="assets/system-images/team.jpg" class="mb-2 elevation-3 rounded" height="400" style="width: 100%" />
            </div>
        </div>
    </div>   
</div>
<?php include 'footer.php'; ?>