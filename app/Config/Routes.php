<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/menu/(:num)', 'Appmenu::menu/$1');

/* MASTER DATA */
// User Aplikasi
$routes->get('/user_aplikasi', 'Master\User::index');

$routes->get('/user_add', 'Master\User::add');
$routes->get('/user_edit/(:num)', 'Master\User::edit/$1');
$routes->post('/user_save', 'Master\User::save');
$routes->post('/user_update/(:num)', 'Master\User::update/$1');
$routes->get('/user_delete/(:num)', 'Master\User::delete/$1');

// Wilayah Kerja
$routes->get('/wilayahkerja', 'Master\Wilayahkerja::index');
$routes->post('/wilayahkerja_update', 'Master\Wilayahkerja::update');
$routes->post('/wilayahkerja_delete/(:num)', 'Master\Wilayahkerja::delete/$1');

// Ajax Wilayah Kerja
$routes->post('/ajax_getwilayahkerja', 'Master\Wilayahkerja::ajax_get_wilayahkerja');

// Unit Kerja
$routes->get('/unitkerja', 'Master\Unitkerja::index');
$routes->post('/unitkerja_update', 'Master\Unitkerja::update_data');
$routes->post('/unitkerja_delete/(:num)', 'Master\Unitkerja::delete/$1');

// Ajax Unit Kerja
$routes->post('/ajax_getunitkerja', 'Master\Unitkerja::ajax_get_unitkerja');
$routes->post('/ajax_getunitkerjabykelas/(:num)', 'Master\Unitkerja::ajax_get_unitkerja/$1');

// Mitra Kerja
$routes->get('/mitrakerja', 'Master\Mitrakerja::index');
$routes->post('/mitrakerja_update', 'Master\Mitrakerja::update');
$routes->post('/mitrakerja_delete/(:num)', 'Master\Mitrakerja::delete/$1');

// Ajax Mitra Kerja
$routes->post('/ajax_getmitrakerja', 'Master\Mitrakerja::ajax_get_mitrakerja');
$routes->post('/ajax_getmitrakerjabykelas/(:num)', 'Master\Mitrakerja::ajax_get_mitrakerja/$1');

// Tenaga Kerja
$routes->get('/tenagakerja', 'Master\Tenagakerja::index');
$routes->post('/tenagakerja_add', 'Master\Tenagakerja::add');
$routes->get('/tenagakerja_edit/(:num)', 'Master\Tenagakerja::edit/$1');
$routes->post('/tenagakerja_save', 'Master\Tenagakerja::save');
$routes->post('/tenagakerja_update', 'Master\Tenagakerja::update');
$routes->post('/tenagakerja_delete/(:num)', 'Master\Tenagakerja::delete_by_ajax/$1');

// Tenaga Kerja Detail
$routes->get('/tenagakerja_info_detail', 'Master\Tenagakerjadetail::info');
$routes->get('/tenagakerja_daftar_detail', 'Master\Tenagakerjadetail::index');

$routes->get('/tenagakerja_add_detail', 'Master\Tenagakerjadetail::add');
$routes->post('/tenagakerja_save_detail', 'Master\Tenagakerjadetail::save');
$routes->post('/tenagakerja_edit_detail', 'Master\Tenagakerjadetail::edit');
$routes->post('/tenagakerja_update_detail', 'Master\Tenagakerjadetail::update');

$routes->get('/tenagakerja_import_detail', 'Master\Tenagakerjadetail::import_tenagakerja');

// Ajax Tenaga Kerja
$routes->post('/ajax_gettenagakerja', 'Master\Tenagakerja::ajax_get_data_tenagakerja');
$routes->post('/ajax_gettenagakerjadetail', 'Master\Tenagakerjadetail::ajax_get_data_tenagakerjadetail');

// Jabatan
$routes->get('/jabatan', 'Master\Jabatan::index');
$routes->get('/jabatan_edit/(:num)', 'Master\Jabatan::edit/$1');
$routes->get('/jabatan_add', 'Master\Jabatan::add');
$routes->post('/jabatan_save', 'Master\Jabatan::save');
$routes->post('/jabatan_update', 'Master\Jabatan::update');
$routes->post('/jabatan_delete/(:num)', 'Master\Jabatan::delete/$1');

// Kontrak PKS
$routes->get('/kontrak_pks', 'Kontrak\Kontrak::index');
$routes->get('/kontrak_pks_detail/(:num)', 'Kontrak\Kontrak::detail/$1');
$routes->get('/kontrak_pks_edit/(:num)', 'Kontrak\Kontrak::edit/$1');

