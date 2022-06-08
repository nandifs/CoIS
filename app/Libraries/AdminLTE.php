<?php

namespace App\Libraries;

/**
 * Class AdminLTE
 *
 * @package App\Libraries
 */
class AdminLTE
{
    /* DARK THEME */
    protected $default_class_body = "hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed";
    protected $default_class_navbar = "main-header navbar navbar-expand navbar-dark";
    protected $default_class_sidebar = "main-sidebar sidebar-dark-primary elevation-4";

    /* LIGHT THEME */
    protected $default_light_class_body = "hold-transition sidebar-mini";
    protected $default_light_class_navbar = "main-header navbar navbar-expand navbar-white navbar-light";
    protected $default_light_class_sidebar = "main-sidebar sidebar-dark-primary elevation-4";
}
