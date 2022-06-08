<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $appName . " | " . $title; ?></title>
    <link rel="icon" href="<?= $baseFolderImg; ?>/favicon.ico" type="image/gif">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= path_alte(); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= path_alte(); ?>/plugins/toastr/toastr.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= path_alte(); ?>/plugins/fontawesome-free/css/all.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= path_alte(); ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= path_alte(); ?>/dist/css/adminlte.min.css">

    <!-- Apps CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/apps/css/style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/apps/css/menu.css">
    <?= (isset($appCSS)) ?  $appCSS : '' ?>

    <!-- JS for SweetAlert2 -->
    <!-- SweetAlert2 -->
    <script src="<?= path_alte(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= path_alte(); ?>/plugins/toastr/toastr.min.js"></script>

    <!-- Sweet Alert JS-->
    <script src="<?= base_url(); ?>/apps/js/sweetalert.js"></script>
</head>

<body class="<?= $dcBodyClass; ?>">