// Import Kontrak PKS
$routes->get('/kontrak_pks_import', 'Kontrak\Kontrak::import');
$routes->post('/kontrak_pks_validasi_import_xls', 'Kontrak\Kontrak::validasi_import_xlsx');
$routes->post('/kontrak_pks_proses_import_xls', 'Kontrak\Kontrak::proses_import_xlsx');

$routes->get('/kontrak_rab_normatif', 'Kontrak\Kontrak::rab_normatif');
$routes->get('/kontrak_rab_material', 'Kontrak\Kontrak::rab_material');

// Import Upah Regional
$routes->get('/upahregional', 'Master\Upahregional::index');

/* PRESENSI PEGAWAI */
// Backoffice
$routes->get('/presensi', 'Presensi\Backoffice\Presensipegawai::index');
$routes->post('/presensi', 'Presensi\Backoffice\Presensipegawai::index');
$routes->post('/presensi_detail', 'Presensi\Backoffice\Presensipegawai::detail');

//Pegawai
$routes->get('/presensi_data', 'Presensi\Pegawai\Presensi::index');
$routes->get('/presensi_pegawai_detail/(:num)', 'Presensi\Pegawai\Presensi::detail/$1');
$routes->get('/presensi_add', 'Presensi\Pegawai\Presensi::presensi_add');
$routes->get('/presensi_out/(:num)', 'Presensi\Pegawai\Presensi::presensi_out/$1');
$routes->post('/presensi_save', 'Presensi\Pegawai\Presensi::save');
$routes->post('/presensi_saveout', 'Presensi\Pegawai\Presensi::save_out');

//AJAX AMKP
$routes->post('/getrekapkegiatanpegawai', 'Amkp\Kegiatan::ajax_data_tabel_rekap_kegiatan');

// PRESENSI TENAGAKERJA
// Backoffice
$routes->get('/presensi_tk', 'Presensi\Backoffice\Presensitenagakerja::index');


$routes->get('/presensi_tk_data', 'Presensi\Tenagakerja\Presensi::index');
$routes->get('/presensi_tk_add', 'Presensi\Tenagakerja\Presensi::presensi_add');
$routes->get('/presensi_tk_out/(:num)', 'Presensi\Tenagakerja\Presensi::presensi_out/$1');
$routes->post('/presensi_tk_save', 'Presensi\Tenagakerja\Presensi::save');
$routes->post('/presensi_tk_saveout', 'Presensi\Tenagakerja\Presensi::save_out');

$routes->get('/presensi_tk_detail/(:num)', 'Presensi\Tenagakerja\Presensi::detail/$1');

//AMKP
$routes->get('pegawai_kegiatan', 'Amkp\Kegiatan::index');
$routes->post('pegawai_kegiatan', 'Amkp\Kegiatan::index');
$routes->post('pegawai_kegiatanperpegawai', 'Amkp\Kegiatan::kegiatanperpegawai');

$routes->get('/pegawai_kegiatan_list', 'Amkp\Pegawai\Kegiatan::index');
$routes->get('/pegawai_kegiatan_add', 'Amkp\Pegawai\Kegiatan::add');
$routes->get('/pegawai_kegiatan_edit/(:num)', 'Amkp\Pegawai\Kegiatan::edit/$1');
$routes->post('/pegawai_kegiatan_save', 'Amkp\Pegawai\Kegiatan::save');
$routes->post('/pegawai_kegiatan_update', 'Amkp\Pegawai\Kegiatan::update');

// SATPAM ADMIN
$routes->get('/satpam/jadwalpiket/(:num)', 'Satpam\Jadwalpiket::index/$1');
$routes->get('/satpam/jadwalpiket/anggota/(:num)', 'Satpam\Jadwalpiket::anggota/$1');
$routes->get('/satpam/reguanggota/(:num)', 'Satpam\Reguanggota::index/$1');

$routes->get('/titikinspeksi', 'Satpam\Titikinspeksi::index');
$routes->post('/titikinspeksi_save', 'Satpam\Titikinspeksi::save');
$routes->post('/titikinspeksi_update', 'Satpam\Titikinspeksi::update');
$routes->get('/titikinspeksi_edit/(:num)', 'Satpam\Titikinspeksi::edit/$1');
$routes->get('/titikinspeksi_delete/(:num)', 'Satpam\Titikinspeksi::delete/$1');

