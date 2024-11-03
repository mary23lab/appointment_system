<?php
    include 'session.php'; 

    // Initialize variables
    $petRegisterCount = 0;
    $appointmentCount = 0; // Initialize for total appointments count

    $user_id = $_SESSION['user_id'];

    // Fetch the number of registered pets for the logged-in user
    $petRegisterQuery = "SELECT COUNT(*) as count FROM pets WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $petRegisterQuery)) {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $petRegisterCount);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    } else {
        die('Query preparation failed: ' . mysqli_error($conn));
    }

    // Fetch the total number of appointments for the logged-in user
    $appointmentsQuery = "SELECT COUNT(*) as count FROM appointment WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $appointmentsQuery)) {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $appointmentCount);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    } else {
        die('Query preparation failed: ' . mysqli_error($conn));
    }

    mysqli_close($conn);
?>

<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">dashboard</span>
                    <strong class="mt-1">Dashboard</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <a href="pet-records.php">
                        <div class="card card-hover-zoom bg-danger">
                            <div class="card-body text-white text-center">
                                <span class="material-icons-outlined">pets</span>
                                <h5 class="text-bold">Pet Records</h5>
                                <?= $petRegisterCount ?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-6">
                    <a href="">
                        <div class="card card-hover-zoom bg-danger">
                            <div class="card-body text-white text-center">
                                <span class="material-icons-outlined">event</span>
                                <h5 class="text-bold">Appointment Records</h5>
                                <?= $appointmentCount ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include "../../footer.php"; ?>