<?php

if ($page == "login") {
    echo view('templates/head');
    echo view('pages/' . $page);
    echo view('templates/foot_with_plugins');
} else {
    /* AKSES MENU APLIKASI AMKP*/
    if ($dcUser['otoritas'] == "PEGAWAI") {
        echo view('templates/head_pegawai');
        echo view('templates/navbar_pegawai', $dcUser);

        switch ($page) {
            case 'dashboard':
                if ((Session()->welcomepages) && is_null($dtPresensiAktif)) {
                    $page = "$appName/pegawai/dashboard/welcome";
                } else {
                    $page = "$appName/pegawai/dashboard/menu";
                }
                Session()->set('welcomepages', false);
                break;
            case 'presensi':
                $page = "pages/presensi/pegawai/index";
                break;
            case 'presensi_add':
                $page = "pages/presensi/pegawai/add";
                break;
            case 'presensi_out':
                $page = "pages/presensi/pegawai/pulang";
                break;
            case 'presensi_detail':
                $page = "pages/presensi/pegawai/detail";
                break;

            case 'pegawai_kegiatan_list':
                $page = "$appName/pegawai/kegiatan/index";
                break;
            case 'pegawai_kegiatan_add':
                $page = "$appName/pegawai/kegiatan/add";
                break;
            case 'pegawai_kegiatan_edit':
                $page = "$appName/pegawai/kegiatan/edit";
                break;

            default:
                # code...
                break;
        }
        echo view($page,  $dcUser);
        echo view('templates/footer');
        echo view('templates/foot_pegawai');
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

                case 'pegawai_kegiatan':
                    $page = "$appName/backoffice/kegiatan/index";
                    break;
                case 'pegawai_kegiatanperpegawai':
                    $page = "$appName/backoffice/kegiatan/kegiatanpegawai";
                    break;

                case 'laporan_presensi':
                    $page = "$appName/backoffice/laporan/presensi/index";
                    break;
                case 'laporan_presensi_rekap':
                    $page = "$appName/backoffice/laporan/presensi/rekap";
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
                case 'pegawai':
                    $page = '/pages/admin/pegawai/index';
                    break;
                case 'pegawai_add':
                    $page = '/pages/admin/pegawai/add';
                    break;
                case 'pegawai_edit':
                    $page = '/pages/admin/pegawai/edit';
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
                case 'presensi':
                    $page = '/pages/admin/presensi/pegawai/index';
                    break;
                case 'presensi_rekap':
                    $page = '/pages/admin/presensi/pegawai/rekap';
                    break;
                case 'presensi_detail':
                    $page = '/pages/admin/presensi/pegawai/detail';
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
