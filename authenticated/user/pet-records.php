<?php
    include 'session.php';  

    // Handle pet deletion
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $pet_id = $_GET['id'];

        // DELETE THE SAVED IMAGE IN UPLOADED IMAGES TOO
        $this_pet = $conn->query("SELECT * FROM pets WHERE id=" . $_GET['id'])->fetch_assoc();
        unlink('../../assets/uploaded-images/' . $this_pet['profile_picture']);

        $query = "DELETE FROM pets WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param('ii', $pet_id, $userId);
        $executeResult = $stmt->execute();
        $stmt->close();

        header("Location: pet-records.php");
        exit();
    }

    // Fetch pets
    $petQuery = "SELECT * FROM pets WHERE user_id = ?";
    $stmt = $conn->prepare($petQuery);

    if (!$stmt) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('i', $userId);
    $executeResult = $stmt->execute();

    if (!$executeResult) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $petResult = $stmt->get_result();

    if (!$petResult) {
        die('Fetch failed: ' . htmlspecialchars($conn->error));
    }

    // Initialize the success message variable
    if (isset($_SESSION['success_message'])) {
        $success_message = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    } else {
        $success_message = '';
    }
?>

<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">pets</span>
                    <strong class="mt-1">Pet Records</strong>
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
                                <th class="text-bold">Avatar</th>
                                <th class="text-bold">Name</th>
                                <th class="text-bold">Gender</th>
                                <th class="text-bold">DOB</th>
                                <th class="text-bold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $petResult->fetch_assoc()) : ?>
                                <tr>
                                    <td style="padding-top: 10px"><?= $row['id']; ?></td>
                                    <td><img src="../../assets/uploaded-images/<?= $row['profile_picture']; ?>" alt="" class="rounded-circle" height="30" width="30"></td>
                                    <td style="padding-top: 10px"><?= ucfirst($row['name']); ?></td>
                                    <td style="padding-top: 10px"><?= $row['gender']; ?></td>
                                    <td style="padding-top: 10px"><?= $row['birthday']; ?></td>
                                    <td>
                                        <a href="pet-details.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-light border small">
                                            <span class="fas fa-info mr-1 text-warning"></span> Show Details
                                        </a>

                                        <button onclick="deletePet(<?= $row['id']; ?>)" class="btn btn-sm btn-light border small">
                                            <span class="fas fa-times mr-1 text-danger"></span> Remove
                                        </button>
                                    </td>
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
    function deletePet(pet_id){
        let ask = confirm("Are you sure you want to remove this pet?");

        if(ask == true){
            window.location.href = "pet-records.php?action=delete&id=" + pet_id;
        }
    }
</script>

<?php include "../../footer.php"; ?>