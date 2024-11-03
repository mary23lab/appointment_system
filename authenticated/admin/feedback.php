<?php 
    include 'session.php'; 
    $feedback = $conn->query("SELECT * FROM feedback ORDER BY id DESC");

    if(isset($_GET['id'])){
        $feedback_id = $_GET['id'];

        $conn->query("DELETE FROM `feedback` WHERE `id`=$feedback_id");
        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Deletes a feedback. ID# $feedback_id')");
        header("location: feedback.php");
        exit();
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
                    <strong class="mt-1">Feedbacks</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger rounded-0">
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped data-table small">
                        <thead>
                            <tr>
                                <th class="text-bold">ID#</th>
                                <th class="text-bold">Email</th>
                                <th class="text-bold">Message</th>
                                <th class="text-bold">Date/Time</th>
                                <th class="text-bold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $feedback->fetch_array()) : ?>
                                <tr>
                                    <td style="padding-top: 10px"><?= $row['id']; ?></td>
                                    <td style="padding-top: 10px"><?= $row['email']; ?></td>
                                    <td style="padding-top: 10px"><?= $row['message']; ?></td>
                                    <td style="padding-top: 10px"><?= date("F d, Y h:i A", strtotime($row['submitted_at'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-light border small" data-toggle="modal" data-target="#feedback_<?= $row['id']; ?>">
                                            <span class="fas fa-eye mr-1 text-warning"></span> View
                                        </button>

                                        <button onclick="deleteFeedback(<?= $row['id']; ?>)" class="btn btn-sm btn-light border small">
                                            <span class="fas fa-times mr-1 text-danger"></span> Remove
                                        </button>
                                    </td>

                                    <?php include 'feedback-view-modal.php'; ?>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function deleteFeedback(feedback_id){
        let ask = confirm("Are you sure you want to remove this feedback?");

        if(ask == true){
            window.location.href = "feedback.php?delete=true&id=" + feedback_id;
        }
    }
</script>

<?php include "../../footer.php"; ?>