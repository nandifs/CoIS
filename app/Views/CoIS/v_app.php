<?php

if ($page == "login") {
    echo view('templates/head');
    echo view('pages/' . $page);
    echo view('templates/foot_with_plugins');
} else {
    /* AKSES MENU APLIKASI CoIS*/
    if ($dcUser['otoritas'] == "ADMINISTRATOR") {
        echo view('templates/head_with_plugins');
        echo view('templates/navbar', $dcUser);
        echo view('templates/sidebar');
        if ($dcUser['otoritas'] == "SU") {
            switch ($page) {
                case 'dashboard':
                    $page = "$appName/backoffice/dashboard/su";
                    break;

                default:
                    # code...
                    break;
            }
        } else if ($dcUser['otoritas'] == "ADMINISTRATOR") {

            switch ($page) {
                case 'dashboard':
                    $page = "$appName/backoffice/dashboard/admin";
                    break;

                    /* AKSES MENU ONLY ADMIN*/
                case 'user':
                    $page = '/pages/admin/user/index';
                    break;
                case 'user_add':
                    $page = '/pages/admin/user/add';
                    break;
                case 'user_edit':
                    $page = '/pages/admin/user/edit';
                    break;
                case 'wilayahkerja':
                    $page = '/pages/admin/wilayahkerja/index';
                    break;
                case 'wilayahkerja_add':
                    $page = '/pages/admin/wilayahkerja/add';
                    break;
                case 'wilayahkerja_edit':
                    $page = '/pages/admin/wilayahkerja/edit';
                    break;
                case 'unitkerja':
                    $page = '/pages/admin/unitkerja/index';
                    break;
                case 'unitkerja_add':
                    $page = '/pages/admin/unitkerja/add';
                    break;
                case 'unitkerja_edit':
                    $page = '/pages/admin/unitkerja/edit';
                    break;
                case 'mitrakerja':
                    $page = '/pages/admin/mitrakerja/index';
                    break;
                case 'mitrakerja_add':
                    $page = '/pages/admin/mitrakerja/add';
                    break;
                case 'mitrakerja_edit':
                    $page = '/pages/admin/mitrakerja/edit';
                    break;

                default:
                    # code...
                    break;
            }
        } else if ($dcUser['otoritas'] == "OPERATOR") {
            switch ($page) {
                case 'dashboard':
                    $page = "$appName/backoffice/dashboard/operator";
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
    echo view($page,  $dcUser);
    echo view('templates/footer');
    echo view('templates/foot_with_plugins');
}
