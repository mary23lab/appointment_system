<?php
    include 'session.php'; 
    $audit_trail = $conn->query("SELECT * FROM `audit_trail` WHERE `user_id` = '$userId' ORDER BY `id` DESC");
?>

<?php include "../../header.php"; ?>

<?php include "menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header pb-0">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-12 d-flex align-items-center" style="font-size: 18px">
                    <span class="material-icons-outlined mr-1 text-muted">insights</span>
                    <strong class="mt-1">Audit Trails</strong>
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
                                <th class="text-bold">Details</th>
                                <th class="text-bold">Date/Time</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($a = $audit_trail->fetch_array()) : ?>
                                <tr>
                                    <td style="padding-top: 8px"><?= $a['id']; ?></td>
                                    <td style="padding-top: 8px"><?= $a['details']; ?></td>
                                    <td style="padding-top: 8px"><?= date("F d, Y h:i A", strtotime($a['history_created_at'])); ?></td>
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