$routes->get('/jadwalpiket', 'Satpam\Jadwalpiket::index');
$routes->get('/jadwalpiket/(:num)', 'Satpam\Jadwalpiket::index/$1');
$routes->get('/jadwalpiket_anggota/(:num)', 'Satpam\Jadwalpiket::anggota/$1');

$routes->get('/reguanggota/(:num)', 'Satpam\Reguanggota::index/$1');
$routes->post('/reguanggota_tambah', 'Satpam\Reguanggota::tambah');

$routes->get('/bukumutasi', 'Satpam\Bukumutasi::index');
$routes->get('/bukumutasi/(:num)', 'Satpam\Bukumutasi::index/$1');
$routes->get('/bukumutasidetail/(:num)', 'Satpam\Bukumutasi::detail/$1');
$routes->get('/bukumutasidelete/(:num)', 'Satpam\Bukumutasi::delete/$1');

$routes->get('/kegiatan_satpam', 'Satpam\Kegiatan::index');

$routes->get('/bukutamu', 'Satpam\Bukutamu::index');
$routes->post('/bukutamu', 'Satpam\Bukutamu::index');

$routes->get('/bukukendaraan', 'Satpam\Kendaraan::index');
$routes->post('/bukukendaraan', 'Satpam\Kendaraan::index');

//Tenagakerja Or Petugas
$routes->get('/satpam_jadwalpiket_petugas', 'Satpam\Petugas\Jadwalpiket::index');
$routes->get('/satpam_jadwalpiket_petugas/(:num)', 'Satpam\Petugas\Jadwalpiket::index/$1');
$routes->get('/satpam_jadwalpiket_anggota/(:num)', 'Satpam\Petugas\Jadwalpiket::anggota/$1');

$routes->get('/satpam_bukumutasi', 'Satpam\Petugas\Bukumutasi::index');
$routes->get('/satpam_bukumutasi_add', 'Satpam\Petugas\Bukumutasi::add');
$routes->get('/satpam_bukumutasi_add/(:num)', 'Satpam\Petugas\Bukumutasi::add/$1');
$routes->post('/satpam_bukumutasi_save', 'Satpam\Petugas\Bukumutasi::save');
$routes->post('/satpam_bukumutasi_savepetugas', 'Satpam\Petugas\Bukumutasi::save_petugas');
$routes->post('/satpam_bukumutasi_saveinventaris', 'Satpam\Petugas\Bukumutasi::save_inventaris');

$routes->get('/satpam_kegiatan', 'Satpam\Petugas\Kegiatan::index');
$routes->get('/satpam_inspeksi_add', 'Satpam\Petugas\Inspeksi::add');
$routes->post('/satpam_inspeksi_save', 'Satpam\Petugas\Inspeksi::save');
$routes->get('/satpam_kegiatan_add', 'Satpam\Petugas\Kegiatan::add');
$routes->post('/satpam_kegiatan_save', 'Satpam\Petugas\Kegiatan::save');

$routes->get('/satpam_bukutamu', 'Satpam\Petugas\Bukutamu::index');
$routes->post('/satpam_bukutamu', 'Satpam\Petugas\Bukutamu::index');
$routes->get('/satpam_bukutamu_add', 'Satpam\Petugas\Bukutamu::add');
$routes->post('/satpam_bukutamu_out', 'Satpam\Petugas\Bukutamu::updatejamkeluar');
$routes->post('/satpam_bukutamu_save', 'Satpam\Petugas\Bukutamu::save');
$routes->post('/satpam_bukutamu_update', 'Satpam\Petugas\Bukutamu::update');
$routes->get('/satpam_bukutamu_edit/(:num)', 'Satpam\Petugas\Bukutamu::edit/$1');
$routes->get('/satpam_bukutamu_delete/(:num)', 'Satpam\Petugas\Bukutamu::delete/$1');

$routes->get('/satpam_kendaraan', 'Satpam\Petugas\Kendaraan::index');
$routes->get('/satpam_kendaraan_masuk', 'Satpam\Petugas\Kendaraan::kendaraan_in');
$routes->get('/satpam_kendaraan_keluar', 'Satpam\Petugas\Kendaraan::kendaraan_out');
$routes->get('/satpam_kendaraan_keluar/(:num)', 'Satpam\Petugas\Kendaraan::kendaraan_out/$1');
$routes->post('/satpam_kendaraan_save', 'Satpam\Petugas\Kendaraan::save');
$routes->post('/satpam_kendaraan_saveout', 'Satpam\Petugas\Kendaraan::save_out');

$routes->get('/laporan_presensitenagakerja', 'Laporan\Presensi::presensitenagakerja');
$routes->post('/laporan_presensitenagakerja', 'Laporan\Presensi::presensitenagakerja');

