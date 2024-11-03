<?php include 'session.php'; ?> 

<?php 
    $recepient = $_GET['id'];
    $from = $_GET['id'];
    $messages = $conn->query("SELECT `chat_messages`.*, `users`.*, `chat_messages`.`id` AS cmid FROM `chat_messages` INNER JOIN `users` ON `chat_messages`.`user_id` = `users`.`id` WHERE `chat_messages`.`user_id`=$recepient ORDER BY `chat_messages`.`created_at` ASC");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = $_POST['message'];
        $image = null;

        if($message !== "" || $_FILES['image']['tmp_name'] !== ""){
            if($_FILES['image']['tmp_name'] !== ""){
                $profilePicture = $_FILES['image']['tmp_name'];
                $profilePicturePath = uniqid() . '-' . basename($_FILES['image']['name']);
                move_uploaded_file($profilePicture, '../../assets/uploaded-images/' . $profilePicturePath);
                $image = $profilePicturePath;
            }
            
            $conn->query("INSERT INTO chat_messages (user_id, message, sender, image_path) VALUES ('$from', '$message', '$userId', '$image')");
            mysqli_close($conn);
        }

        header('location: chats-details.php?id=' . $recepient);
    }

    if(isset($_GET['method']) && $_GET['method'] == "delete_chat"){
        $id_to_be_deleted = $_GET['cmid'];
        $conn->query("DELETE FROM `chat_messages` WHERE `id`=$id_to_be_deleted");
        header("location: chats-details.php?id=$recepient&from=$from");
        die();
    }
?>


<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">chat</span>
                    <strong class="mt-1">Chats</strong>
                </div>
            </div>
        </div>
    </section> 

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-danger rounded-0">
                <div class="card-body">
                    <div class="bg-light border p-3" id="myDiv" style="min-height: 20px; max-height: 450px; overflow-y: auto">
                        <?php while($m = $messages->fetch_array()) : ?>
                            <?php if ($m['sender'] != $userId): ?>
                                <div class="row mb-3">
                                    <div class="col-xl-6">
                                        <small class="text-bold"><?= $m['username']; ?></small>

                                        <div class="card small my-2 bg-white card-white" style="width: fit-content !important">
                                            <div class="card-body">
                                                <div class="w-100"><?= $m['message']; ?></div>

                                                <?php if($m['image_path']): ?>
                                                    <img src="../../assets/uploaded-images/<?= $m['image_path'] ?>" class="mt-2" height="130" alt="">
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="w-100 small"><?= date("F, d Y h:i A", strtotime($m['created_at'])); ?></div>
                                    </div>

                                    <div class="col-xl-6"></div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($m['sender'] == $userId) : ?>
                                <div class="row mb-3">
                                    <div class="col-xl-6"></div>
                                    <div class="col-xl-6">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <a href="chats-details.php?id=<?= $recepient; ?>&from=<?= $from; ?>&method=delete_chat&cmid=<?= $m['cmid']; ?>">
                                                <span class="material-icons-outlined text-danger mr-2">delete</span>
                                            </a>
                                            <div class="card small mb-1 bg-danger card-danger" style="width: fit-content !important">
                                                <div class="card-body">
                                                    <div class="w-100"><?= $m['message']; ?></div>

                                                    <?php if($m['image_path']): ?>
                                                        <img src="../../assets/uploaded-images/<?= $m['image_path'] ?>" height="130" class="mt-2" alt="">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right small"><?= date("F, d Y h:i A", strtotime($m['created_at'])); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>

                    <form method="POST" onsubmit="showLoaderAnimation()" enctype="multipart/form-data">
                        <div class="row mt-2">
                            <div class="col-xl-10">
                                <input type="file" accept="image/*" id="image" name="image" style="display: none">
                                <textarea class="form-control form-control-sm" name="message" rows="3" placeholder="Aa.."></textarea>
                            </div>

                            <div class="col-xl-2">
                                <button type="button" onclick="document.getElementById('image').click()" class="btn btn-default btn-sm">
                                    <span class="material-icons-outlined text-danger mt-1">image</span>
                                </button>

                                <button type="submit" class="btn btn-danger btn-sm px-4">
                                    <span class="material-icons-outlined mt-1">send</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    setTimeout(() => {
  const div = document.getElementById('myDiv');
  div.scrollTop = div.scrollHeight - div.clientHeight;
}, 100);
</script>

<?php include "../../footer.php"; ?>