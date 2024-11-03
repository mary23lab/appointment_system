<?php
    include 'session.php'; 

    $chats = $conn->query("SELECT chat_messages.*, users.* FROM chat_messages INNER JOIN users ON chat_messages.user_id = users.id WHERE chat_messages.id IN (SELECT MAX(id) FROM chat_messages GROUP BY user_id) ORDER BY chat_messages.id DESC");
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
                    <table class="table table-sm table-bordered table-striped data-table small">
                        <thead>
                            <tr>
                                <th class="text-bold">ID#</th>
                                <th class="text-bold">From</th>
                                <th class="text-bold">View</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($a = $chats->fetch_array()) : ?>
                                <tr>
                                    <td style="padding-top: 8px"><?= $a['id']; ?></td>
                                    <td style="padding-top: 8px"><?= $a['username']; ?></td>
                                    <td>
                                        <a href="chats-details.php?id=<?= $a['id']; ?>&from=<?= $a['user_id']; ?>" class="btn btn-sm btn-light border small">
                                            <span class="fas fa-info mr-1 text-warning"></span> Show Details
                                        </a>
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

<?php include "../../footer.php"; ?>