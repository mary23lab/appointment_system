<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Include PHPMailer classes
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    // Include database connection
    require_once 'db.php';

    // Start session
    session_start();

    // Check if token is provided in the URL
    if (!isset($_GET['token'])) {
        echo "Invalid request.";
        exit;
    }

    $token = $_GET['token'];

    // Validate the token
    $stmt = $conn->prepare("SELECT user_id FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
    } else {
        echo "Invalid or expired token.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate the passwords
        if (empty($new_password) || empty($confirm_password)) {
            echo "All fields are required.";
        } elseif ($new_password !== $confirm_password) {
            echo "Passwords do not match.";
        } elseif (strlen($new_password) < 6) {
            echo "Password must be at least 6 characters.";
        } else {
            $np = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the user's password in the database (no hashing)
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $np, $user_id);
            $stmt->execute();

            // Delete the token so it can't be reused
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();

            echo "Your password has been reset successfully. You can now <a href='index.php'>login</a>.";
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
?>

<?php include 'header.php'; ?>

<div class="login-page first-container">
    <div class="login-box">
        <div class="card card-outline rounded-0 card-dark text-dark mt-3 mb-4 elevation-4">
            <div class="card-body px-4">
                <p class="login-box-msg small">
                    <img src="assets/system-images/logo.png" class="mb-2" height="50" /><br>
                    <strong>Pet Plus</strong><br>
                    Reset Password
                </p>

                <form method="POST" onsubmit="showLoaderAnimation()">
                    <div class="input-group mb-2">
                        <input type="password" class="form-control form-control-sm" name="new_password" placeholder="New Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-2">
                        <input type="password" class="form-control form-control-sm" name="confirm_password" placeholder="Repeat Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-2">
                            <button type="submit" class="btn btn-danger btn-sm btn-block elevation-1">
                                SUBMIT
                                <span class="fas fa-send pl-1"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>