<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/css/adminlte.min.css">
    <link rel="stylesheet" href="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/css/custom.css">
    <link rel="stylesheet" href="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lobster&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Pet Plus</title>
</head>

<style>
    body { font-family: 'Roboto', sans-serif; }

    .login-page.first-container {
        background: url('http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/system-images/login-bg.png') no-repeat;
        background-size: cover;
    }

    .card-hover-zoom {
        transition: transform 0.3s ease-in-out;
    }

    .card-hover-zoom:hover {
        transform: scale(1.02);
    }

    .other_data, #payment_number_g {
        display: none;
    }
</style>

<body class="hold-transition layout-fixed layout-navbar-fixed">
    <div class="loader">
        <img src="http<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : ''; ?>://<?php echo $_SERVER['HTTP_HOST']; ?>/vet/assets/system-images/am-spinner-1.gif" height="100"/>
    </div>