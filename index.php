<?php
    require 'db.php';

    $error_message = '';

    if (isset($_GET['login'])) {
        $username = $_POST['email'];
        $password = $_POST['password'];

        // Check if the username exists
        $usernameCheckSql = "SELECT * FROM users WHERE email LIKE BINARY ?";
        $stmt = $conn->prepare($usernameCheckSql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['username'] = $username; 

                $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES (". $user['id'] . ", 'Logged in account.')");

                switch ($user['role']) {
                    case 'administrator':
                        $_SESSION['admin_id'] = $user['id'];
                        header("Location: authenticated/admin/dashboard.php");
                        exit();
                        break;

                    case 'user':
                        $_SESSION['user_id'] = $user['id'];
                        header("Location: authenticated/user/dashboard.php");
                        exit();
                        break;

                    case 'receptionist':
                        $_SESSION['receptionist_id'] = $user['id'];
                        header("Location: authenticated/receptionist/appointments.php");
                        exit();
                        break;
                    
                    default:
                        # code...
                        break;
                }
            } else {
                $error_message = "Invalid password!";
            }
        } else {
            $error_message = "Invalid username!";
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

            <div class="col-xl-6">
                <?php if ($error_message): ?>
                    <div class="alert alert-danger small"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>

                <div class="card card-outline rounded-0 card-dark text-dark mt-3 mb-4 elevation-4">
                    <div class="card-body px-4">
                        <p class="login-box-msg small">
                            <img src="assets/system-images/logo.png" class="mb-2" height="50" /><br>
                            <strong>Pet Plus</strong><br>
                            Please login to get started!
                        </p>

                        <form action="index.php?login=true" method="POST" onsubmit="showLoaderAnimation()">
                            <div class="input-group mb-2">
                                <input type="email" class="form-control form-control-sm" name="email" placeholder="Email" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-at"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="password" class="form-control form-control-sm" name="password" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-key"></span>
                                    </div>
                                </div>
                            </div>

                            <p class="small">
                                <a href="forgot-password.php">I forgot my password</a>
                            </p>

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <button type="submit" name="login_button" class="btn btn-danger btn-sm btn-block elevation-1">
                                        LOGIN
                                        <span class="fas fa-sign-in-alt pl-1"></span>
                                    </button>
                                </div>

                                <div class="col-12 mb-3">
                                    <a href="registration.php" type="button" class="btn btn-light border btn-sm btn-block">
                                        Don't have an account? <b class="text-danger">Register Now!</b>
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