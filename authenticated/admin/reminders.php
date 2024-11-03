<?php
    include "session.php";

    // Include PHPMailer classes
    require '../../PHPMailer/src/Exception.php';
    require '../../PHPMailer/src/PHPMailer.php';
    require '../../PHPMailer/src/SMTP.php';

    // Use PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $message = "";

    // Function to send email
    function sendReminder($email, $appointment_datetime) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'easternvdcc@gmail.com'; // Your email
            $mail->Password = 'kfefkzlsebkdlahh'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('easternvdcc@gmail.com', 'EVDCC');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Appointment Reminder';
            $mail->Body    = "This is a reminder that you have an appointment scheduled for <strong>{$appointment_datetime}</strong>.";

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Get current date and date for one day ahead
    $today = date('Y-m-d');
    $reminder_date = date('Y-m-d', strtotime($today . ' +1 day'));

    // Query to find appointments for tomorrow
    $sql = "SELECT * FROM appointment INNER JOIN users ON appointment.user_id = users.id WHERE DATE(appointment.appointment_datetime) = '$reminder_date'";
    $result = $conn->query($sql);

    if ($result === false) {
        die("SQL Error: " . $conn->error);
    } else if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            sendReminder($row['email'], $row['appointment_datetime']);
        }

        $message = "Reminders sent successfully.";
    } else {
        $message = "No appointments for tomorrow.";
    }

    $conn->close();
?>

<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">notifications</span>
                    <strong class="mt-1">Reminders</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger rounded-0">
                <div class="card-body pb-3">
                    <h3 class="text-bold "><?= $message; ?></h3>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include "../../footer.php"; ?>