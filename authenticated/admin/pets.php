<?php
    include 'session.php'; 

    $pets = $conn->query("SELECT pets.*, users.*, pets.profile_picture AS ppp, pets.id AS pid FROM pets INNER JOIN users ON pets.user_id = users.id ORDER BY pets.id DESC");

    if(isset($_GET['delete_pet_id'])){
        $pet_delete_id = $_GET['delete_pet_id'];

        $conn->query("DELETE FROM `pets` WHERE id=$pet_delete_id");
        $conn->query("INSERT INTO `audit_trail` (`user_id`, `details`) VALUES ('$userId', 'Deletes a pet. ID# $pet_delete_id')");
        header("Location: pets.php");
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
                    <strong class="mt-1">Pets</strong>
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
                                <th class="text-bold">Image</th>
                                <th class="text-bold">Owner</th>
                                <th class="text-bold">Pet</th>
                                <th class="text-bold">Type</th>
                                <th class="text-bold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($a = $pets->fetch_array()) : ?>
                                <tr>
                                    <td style="padding-top: 10px"><?= $a['pid']; ?></td>
                                    <td>
                                        <img src="../../assets/uploaded-images/<?= $a['ppp']; ?>" height="30" width="30" class="img-circle" alt="">
                                    </td>
                                    <td style="padding-top: 10px"><?= $a['username']; ?></td>
                                    <td style="padding-top: 10px"><?= $a['name']; ?></td>
                                    <td style="padding-top: 10px"><?= $a['pet_type']; ?></td>
                                    <td style="padding-top: 8px">
                                        <a href="pet-details.php?id=<?= $a['pid']; ?>">
                                            <span class="material-icons-outlined mr-1 text-warning">info</span>
                                        </a>

                                        <a href="#" onclick="deletePet(<?= $a['pid']; ?>)">
                                            <span class="material-icons-outlined text-danger">delete</span>
                                        </a>
                                    </td>

                                    <?php include 'appointment-update-modal.php'; ?>
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
            window.location.href = "pets.php?delete_pet_id=" + pet_id;
        }
    }
</script>

<?php include "../../footer.php"; ?>