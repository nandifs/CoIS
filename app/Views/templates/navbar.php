<div class="wrapper">

    <!-- Preloader 
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="<?= path_alte(); ?>/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>
    -->
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>

            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= base_url($ufoto); ?>" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline"><?= $uname; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="<?= base_url($ufoto); ?>" class="img-circle elevation-2" alt="User Image">
                        <p>
                            <?= $uname; ?>
                            <small><?= $otoritas; ?></small>
                        </p>
                    </li>

                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="<?= base_url(); ?>/login/user_logout" class="btn btn-default btn-flat float-right">Keluar</a>
                    </li>
                </ul>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li> -->
        </ul>
    </nav>
    <!-- /.navbar -->