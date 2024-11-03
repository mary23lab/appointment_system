<?php include 'session.php'; ?> 

<?php 
    $complaints = $conn->query("SELECT * FROM messages WHERE user_id = '$userId' ORDER BY id DESC");

    if(isset($_GET['delete'])){
        $conn->query("DELETE FROM `messages` WHERE `id`=" . $_GET['id']);
        header("location: complaints.php");
        exit();
    }

    if(isset($_GET['update'])){
        $complaint = $_POST['complaint'];
        $message = $_POST['message'];

        $conn->query("UPDATE `messages` SET `category`='$complaint', `message`='$message' WHERE `id`=" . $_GET['id']);
        header("location: complaints.php");
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
                    <strong class="mt-1">Complaints</strong>
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
                                <th class="text-bold">Status</th>
                                <th class="text-bold">Category</th>
                                <th class="text-bold">Date/Time</th>
                                <th class="text-bold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $complaints->fetch_array()) : ?>
                                <tr>
                                    <td style="padding-top: 10px"><?= $row['id']; ?></td>
                                    <td style="padding-top: 10px" class="text-center text-bold bg-<?= $row['status'] == "Pending" ? 'warning' : 'success'; ?>"><?= $row['status']; ?></td>
                                    <td style="padding-top: 10px"><?= $row['category']; ?></td>
                                    <td style="padding-top: 10px"><?= $row['submitted_at']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-light border small" data-toggle="modal" data-target="#complaint_<?= $row['id']; ?>">
                                            <span class="fas fa-eye mr-1 text-warning"></span> View
                                        </button>

                                        <button onclick="deleteComplaint(<?= $row['id']; ?>)" class="btn btn-sm btn-light border small">
                                            <span class="fas fa-times mr-1 text-danger"></span> Remove
                                        </button>
                                    </td>

                                    <?php include 'complaint-view-modal.php'; ?>
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
    function deleteComplaint(complaint_id){
        let ask = confirm("Are you sure you want to remove this complaint?");

        if(ask == true){
            window.location.href = "complaints.php?delete=true&id=" + complaint_id;
        }
    }
</script>

<?php include "../../footer.php"; ?>