$routes->post('/laporan_presensi_tk_detail', 'Laporan\Presensi::presensitkdetail');

$routes->get('/laporan_satpam', 'Satpam\Laporan::satpam');
$routes->get('/laporan_bukumutasi', 'Satpam\Laporan::bukumutasi');
$routes->get('/laporan_bukumutasi/(:num)', 'Satpam\Laporan::bukumutasi/$1');
$routes->get('/laporanbukumutasidetail/(:num)', 'Satpam\Bukumutasi::laporan_detail/$1');
$routes->get('/laporan_bukutamu', 'Satpam\Laporan::bukutamu');
$routes->get('/laporan_bukukendaraan', 'Satpam\Laporan::bukukendaraan');

//ajax SATPAM
$routes->post('/gettitikinspeksiwithajax', 'Satpam\Titikinspeksi::ajax_data_tabel_titik_inspeksi');
$routes->post('/gettitiklokasibygrup', 'Satpam\Petugas\Inspeksi::ajax_get_titik_lokasi_by_grup');

$routes->post('/getbukumutasisatpam', 'Satpam\Bukumutasi::ajax_data_tabel_buku_mutasi');

$routes->post('/getkendaraanbynopol', 'Satpam\Petugas\Kendaraan::ajax_get_kendaraan_by_nopol');

$routes->post('/ajax_load_laporan_satpam', 'Satpam\Laporan::ajax_load_laporan_satpam');
$routes->post('/load_template_laporan_satpam_by_ajax', 'Satpam\Laporan::load_template_laporan_satpam_by_ajax');

$routes->post('/getlaporanbukumutasisatpam', 'Satpam\Laporan::ajax_get_bukumutasi_satpam');
$routes->post('/exportlaporanbukumutasisatpam', 'Satpam\Laporan::export_buku_mutasi');

$routes->post('/bukutamu_ajax_get_tamu/(:num)', 'Satpam\Bukutamu::ajax_get_tamu/$1');

//OPHARDUNG
//BACKOFFICE OPHARDUNG
$routes->get('ophardung_kegiatan', 'Ophardung\Kegiatan::index');
$routes->post('ophardung_kegiatan', 'Ophardung\Kegiatan::index');
$routes->post('ophardung_kegiatanperpetugas', 'Ophardung\Kegiatan::kegiatanperpetugas');

$routes->get('ophardung_inventori', 'Ophardung\Inventori::index');
$routes->post('ophardung_inventori', 'Ophardung\Inventori::index');
$routes->post('ophardung_inventoriunit', 'Ophardung\Inventori::inventoriunit');

$routes->get('/laporan_ophardung_kegiatan', 'Ophardung\Laporan::kegiatan');
$routes->post('/laporan_ophardung_kegiatan', 'Ophardung\Laporan::kegiatan');
$routes->post('/laporan_ophardung_kegiatanperpetugas', 'Ophardung\Laporan::laporankegiatanperpetugas');

$routes->get('/laporan_ophardung_inventori', 'Ophardung\Laporan::inventori');

$routes->get('/export_kegiatan_ophar_to_xls', 'Ophardung\Kegiatan::export_kegiatan_ophardung'); // sama dengan yang di laporan kalo bisa taruh di library
$routes->get('/export_laporan_kegiatan_ophar_to_xls', 'Ophardung\Laporan::export_kegiatan_ophardung');

//PETUGAS OPHARDUNG
$routes->get('/ophardung_kegiatan_add', 'Ophardung\Petugas\Kegiatan::add');
$routes->post('/ophardung_kegiatan_save', 'Ophardung\Petugas\Kegiatan::save');

$routes->get('/ophardung_petugas_inventori', 'Ophardung\Petugas\Inventori::index');
$routes->get('/ophardung_inventori_add', 'Ophardung\Petugas\Inventori::add');
$routes->post('/ophardung_inventori_save', 'Ophardung\Petugas\Inventori::save');

$routes->get('/ophardung_inventaris_delete/(:num)', 'Ophardung\Petugas\Inventori::delete/$1');

//ajax OPHARDUNG
$routes->post('/getkegiatanophardung/(:num)', 'Ophardung\Petugas\Kegiatan::ajax_get_kegiatan/$1'); //CEK INI DIGUNAKAN ATAU TIDAK
$routes->post('/getrekapkegiatanophardung', 'Ophardung\Kegiatan::ajax_data_tabel_rekap_kegiatan');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
