<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $appName . " | " . $title; ?></title>
    <link rel="icon" href="<?= base_url(); ?>/favicon.ico" type="image/gif">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= path_alte(); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= path_alte(); ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= path_alte(); ?>/dist/css/adminlte.min.css">

    <!-- Apps CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/apps/css/style.css">
    <?= (isset($appCSS)) ?  $appCSS : '' ?>
</head>

<body class="<?= $dcBodyClass; ?>">