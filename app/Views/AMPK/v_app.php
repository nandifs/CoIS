<?php

if ($page == "login") {
    echo view('templates/head');
    echo view('pages/' . $page);
    echo view('templates/foot_with_plugins');
} else {
    /* AKSES MENU APLIKASI MANAJEMEN PENGEMUDI DAN KENDARAAN (AMPK)*/
    if ($dcUser['otoritas'] == "TENAGAKERJA") {
        echo view('templates/head_pegawai');
        echo view('templates/navbar_pegawai', $dcUser);

        switch ($page) {
            case 'dashboard':
                if ((Session()->welcomepages) && is_null($dtPresensiAktif)) {
                    $page = "$appName/tenagakerja/dashboard/welcome";
                } else {
                    $page = "$appName/tenagakerja/dashboard/menu";
                }
                Session()->set('welcomepages', false);
                break;
            case 'presensi_tk':
                $page = "$appName/tenagakerja/presensi/index";
                break;
            case 'presensi_tk_add':
                $page = "$appName/tenagakerja/presensi/add";
                break;
            case 'presensi_tk_out':
                $page = "$appName/tenagakerja/presensi/pulang";
                break;
            case 'presensi_tk_detail':
                $page = "$appName/tenagakerja/presensi/detail";
                break;

            case 'ophardung_kegiatan':
                $page = "$appName/tenagakerja/kegiatan/index";
                break;
            case 'ophardung_kegiatan_add':
                $page = "$appName/tenagakerja/kegiatan/add";
                break;

            case 'ophardung_petugas_inventori':
                $page = "$appName/tenagakerja/inventori/index";
                break;
            case 'ophardung_inventori_add':
                $page = "$appName/tenagakerja/inventori/add";
                break;

            default:
                # code...
                break;
        }
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

                case 'ophardung_kegiatan':
                    $page = "$appName/backoffice/kegiatan/index";
                    break;
                case 'ophardung_kegiatanperpetugas':
                    $page = "$appName/backoffice/kegiatan/kegiatanpetugas";
                    break;
                case 'ophardung_inventori':
                    $page = "$appName/backoffice/inventori/index";
                    break;
                case 'ophardung_inventori_unit':
                    $page = "$appName/backoffice/inventori/inventori_unit";
                    break;

                case 'laporan_presensi':
                    $page = "$appName/backoffice/laporan/presensi/index";
                    break;
                case 'laporan_presensi_rekap':
                    $page = "$appName/backoffice/laporan/presensi/rekap";
                    break;
                case 'laporan_ophardung_kegiatan':
                    $page = "$appName/backoffice/laporan/kegiatan/index";
                    break;
                case 'laporan_ophardung_kegiatanperpetugas':
                    $page = "$appName/backoffice/laporan/kegiatan/kegiatanpetugas";
                    break;

                case 'laporan_ophardung_inventori':
                    $page = "$appName/backoffice/laporan/inventori/index";
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
                case 'tenagakerja':
                    $page = '/pages/admin/tenagakerja/index';
                    break;
                case 'tenagakerja_add':
                    $page = '/pages/admin/tenagakerja/add';
                    break;
                case 'tenagakerja_edit':
                    $page = '/pages/admin/tenagakerja/edit';
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
                    $page = '/pages/admin/presensi/tenagakerja/index';
                    break;
                case 'presensi_rekap':
                    $page = '/pages/admin/presensi/tenagakerja/rekap';
                    break;
                case 'presensi_detail':
                    $page = '/pages/admin/presensi/tenagakerja/detail';
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
        } else if ($dcUser['otoritas'] == "KORDINATOR") {
            switch ($page) {
                case 'dashboard':
                    $page = "$appName/backoffice/dashboard/kordinator";
                    break;

                case 'ophardung_kegiatan':
                    $page = "$appName/backoffice/kegiatan/index";
                    break;
                case 'ophardung_kegiatanperpetugas':
                    $page = "$appName/backoffice/kegiatan/kegiatanpetugas";
                    break;
                case 'ophardung_inventori':
                    $page = "$appName/backoffice/inventori/index";
                    break;
                case 'ophardung_inventori_unit':
                    $page = "$appName/backoffice/inventori/inventori_unit";
                    break;

                case 'laporan_presensi':
                    $page = "$appName/backoffice/laporan/presensi/index";
                    break;
                case 'laporan_presensi_rekap':
                    $page = "$appName/backoffice/laporan/presensi/rekap";
                    break;
                case 'laporan_ophardung_kegiatan':
                    $page = "$appName/backoffice/laporan/kegiatan/index";
                    break;
                case 'laporan_ophardung_kegiatanperpetugas':
                    $page = "$appName/backoffice/laporan/kegiatan/kegiatanpetugas";
                    break;
                case 'laporan_ophardung_inventori':
                    $page = "$appName/backoffice/laporan/inventori/index";
                    break;

                default:
                    # code...
                    break;
            }
        } else if ($dcUser['otoritas'] == "TAMU") {
            switch ($page) {
                case 'dashboard':
                    $page = "$appName/backoffice/dashboard/tamu";
                    break;

                case 'laporan_presensi':
                    $page = "$appName/backoffice/laporan/presensi/tenagakerja/index";
                    break;
                case 'laporan_presensi_rekap':
                    $page = "$appName/backoffice/laporan/presensi/tenagakerja/rekap";
                    break;
                case 'laporan_ophardung_kegiatan':
                    $page = "$appName/backoffice/laporan/kegiatan/index";
                    break;
                case 'laporan_ophardung_kegiatanperpetugas':
                    $page = "$appName/backoffice/laporan/kegiatan/kegiatanpetugas";
                    break;
                case 'laporan_ophardung_inventori':
                    $page = "$appName/backoffice/laporan/inventori/index";
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
        } else if ($dcUser['otoritas'] == "KORDINATOR") {
            switch ($page) {
                case 'presensi':
                    $page = '/pages/admin/presensi/index';
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
