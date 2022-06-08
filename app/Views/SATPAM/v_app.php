<?php

if ($page == "login") {
    echo view('templates/head');
    echo view('pages/' . $page);
    echo view('templates/foot_with_plugins');
} else {
    /* AKSES MENU APLIKASI SATPAM*/
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
                $page = "/pages/presensi/tenagakerja/index";
                break;
            case 'presensi_tk_add':
                $page = "/pages/presensi/tenagakerja/add";
                break;
            case 'presensi_tk_out':
                $page = "/pages/presensi/tenagakerja/pulang";
                break;
            case 'presensi_tk_detail':
                $page = "/pages/presensi/tenagakerja/detail";
                break;

            case 'bukumutasi_petugas':
                $page = "$appName/tenagakerja/bukumutasi/index";
                break;
            case 'bukumutasi_tenagakerja_add':
                $page = "$appName/tenagakerja/bukumutasi/add";
                break;

            case 'satpam_kegiatan':
                $page = "$appName/tenagakerja/kegiatan/index";
                break;
            case 'satpam_inspeksi_add':
                $page = "$appName/tenagakerja/inspeksi/add";
                break;
            case 'satpam_kegiatan_add':
                $page = "$appName/tenagakerja/kegiatan/add";
                break;

            case 'satpam_bukutamu':
                $page = "$appName/tenagakerja/bukutamu/index";
                break;
            case 'satpam_bukutamu_add':
                $page = "$appName/tenagakerja/bukutamu/add";
                break;
            case 'satpam_bukutamu_edit':
                $page = "$appName/tenagakerja/bukutamu/edit";
                break;

            case 'satpam_kendaraan':
                $page = "$appName/tenagakerja/kendaraan/index";
                break;
            case 'satpam_kendaraan_masuk':
                $page = "$appName/tenagakerja/kendaraan/masuk";
                break;
            case 'satpam_kendaraan_keluar':
                $page = "$appName/tenagakerja/kendaraan/keluar";
                break;

            case 'satpam_jadwalpiket':
                $page = "$appName/tenagakerja/jadwalpiket/index";
                break;
            case 'satpam_jadwalanggota':
                $page = "$appName/tenagakerja/jadwalpiket/anggota";
                break;

            default:
                # code...
                break;
        }
        echo view($page,  $dcUser);
        echo view('templates/footer');
        echo view('templates/foot_pegawai');
        //echo view('templates/foot_with_plugins');
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
                case 'titikinspeksi':
                    $page = "$appName/backoffice/titikinspeksi/index";
                    break;
                case 'titikinspeksi_add':
                    $page = "$appName/backoffice/titikinspeksi/add";
                    break;
                case 'titikinspeksi_edit':
                    $page = "$appName/backoffice/titikinspeksi/edit";
                    break;
                case 'jadwalpiket':
                    $page = "$appName/backoffice/jadwalpiket/index";
                    break;
                case 'jadwalanggota':
                    $page = "$appName/backoffice/jadwalpiket/anggota";
                    break;
                case 'reguanggota':
                    $page = "$appName/backoffice/regu/anggota";
                    break;

                case 'bukumutasi':
                    $page = "$appName/backoffice/bukumutasi/index";
                    break;
                case 'bukumutasidetail':
                    $page = "$appName/backoffice/bukumutasi/detail";
                    break;

                case 'kegiatan_satpam':
                    $page = "$appName/backoffice/kegiatan/index";
                    break;

                case 'bukutamu':
                    $page = "$appName/backoffice/bukutamu/index";
                    break;

                case 'bukukendaraan':
                    $page = "$appName/backoffice/bukukendaraan/index";
                    break;

                case 'laporan_presensi':
                    $page = "$appName/backoffice/laporan/presensi/index";
                    break;
                case 'laporan_presensi_rekap':
                    $page = "$appName/backoffice/laporan/presensi/rekap";
                    break;
                case 'laporan_presensi_tk_detail':
                    $page = "$appName/backoffice/laporan/presensi/detail";
                    break;

                case 'laporan_satpam':
                    $page = "$appName/backoffice/laporan/satpam/index";
                    break;
                case 'laporan_template':
                    $page = "$appName/backoffice/laporan/template/index";
                    break;
                case 'laporan_bukumutasi':
                    $page = "$appName/backoffice/laporan/bukumutasi/index";
                    break;
                case 'laporan_bukumutasi_detail':
                    $page = "$appName/backoffice/laporan/bukumutasi/detail";
                    break;
                case 'laporan_bukutamu':
                    $page = "$appName/backoffice/laporan/bukutamu/index";
                    break;
                case 'laporan_bukukendaraan':
                    $page = "$appName/backoffice/laporan/bukukendaraan/index";
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

                case 'presensi':
                    $page = '/pages/admin/presensi/tenagakerja/index';
                    break;
                case 'presensi_rekap':
                    $page = '/pages/admin/presensi/tenagakerja/rekap';
                    break;
                case 'presensi_detail':
                    $page = '/pages/admin/presensi/tenagakerja/detail';
                    break;

                case 'titikinspeksi':
                    $page = "$appName/backoffice/titikinspeksi/index";
                    break;
                case 'titikinspeksi_add':
                    $page = "$appName/backoffice/titikinspeksi/add";
                    break;
                case 'titikinspeksi_edit':
                    $page = "$appName/backoffice/titikinspeksi/edit";
                    break;

                case 'jadwalpiket':
                    $page = "$appName/backoffice/jadwalpiket/index";
                    break;
                case 'jadwalanggota':
                    $page = "$appName/backoffice/jadwalpiket/anggota";
                    break;

                case 'reguanggota':
                    $page = "$appName/backoffice/regu/anggota";
                    break;

                case 'bukumutasi':
                    $page = "$appName/backoffice/bukumutasi/index";
                    break;
                case 'bukumutasidetail':
                    $page = "$appName/backoffice/bukumutasi/detail";
                    break;

                case 'bukutamu':
                    $page = "$appName/backoffice/bukutamu/index";
                    break;

                case 'bukukendaraan':
                    $page = "$appName/backoffice/bukukendaraan/index";
                    break;

                case 'laporan_satpam':
                    $page = "$appName/backoffice/laporan/satpam/index";
                    break;
                case 'laporan_template':
                    $page = "$appName/backoffice/laporan/template/index";
                    break;
                case 'laporan_presensi':
                    $page = "$appName/backoffice/laporan/presensi/index";
                    break;
                case 'laporan_presensi_rekap':
                    $page = "$appName/backoffice/laporan/presensi/rekap";
                    break;
                case 'laporan_bukumutasi':
                    $page = "$appName/backoffice/laporan/bukumutasi/index";
                    break;
                case 'laporan_bukumutasi_detail':
                    $page = "$appName/backoffice/laporan/bukumutasi/detail";
                    break;
                case 'laporan_bukutamu':
                    $page = "$appName/backoffice/laporan/bukutamu/index";
                    break;
                case 'laporan_bukukendaraan':
                    $page = "$appName/backoffice/laporan/bukukendaraan/index";
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

                case 'laporan_satpam':
                    $page = "$appName/backoffice/laporan/satpam/index";
                    break;
                case 'laporan_template':
                    $page = "$appName/backoffice/laporan/template/index";
                    break;
                case 'laporan_presensi':
                    $page = "$appName/backoffice/laporan/presensi/index";
                    break;
                case 'laporan_presensi_rekap':
                    $page = "$appName/backoffice/laporan/presensi/rekap";
                    break;
                case 'laporan_bukumutasi':
                    $page = "$appName/backoffice/laporan/bukumutasi/index";
                    break;
                case 'laporan_bukumutasi_detail':
                    $page = "$appName/backoffice/laporan/bukumutasi/detail";
                    break;
                case 'laporan_bukutamu':
                    $page = "$appName/backoffice/laporan/bukutamu/index";
                    break;
                case 'laporan_bukukendaraan':
                    $page = "$appName/backoffice/laporan/bukukendaraan/index";
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
        echo view($page,  $dcUser);
        echo view('templates/footer');
        echo view('templates/foot_with_plugins');
    }
}
