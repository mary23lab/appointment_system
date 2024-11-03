<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/jquery/jquery.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/js/adminlte.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/js/custom.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/chart.js/Chart.min.js"></script>

<script>
    $(function () {
        $(".data-table").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "order": [],
        });
    });
</script>
</body>
</html>