<?php

if ($page == "login") {
    echo view('templates/head');
    echo view('pages/' . $page);
    echo view('templates/foot_with_plugins');
} else {
    /* AKSES MENU APLIKASI AMKP*/
    if ($dcUser['otoritas'] == "tenagakerja") {
        echo view('templates/head_tenagakerja');
        echo view('templates/navbar_tenagakerja', $dcUser);

        switch ($page) {
            case 'dashboard':
                if ((Session()->welcomepages) && is_null($dtPresensiAktif)) {
                    $page = "$appName/tenagakerja/dashboard/welcome";
                } else {
                    $page = "$appName/tenagakerja/dashboard/menu";
                }
                Session()->set('welcomepages', false);
                break;
            default:
                # code...
                break;
        }
        echo view($page,  $dcUser);
        echo view('templates/footer');
        echo view('templates/foot_tenagakerja');
    } else {
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

                case 'jabatan':
                    $page = '/pages/admin/jabatan/index';
                    break;
                case 'jabatan_add':
                    $page = '/pages/admin/jabatan/add';
                    break;
                case 'jabatan_edit':
                    $page = '/pages/admin/jabatan/edit';
                    break;

                case 'tenagakerja_detail_daftar':
                    $page = '/pages/admin/tenagakerja/detail/index';
                    break;
                case 'tenagakerja_detail_info':
                    $page = '/pages/admin/tenagakerja/detail/info';
                    break;
                case 'tenagakerja_detail_add':
                    $page = '/pages/admin/tenagakerja/detail/add_detail';
                    break;
                case 'tenagakerja_detail_edit':
                    $page = '/pages/admin/tenagakerja/detail/edit_detail';
                    break;
                case 'tenagakerja_detail_import':
                    $page = '/pages/admin/tenagakerja/detail/import_detail';
                    break;

                case 'kontrak_pks':
                    $page = "/$appName/backoffice/kontrak/index";
                    break;
                case 'kontrak_pks_detail':
                    $page = "/$appName/backoffice/kontrak/detail";
                    break;
                case 'kontrak_pks_edit':
                    $page = "/$appName/backoffice/kontrak/edit";
                    break;
                case 'kontrak_rab_normatif':
                    $page = "/$appName/backoffice/kontrak/rab_normatif";
                    break;
                case 'kontrak_rab_material':
                    $page = "/$appName/backoffice/kontrak/rab_material";
                    break;
                case 'kontrak_pks_import_xls':
                    $page = "/$appName/backoffice/kontrak/import_pks";
                    break;

                case 'upahregional':
                    $page = '/pages/admin/upahregional/index';
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

        /* AKSES KHUSUS MENU ADMIN BY OTORITAS USER*/
        if ($dcUser['otoritas'] == "OPERATOR") {
            switch ($page) {
                case 'presensi':
                    $page = '/pages/admin/presensi/index';
                    break;
                default:
                    # code...
                    break;
            }
        }
        echo view($page,  $dcUser);
        echo view('templates/footer');
        echo view('templates/foot_with_plugins');
    }
}
