<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?= base_url(); ?>/apps/img/<?= strtolower($appName); ?>/ic_logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b><?= $brand; ?></b></span>
    </a>
    <?php
    $istreeview = false;
    $selMenu = session()->get("selected_menu"); //Selected Menu
    if (is_null($selMenu)) {
        $selMenu = [
            "menu_id" => 0,
            "menu_parent" => 0,
            'menu_parent_top' => 0
        ];
    }
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <?php foreach ($dcUser['umenu'] as $menu) {
                    $menu_id = $menu['id'];
                    $title = $menu['menu_title'];
                    $link = $menu['menu_link'];
                    $level = $menu['menu_level'];
                    $icon = $menu['menu_icon'];

                    if ($link == "" && $level == 0) {
                        createMenuItem($title, $link, $icon);
                    }

                    //is treeview
                    if ($link == "#" && $level == 0) {
                        createMenuTree($title, $link, $icon, $dcUser['umenu'], $menu_id, $selMenu);
                    }
                } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">