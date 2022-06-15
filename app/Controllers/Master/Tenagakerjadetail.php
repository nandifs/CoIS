<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHelperTenagakerja;

use App\Models\M_jabatan;
use App\Models\M_tenagakerja;
use App\Models\M_tenagakerja_detail;

class Tenagakerjadetail extends BaseController
{
    protected $dbHelper;
    protected $dbTenagakerja;
    protected $dbJabatan;


    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbTenagakerja = new M_tenagakerja();
        $this->dbTenagakerjaDetail = new M_tenagakerja_detail();

        $this->dbJabatan = new M_jabatan();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $selDtAkses = $this->dtAksesMitra;
        $selComboDtAkses = $this->request->getVar("dtakses");

        $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

        if (is_null($selComboDtAkses)) {
            $selComboDtAkses = $dtMitraKerja[0]['id'];
        }

        //get tenagakerja by selected mitrakerja
        if ($this->session->has('smk')) {
            $selDtAkses = $this->session->smk;
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailPenempatan($selDtAkses);
        } else {
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailPenempatan($selComboDtAkses);
        }

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('tenagakerja/detail/data_tenagakerja.js', "appjs");

        $this->dtContent['title'] = "Data Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_daftar";

        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        $this->dtContent['selMitraKerja'] = $selDtAkses;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function import_tenagakerja()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dtTenagakerja = $this->dbHelper->getTenagakerjaDetail();

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('tenagakerja/data_tenagakerja.js', 'appjs');

        $this->dtContent['title'] = "Data Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_import";

        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function info()
    {
        //Cek otoritas user        
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $nip_tk = $this->request->getGet("nip");

        $this->dtContent['title'] = "Tambah Tenagakerja";
        $this->dtContent['page'] = "tenagakerja_detail_info";

        if (!is_null($nip_tk)) {
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailByNIP($nip_tk);
            if (is_null($dtTenagakerja)) {
                session()->setFlashData('msg_info', 'Tenaga kerja dengan NIP : ' . $nip_tk . ' tidak ditemukan.');
            } else {
                $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
            }
        }

        $this->dtContent['nip_tk'] = $nip_tk;

        $appJS =  loadJS('tenagakerja/detail/info_detail.js', "appjs");
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function add()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $getNip = $this->request->getGet("nip");

        if (!is_null($getNip)) {
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailByNIP($getNip);
            if (!is_null($dtTenagakerja)) {
                session()->setFlashData('msg_info', 'NIP tenaga kerja sudah digunakan.');
            }
        }

        $selMitrakerja = $this->request->getVar("dtakses");
        if ($this->appID == "40") {
            $dtJabatan = $this->dbJabatan->getJabatan("All");
        } else {
            $dtJabatan = $this->dbJabatan->getJabatan($this->appID);
        }

        if (is_null($selMitrakerja)) {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);
        } else {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($selMitrakerja);
        }

        $dtWilayahKerja = $this->dbHelper->getWilayahKerja(null, ["a.kelas" => 2]);

