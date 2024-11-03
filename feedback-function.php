<?php
    require_once "db.php";

    if(isset($_POST['feedback'])){
        $email = $_POST['email'] ?? null;
        $feedback = $_POST['feedback'];

        $insert = $conn->query("INSERT INTO feedback (`message`, `email`) VALUES ('$feedback', '$email')");

        if($insert){
            echo "Feedback sent successfully! ";
        } else {
            echo "Feedback not sent successfully! ";
        }

        echo "<a href='index.php'>Return to Homepage</a>";
    }