<?php 
    include 'session.php';  
    $petResult = $conn->query("SELECT pets.*, users.*, pets.id AS pid, pets.profile_picture AS ppp FROM pets INNER JOIN users ON pets.user_id = users.id");

    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $pet_id = $_GET['id'];

        // DELETE THE SAVED IMAGE IN UPLOADED IMAGES TOO
        $this_pet = $conn->query("SELECT * FROM pets WHERE id=" . $pet_id)->fetch_assoc();
        unlink('../../assets/uploaded-images/' . $this_pet['profile_picture']);

        $query = "DELETE FROM pets WHERE id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param('i', $pet_id);
        $executeResult = $stmt->execute();
        $stmt->close();

        header("Location: pet-records.php");
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
                                <th class="text-bold">Owner</th>
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
                                    <td style="padding-top: 10px"><?= $row['pid']; ?></td>
                                    <td style="padding-top: 10px"><?= $row['username']; ?></td>
                                    <td><img src="../../assets/uploaded-images/<?= $row['ppp']; ?>" alt="" class="rounded-circle" height="30" width="30"></td>
                                    <td style="padding-top: 10px"><?= ucfirst($row['name']); ?></td>
                                    <td style="padding-top: 10px"><?= $row['gender']; ?></td>
                                    <td style="padding-top: 10px"><?= $row['birthday']; ?></td>
                                    <td>
                                        <a href="pet-details.php?id=<?= $row['pid']; ?>" class="btn btn-sm btn-light border small">
                                            <span class="fas fa-info mr-1 text-warning"></span> Show Details
                                        </a>

                                        <button onclick="deletePet(<?= $row['pid']; ?>)" class="btn btn-sm btn-light border small">
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