        $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);

        $this->dtContent['title'] = "Tambah Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_add";
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtWilayahKerja'] = $dtWilayahKerja;

        $this->dtContent['nip'] = $getNip;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $selMitrakerja = $this->request->getVar("dtakses");
        if ($this->appID == "40") {
            $dtJabatan = $this->dbJabatan->getJabatan("All");
        } else {
            $dtJabatan = $this->dbJabatan->getJabatan($this->appID);
        }

        if (is_null($selMitrakerja)) {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);
        } else {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($selMitrakerja);
        }

        $dtWilayahKerja = $this->dbHelper->getWilayahKerja(null, ["a.kelas" => 2]);
        $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);

        $nip = $this->request->getPost("nip");

        if (!is_null($nip)) {
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailByNIP($nip);
            if (is_null($dtTenagakerja)) {
                return redirect()->to("/tenagakerja_info_detail?nip=$nip");
            }

            $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        }

        $this->dtContent['title'] = "Update Data Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_edit";
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtWilayahKerja'] = $dtWilayahKerja;

        $appJS =  loadJS('tenagakerja/detail/update_detail.js', "appjs");
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $nip = $this->request->getVar('nip');
        $nama = strtoupper($this->request->getVar('nama'));
        $jabatan_id = $this->request->getVar('jabatan');
        $unitkerja_id = $this->request->getVar('unitkerja');
        $penempatan_id = $this->request->getVar('penempatan');
        $wilayahkerja_id = $this->request->getVar('wilkerja');

        $no_identitas = $this->request->getVar('no_identitas');
        $tmp_lahir = strtoupper($this->request->getVar('tmp_lahir'));
        $tgl_lahir = $this->request->getVar('tgl_lahir');
        $jns_kelamin = $this->request->getVar('jns_kel');
        $alamat = $this->request->getVar('alamat');
        $telepon = $this->request->getVar('telepon');
        $email = $this->request->getVar('email');

        $password = password_hash($nip, PASSWORD_BCRYPT);

        $data = [
            'nip' => $nip,
            'nama' => $nama,
            'jabatan_id' => $jabatan_id,
            'unitkerja_id' => $unitkerja_id,
            'penempatan_id' => $penempatan_id,
            'wilayah_id' => $wilayahkerja_id,
            'email' => $email,
            'otoritas_id' => 4, //Otoritas = PEGAWAI
            'kata_kunci' => $password,
            'status_id' => 1,
            'apps_id' => 0
        ];

        //Save to database
        $simpan = $this->dbTenagakerja->save($data);
        if ($simpan) {
            $pegawai_id = $this->dbTenagakerja->getInsertID();
            $data_detail = [
                'pegawai_id' => $pegawai_id,
                'no_identitas' => $no_identitas,
                'tempat_lahir' => $tmp_lahir,
                'tanggal_lahir' => $tgl_lahir,
                'jenis_kelamin' => $jns_kelamin,
                'alamat' => $alamat,
                'telepon' => $telepon
            ];
            //Simpan data detail TK
            $this->dbTenagakerjaDetail->insert($data_detail);
            session()->setFlashData('success', 'Data Tenagakerja berhasil ditambahkan.');
        } else {
            session()->setFlashData('danger', 'Data Tenagakerja Gagal Ditambahkan.');
        }

        $this->session->set('smk', $penempatan_id);

        return redirect()->to('/tenagakerja_info_detail');
    }

    public function update()
    {
        $pegawai_id = $this->request->getVar('pegawai_id');

        $nip = $this->request->getVar('nip');
        $nama = strtoupper($this->request->getVar('nama'));
        $jabatan_id = $this->request->getVar('jabatan');
        $unitkerja_id = $this->request->getVar('unitkerja');
        $penempatan_id = $this->request->getVar('penempatan');
        $wilayahkerja_id = $this->request->getVar('wilkerja');

        $no_identitas = $this->request->getVar('no_identitas');
        $tmp_lahir = strtoupper($this->request->getVar('tmp_lahir'));
        $tgl_lahir = $this->request->getVar('tgl_lahir');
        $jns_kelamin = $this->request->getVar('jns_kel');
        $alamat = $this->request->getVar('alamat');
        $telepon = $this->request->getVar('telepon');
        $email = $this->request->getVar('email');

        $password = password_hash($nip, PASSWORD_BCRYPT);

        $file_foto = $this->request->getFile('foto_pegawai');

        if (is_null($file_foto)) {
            $nm_foto = "";
        } else {
            $nm_foto = $nip . "." . $file_foto->getExtension();
            $path_foto = "uploads/user/foto";
            $file_foto->move($path_foto, $nm_foto, true);

            //resize image
            $img_file = ($path_foto . "/" . $nm_foto);
            if (file_exists($img_file)) {
                $image = \Config\Services::image();
                $image->withFile($img_file)
                    ->resize(225, 225, false, "height")
                    ->save($img_file);
            }
        }

        $data = [
            'id' => $pegawai_id,
            'nip' => $nip,
            'nama' => $nama,
            'jabatan_id' => $jabatan_id,
            'unitkerja_id' => $unitkerja_id,
            'penempatan_id' => $penempatan_id,
            'wilayah_id' => $wilayahkerja_id,
            'email' => $email,
            'otoritas_id' => 4, //Otoritas = PEGAWAI
            'kata_kunci' => $password,
            'foto' => $nm_foto,
            'status_id' => 1,
            'apps_id' => 0
        ];

        //Save to database
        $simpan = $this->dbTenagakerja->save($data);
        if ($simpan) {
            $data_detail = [
                'pegawai_id' => $pegawai_id,
                'no_identitas' => $no_identitas,
                'tempat_lahir' => $tmp_lahir,
                'tanggal_lahir' => $tgl_lahir,
                'jenis_kelamin' => $jns_kelamin,
                'alamat' => $alamat,
                'telepon' => $telepon
            ];

            $simpan_detail = $this->dbTenagakerjaDetail->save($data_detail);
            if ($simpan_detail) {
                session()->setFlashData('success', 'Data Tenagakerja berhasil di perbarui.');
            } else {
                session()->setFlashData('danger', 'Data Detail Tenagakerja Gagal Di Perbarui.');
            }
        } else {
            session()->setFlashData('danger', 'Data Tenagakerja Gagal Diperbarui.');
        }

        $this->session->set('smk', $penempatan_id);

        return redirect()->to('/tenagakerja_info_detail');
    }

    public function delete()
    {
        $nip_tk = $this->request->getGet("nip");
        $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailByNIP($nip_tk);
        if (is_null($dtTenagakerja)) {
            return redirect()->to("/tenagakerja_info_detail?nip=$nip_tk");
        }
        if ($this->dbTenagakerja->delete($nip_tk)) {
            session()->setFlashData('success', 'Data Tenagakerja berhasil di hapus');
        } else {
            session()->setFlashData('success', 'Data Tenagakerja GAGAL di hapus');
        }
    }

    /**
     * AJAX FOR DATA TENAGAKERJA
     */

    public function delete_by_ajax($id)
    {
        if ($this->dbTenagakerja->delete($id)) {
            $status = array('status' => 'success');
        } else {
            $status = array('status' => 'failed');
        }
        echo json_encode($status);
    }

    public function ajax_get_data_tenagakerjadetail()
    {
        $mitrakerja_id = $this->request->getVar('data_id');
        $mitrakerja_id = 1;
        $dbHelperTenagakerja = new DbHelperTenagakerja();

        $dtTenagakerja = $dbHelperTenagakerja->getForTabelTenagakerja($this->appID, $mitrakerja_id);

        $data = array();
        $no = $_POST['start'];

        foreach ($dtTenagakerja as $tenagakerja) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $tenagakerja->nip;
            $row[] = $tenagakerja->nama;
            $row[] = $tenagakerja->jabatan;
            $row[] = $tenagakerja->unitkerja;
            $row[] = $tenagakerja->penempatan;
            $row[] = $tenagakerja->wilayahkerja;

            $row[] = $this->action($tenagakerja->id, $tenagakerja->nip, $tenagakerja->nama);

            $data[] = $row;
        }

        $output = array(
            "draw"                 => $_POST['draw'],
            "recordsTotal"         => $dbHelperTenagakerja->count_all($this->appID, $mitrakerja_id),
            "recordsFiltered"      => $dbHelperTenagakerja->count_filtered($this->appID, $mitrakerja_id),
            "data"                 => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function action($tenagakerja_id, $tenagakerja_nip, $tenagakerja_nama)
    {
        //$action = "<div class='btn-group'> <button type='button' class='btn btn-success btn-sm' title='Edit' onclick='editData(\"$tenagakerja_nip\")'><i class='fa fa-edit'></i> Edit</button> <button type='button' class='btn btn-danger btn-sm' title='Hapus' onclick='deleteData($tenagakerja_id,\"$tenagakerja_nama\");'><i class=' fa fa-trash-alt'></i> Hapus</button> </div>";
        $action = "<div class='btn-group'> <button type='button' class='btn btn-success btn-sm' title='Informasi Detail' onclick='info_detail(\"$tenagakerja_nip\")'><i class='fa fa-info'></i> <strong>Detail</strong></button></div>";
        return $action;
    }

    /**
     * IMPORT FOR DATA TENAGAKERJA
     */

    public function import_xlsx()
    {
        $user_id = $this->user_id;
        $tgl_update = date('Y-m-d H:i:s');

        $jml_import = 0;
        $jml_import_ada = 0;

        $stat_import = "";
        $ket_import = "";

        $row_number = 0;

        $jmlKontrakSdhAda = 0;
        $jmlKontrakTdkDitemukan = 0;

        //validasi file yang akan di import
        $validation = \Config\Services::validation();
        $file = $this->request->getFile('imp_file');
        $data = array('imp_file' => $file);

        $redirectPath = '/kontrak_pks_import';

        if ($validation->run($data, 'import_excel') == FALSE) {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to($redirectPath);
        } else {

            // ambil extension dari file excel
            $extension = $file->getClientExtension();

            // format excel 2007 ke bawah
            if ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                // format excel 2010 ke atas
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($file);

            $data = $spreadsheet->getActiveSheet()->toArray();

            $tenagakerjaModel = new M_tenagakerja_detail();
            $batchData = array();
            foreach ($data as $idx => $row) {
                //Cek kolom terakhir file import
                //Jika panjang kolom tidak sesuai berarti salah file import
                if ($row_number == 1) {
                    $cek_cols = count($row);
                    if ($cek_cols != 16) {
                        $stat_import = "GAGAL IMPORT KONTRAK: Kolom file import tidak sesuai. Proses import Kontrak dibatalkan.";
                        break;
                    }
                }

                // lewati baris ke 0 dan ke 1 pada file excel
                // dalam kasus ini, array ke 0 adalah paratitle
                if ($idx === 0 || $idx === 1) {
                    continue;
                }

                //Set row number
                $row_number++;

                // get data kontrak from excel
                $sts_kontrak = $this->dbHelperKontrak->getStatusKontrakIdByNama(trim($row[1]));
                $no_io = trim($row[3]);
                $no_kontrak = trim($row[4]);
                $unitkerja = $this->dbHelperKontrak->getUnitkerjaIdByNama(trim($row[5]));
                $customer = $this->dbHelperKontrak->getCustomerIdByNama(trim($row[6]));
                $uraian_pekerjaan = trim($row[7]);
                $jns_pekerjaan = $this->dbHelperKontrak->getJenisPekerjaanIdByNama(trim($row[8]));
                $sub_jns_pekerjaan = $this->dbHelperKontrak->getSubJenisPekerjaanByNama(trim($row[9]));
                $tgl_mulai = $row[10];
                $tgl_akhir = $row[11];

                $nil_kontrak_perbln_ppn = trim($row[12]);
                $nil_kontrak_perbln_ppn = str_replace(',', '', $nil_kontrak_perbln_ppn);
                $nil_kontrak_perbln_ppn = str_replace('.', ',', $nil_kontrak_perbln_ppn);

                $nil_kontrak_total_ppn = trim($row[13]);
                $nil_kontrak_total_ppn = str_replace(',', '', $nil_kontrak_total_ppn);
                $nil_kontrak_total_ppn = str_replace('.', ',', $nil_kontrak_total_ppn);

                $jml_tad =  trim($row[14]);
                $keterangan =  trim($row[15]);

                $cekKontrakByNoSPK = $this->dbHelperKontrak->getKontrakIdByNoP1($no_kontrak);

                //Validasi data import
                if ($sts_kontrak == "") {
                    break;
                }

                if (!is_null($cekKontrakByNoSPK)) {
                    $jmlKontrakSdhAda++;
                    continue;
                }

                if (is_null($unitkerja)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Nama Unit Kerja '" . $row[4] . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($customer)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Nama Customer '" . $row[5] . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($jns_pekerjaan)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Jenis pekerjaan '" . $row[7] . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($sub_jns_pekerjaan)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Sub Jenis pekerjaan '" . $row[8] . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                $imp_data = [
                    "perusahaan_id" => $unitkerja->id,
                    "customer_id" => $customer->id,
                    "no_io" => $no_io,
                    "no_pks_p1" => $no_kontrak,
                    "uraian_pekerjaan" => $uraian_pekerjaan,
                    "kategori_pekerjaan_id" => $jns_pekerjaan->kategori_id,
                    "jenis_pekerjaan_id" => $jns_pekerjaan->id,
                    "sub_jenis_pekerjaan_id" => $sub_jns_pekerjaan->id,
                    "tanggal_awal" => date('Y-m-d', strtotime($tgl_mulai)),
                    "tanggal_akhir" => date('Y-m-d', strtotime($tgl_akhir)),
                    "nilai_bulan_ppn" => $nil_kontrak_perbln_ppn,
                    "nilai_total_ppn" => $nil_kontrak_total_ppn,
                    "jumlah_tad" => $jml_tad,
                    "keterangan" => $keterangan,
                    "status_id" => $sts_kontrak->id,
                    "update_tanggal" => $tgl_update,
                    "update_oleh" => $user_id
                ];

                // Save data to batch
                $batchData[] = $imp_data;
            }

            if ($stat_import == "") {
                if (count($batchData) != 0) {
                    $simpan = $tenagakerjaModel->insertBatchDataFromXls($batchData);
                    $jml_import = $simpan;
                    $ket_import = $jml_import . ' Data Kontrak berhasil di import.';
                }
            }

            if ($stat_import != "") {
                session()->setFlashdata('danger2', $stat_import);
            } else {
                if ($jml_import == 0) {
                    if ($jmlKontrakSdhAda > 0) {
                        session()->setFlashdata('warning', 'Proses Import Dibatalkan!!!<br>Data Kontrak sudah ada dalam database.<br>Silahkan cek kembali file excel yang telah di import.');
                    } else if ($jmlKontrakTdkDitemukan > 0) {
                        session()->setFlashdata('warning', 'Tidak ditemukan data kontrak pada file excel dari ' . $jmlKontrakTdkDitemukan . ' row data yang di import.');
                    } else {
                        session()->setFlashdata('warning', 'Data Kontrak tidak berhasil di import.<br>Silahkan cek kembali file excel yang telah di import.');
                    }
                } else {
                    if ($simpan) {
                        session()->setFlashdata('success', $ket_import);
                    }
                }
            }

            return redirect()->to($redirectPath);
        }
    }
}
