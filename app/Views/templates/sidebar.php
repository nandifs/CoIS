<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?= base_url(); ?>/apps/img/<?= strtolower($appName); ?>/ic_logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b><?= $brand; ?></b></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <?php
                $istreeview = false;
                $selMenu = session()->get("selected_menu"); //Selected Menu
                if (is_null($selMenu)) {
                    $selMenu = [
                        "menu_id" => 0,
                        "menu_parent" => 0,
                    ];
                }
                ?>
                <?php foreach ($dcUser['umenu'] as $menu) { ?>
                    <?php if ($menu['menu_link'] == '#') { ?>
                        <?= ($istreeview) ? PHP_EOL . '</ul> </li>' : ""; ?>
                        <?php $istreeview = true; ?>
                        <li class="nav-item has-treeview <?= ($selMenu['menu_parent'] == $menu['id']) ? "menu-open" : ""; ?>">
                            <a href="/menu/#" class="nav-link <?= ($selMenu['menu_parent'] == $menu['id']) ? "active" : ""; ?>">
                                <i class="nav-icon <?= $menu['menu_icon']; ?>"></i>
                                <p><?= $menu['menu_title']; ?> <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                            <?php } else if ($menu['menu_link'] !== '#' && $menu['parent_id'] == 0) { ?>
                                <?php
                                if ($istreeview) {
                                    echo PHP_EOL . '</ul> </li>' . PHP_EOL;
                                    $istreeview = false;
                                }
                                ?>
                                <li class="nav-item">
                                    <a href="/menu/<?= $menu['id']; ?>" class="nav-link <?= ($selMenu['menu_id'] == $menu['id']) ? "active" : ""; ?>">
                                        <i class="nav-icon <?= $menu['menu_icon']; ?>"></i>
                                        <p><?= $menu['menu_title']; ?></p>
                                    </a>
                                </li>
                            <?php } else if ($menu['menu_link'] != '#' && $menu['parent_id'] != 0) { ?>
                                <li class="nav-item">
                                    <a href="/menu/<?= $menu['id']; ?>" class="nav-link <?= ($selMenu['menu_id'] == $menu['id']) ? "active" : ""; ?>">
                                        <i class=" <?= ($selMenu['menu_id'] == $menu['id']) ? "far fa-dot-circle" : $menu['menu_icon']; ?> nav-icon"></i>
                                        <p><?= $menu['menu_title']; ?></p>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <?= ($istreeview == true) ? PHP_EOL . '</ul> </li>' : ""; ?>
                            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">