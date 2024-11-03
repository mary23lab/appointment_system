<?php
    // Include session initialization and database connection
    include '../../db.php';
    session_start();

    // Initialize variables
    $userProfile = [
        'profile_picture' => 'default_profile.png',
        'username' => 'Guest'
    ];

    // Check if the user is logged in
    if (isset($_SESSION['admin_id'])) {
        $userId = $_SESSION['admin_id'];

        // Fetch user profile information based on user ID
        $userProfileSql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($userProfileSql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $userProfileResult = $stmt->get_result();
        $userProfile = $userProfileResult->fetch_assoc();

        // Set session variables for profile picture and username if not already set
        $_SESSION['profile_picture'] = $userProfile['profile_picture'] ?? 'default_profile.png';
        $_SESSION['username'] = $userProfile['username'] ?? 'Guest';
    } else {
        // Redirect to login page if not logged in
        header("Location: ../../index.php");
        exit();
    }