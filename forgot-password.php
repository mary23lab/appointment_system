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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the email from the form input
        $email = $_POST['email'];

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format";
            exit;
        }

        // Check if the email exists in the database
        $stmt0 = $conn->query("SELECT * FROM users WHERE email LIKE BINARY '$email'");

        if ($stmt0->num_rows > 0) {
            $stmt = $stmt0->fetch_assoc();

            // Generate a unique reset token
            $token = bin2hex(random_bytes(32));
            $userId = $stmt['id'];

            // Insert the token into the password_resets table
            $stmt2 = $conn->query("INSERT INTO password_resets (user_id, token) VALUES ('$userId', '$token')");

            // Prepare the password reset link
            $reset_link = "http://localhost/vet/reset-password.php?token=" . urlencode($token);

            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Update this to your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'easternvdcc@gmail.com'; // SMTP username
                $mail->Password = 'kfefkzlsebkdlahh'; // SMTP password (use app-specific password if using Gmail)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587; // TCP port to connect to

                //Recipients
                $mail->setFrom('easternvdcc@gmail.com', 'EVDCC Team');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Hello,<br><br>You requested a password reset. Click the link below to reset your password:<br><a href='" . htmlspecialchars($reset_link, ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($reset_link, ENT_QUOTES, 'UTF-8') . "</a><br><br>If you did not request a password reset, please ignore this email.";

                // Send the email
                $mail->send();
                echo "A password reset link has been sent to your email address.";
            } catch (Exception $e) {
                echo "Failed to send password reset email. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Email not found.";
        }

        // Close statement and connection
        $stmt0->close();
        $conn->close();
    }
?>

<?php include 'header.php'; ?>

<div class="login-page first-container">
    <div class="login-box">
        <div class="card card-outline rounded-0 card-dark text-dark mt-3 mb-4 elevation-4">
            <div class="card-body px-4">
                <p class="login-box-msg small">
                    <img src="assets/system-images/logo.png" class="mb-2" height="50" /><br>
                    <strong>Pet Plus</strong><br>
                    Forgot Password
                </p>

                <form method="POST" onsubmit="showLoaderAnimation()">
                    <div class="input-group mb-2">
                        <input type="email" class="form-control form-control-sm" name="email" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-at"></span>
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

                        <div class="col-12 mb-3">
                            <a href="index.php" type="button" class="btn btn-light border btn-sm btn-block">
                                Return to <b class="text-danger">Homepage</b>
                                <span class="fas fa-sign-in-alt pl-1"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>