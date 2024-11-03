<?php
    include 'session.php';

    $registrationSuccess = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $complaint = $_POST['complaint'];
        $message = $_POST['message'];
        
        $conn->query("INSERT INTO messages (user_id, message, status, category) VALUES ('$userId', '$message', 'Pending', '$complaint')");
        $registrationSuccess = true;

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
                    <span class="material-icons-outlined mr-1 text-muted">report</span>
                    <strong class="mt-1">New Complaint</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <?php if ($registrationSuccess): ?>
                <div class="alert alert-light text-bold small">Complaint have been submitted successfully!</div>
            <?php endif; ?>    

            <div class="card card-outline card-danger rounded-0">
                <div class="card-body">
                    <form method="POST" onsubmit="showLoaderAnimation()" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-6 mb-2">
                                <label class="small">Category <span class="text-danger">*</span></label>

                                <select required name="complaint" class="select form-control form-control-sm">
                                    <option value="Complaint">Complaint</option>
                                    <option value="Report">Report</option>
                                </select>
                            </div>

                            <div class="col-xl-12 mb-3">
                                <label class="small">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-sm" required name="message" rows="3" placeholder="Enter ..."></textarea>
                            </div>

                            <div class="col-xl-12">
                                <button type="submit" class="btn btn-danger btn-sm elevation-1">
                                    SUBMIT COMPLAINT
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