<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHelperTenagakerja;

use App\Models\M_jabatan;
use App\Models\M_tenagakerja;
use App\Models\M_tenagakerja_detail;
use App\Models\M_tenagakerja_temporary;

class Tenagakerjadetail extends BaseController
{
    protected $dbHelper;
    protected $dbTenagakerja;
    protected $dbTenagakerjaDetail;
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
        $this->dtContent['page'] = "tenagakerja_detail";

        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        $this->dtContent['selMitraKerja'] = $selDtAkses;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function laporan()
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

        $filter_temp = ["import_oleh " => $this->user_id];
        $dtTenagakerjaTemp = $this->dbHelper->getTenagakerjaTemporary($filter_temp);

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('tenagakerja/data_tenagakerja.js', 'appjs');

        $this->dtContent['title'] = "Data Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_import";

        $this->dtContent['dtTenagakerjaTemp'] = $dtTenagakerjaTemp;
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
            $row[] = $tenagakerja->status_tenagakerja;
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

    public function validasi_data_import_tk_xlsx()
    {
        $user_id = $this->user_id;

        //hapus data kontrak di tabel temporary jika sudah ada data dengan user dan tanggal import yang sama
        $filter_deleted = ["import_oleh" => $user_id];
        $this->dbHelper->deleteTenagakerjaTemporary($filter_deleted);

        $cek_file_import = "OK";

        $jml_data_baru = 0;
        $jml_data_updated = 0;

        $jml_data_gl = 0; //jumlah data tidak dapat diimport/Gagal Import

        $row_number = 0;

        //validasi file excel yang akan di import
        $validation = \Config\Services::validation();
        $file = $this->request->getFile('imp_file');
        $datafile = array('imp_file' => $file);

        $redirectPath = '/tenagakerja_import_detail';

        if ($validation->run($datafile, 'import_excel') == FALSE) {
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

            $dtTenagakerjaTemp = new M_tenagakerja_temporary();

            $batchData = array();
            foreach ($data as $idx => $row) {
                //Cek kolom terakhir file import
                //Jika panjang kolom tidak sesuai berarti salah file import
                if ($row_number == 0) {
                    $cek_cols = count($row);
                    if ($cek_cols != 63) {
                        $cek_file_import = "GAGAL IMPORT DATA TENAGA KERJA: Kolom file import tidak sesuai. Proses import dibatalkan.";
                        break;
                    }
                }

                // lewati baris ke 0 dan ke 1 pada file excel
                // dalam kasus ini, array ke 0 adalah paratitle                
                if ($idx < 4) {
                    continue;
                }

                //Set row number
                $row_number++;

                $status_import = "Import Data";
                $validasi = array();

                //cek and get kontrak id from kolom no pks
                $no_pks = trim($row[10]);
                $kontrak_pks = $this->dbHelper->getKontrakIdByNoP1($no_pks);
                $kontrak_pks_id = (is_null($kontrak_pks)) ? 0 : $kontrak_pks->id;

                // get data tenagakerja from excel
                $nip = trim($row[1]);
                $cek_tenagakerja = $this->dbHelper->getTenagakerjaIdByNIP($nip);
                $tenagakerja_id = (is_null($cek_tenagakerja)) ? 0 : $cek_tenagakerja->id;
                if (is_null($cek_tenagakerja)) {
                    $jml_data_baru++;
                } else {
                    $status_import = "Update Data";
                    $jml_data_updated++;
                }

                $nama = trim($row[2]);
                $tmp_lahir = trim($row[3]);
                $tgl_lahir = ubah_tgl_itm(trim($row[4]));

                $no_identitas = trim($row[5]);
                $jns_kel = trim($row[6]);
                $alamat = trim($row[7]);
                $telepon = trim($row[8]);
                $email = trim($row[9]);

                $no_pkwt = trim($row[11]);
                $tgl_awal = ubah_tgl_itm(trim($row[12]));
                $tgl_akhir = ubah_tgl_itm(trim($row[13]));

                //cek tanggal awal dan tanggal akhir pkwt/pkwtt

                $jabatan = trim($row[14]);
                $wil_kerja = trim($row[15]);
                $unit_kerja = trim($row[16]);
                $mitra_kerja = trim($row[17]);
                $penempatan = $mitra_kerja . " " . trim($row[18]);
                $keterangan = trim($row[19]);


                //cek and get id jabatan, wil_kerja, unitkerja, mitrakerja dan penempatan                
                $dtJabatan = $this->dbHelper->getJabatanIdBySingkatan($jabatan);
                $dtUnitkerja = $this->dbHelper->getUnitKerjaIdByNama($unit_kerja);
                $dtMitrakerja = $this->dbHelper->getMitrakerjaIdByNama($mitra_kerja);
                $dtPenempatan = $this->dbHelper->getMitrakerjaIdByNama($penempatan);
                $dtWilayah = $this->dbHelper->getWilayahKerjaIdBySingkatan($wil_kerja);

                $jabatan_id = (is_null($dtJabatan)) ? 0 : $dtJabatan->id;
                $unitkerja_id = (is_null($dtUnitkerja)) ? 0 : $dtUnitkerja->id;
                $mitrakerja_id = (is_null($dtMitrakerja)) ? 0 : $dtMitrakerja->id;
                $penempatan_id = (is_null($dtPenempatan)) ? 0 : $dtPenempatan->id;
                $wilayah_id = (is_null($dtWilayah)) ? 0 : $dtWilayah->id;

                $no_npwp = trim($row[20]);
                $no_kartu_keluarga = trim($row[21]);
                $no_bpjs_kt = trim($row[22]);
                $no_bpjs_ks = trim($row[23]);
                $no_rek_payroll = trim($row[24]);
                $bank_rek_payroll = trim($row[25]);
                $no_rek_dplk = trim($row[26]);
                $bank_rek_dplk = trim($row[27]);

                $dtBankPayroll = $this->dbHelper->getBankIdBySingkatan($bank_rek_payroll);
                $dtBankDPLK = $this->dbHelper->getBankIdBySingkatan($bank_rek_dplk);

                $bank_rek_payroll_id =  (is_null($dtBankPayroll)) ? 0 : $dtBankPayroll->id;
                $bank_rek_dplk_id =  (is_null($dtBankDPLK)) ? 0 : $dtBankDPLK->id;

                $pendidikan = trim($row[28]);

                $pendidikan = ($pendidikan == "STM") ? "SMK" : $pendidikan;
                $pendidikan = ($pendidikan == "SMU") ? "SLTA" : $pendidikan;

                $dtPendidikan = $this->dbHelper->getJenjangPendidikanByNama($pendidikan);
                $pendidikan_id =  (is_null($dtPendidikan)) ? 0 : $dtPendidikan->id;

                $prog_studi = trim($row[29]);

                $nama_ibu = trim($row[30]);
                $nama_pasangan = trim($row[31]);
                $nama_anak_1 = trim($row[32]);
                $nama_anak_2 = trim($row[33]);
                $nama_anak_3 = trim($row[34]);

                $no_skk1 = trim($row[35]);
                $no_skk2 = trim($row[36]);

                //Validasi data import
                if (is_null($kontrak_pks_id)) {
                    $validasi[] = "- Kontrak/SPK tidak ditemukan";
                }

                if (is_null($dtUnitkerja)) {
                    $validasi[] = "- Unit Kerja tidak ditemukan";
                }

                if (is_null($dtMitrakerja)) {
                    $validasi[] = "- Data Mitra Kerja/Customer tidak ditemukan";
                }

                if (is_null($dtPenempatan)) {
                    $validasi[] = "- Unit tempat penempatan tidak ditemukan";
                }

                if (is_null($dtWilayah)) {
                    $validasi[] = "- Wilayah kerja tidak ditemukan";
                }

                if (is_null($dtBankPayroll)) {
                    $validasi[] = "- Data Bank Rek Payroll tidak ditemukan";
                }

                if (is_null($dtBankDPLK)) {
                    $validasi[] = "- Data Bank Rek DPLK tidak ditemukan";
                }

                if (is_null($dtPendidikan)) {
                    $validasi[] = "- Jenjang Pendidikan '$pendidikan' tidak ditemukan";
                }

                if (empty($validasi)) {
                    $ket_validasi = "Menunggu konfirmasi";
                } else {
                    $status_import = "GAGAL IMPORT";
                    $ket_validasi = implode("<br>", $validasi);
                    $jml_data_gl++;
                }

                $imp_data = [
                    "status_import"  => $status_import,
                    "validasi"       => $ket_validasi,

                    "kontrak_pks_id" => $kontrak_pks_id,
                    "tenagakerja_id" => $tenagakerja_id,
                    "nip"  => $nip,
                    "nama" => $nama,

                    "no_identitas"  => $no_identitas,
                    "tempat_lahir"  => $tmp_lahir,
                    "tanggal_lahir" => $tgl_lahir,
                    "jenis_kelamin" => $jns_kel,
                    "alamat"  => $alamat,
                    "telepon" => $telepon,
                    "email"   => $email,

                    "no_pkwt"       => $no_pkwt,
                    "tanggal_awal"  => $tgl_awal,
                    "tanggal_akhir" => $tgl_akhir,

                    "jabatan_id"    => $jabatan_id,
                    "unitkerja_id"  => $unitkerja_id,
                    "mitrakerja_id" => $mitrakerja_id,
                    "penempatan_id" => $penempatan_id,
                    "wilayah_id"    => $wilayah_id,

                    "no_npwp"          => $no_npwp,
                    "no_kartu_keluarga" => $no_kartu_keluarga,
                    "no_bpjs_kt"       => $no_bpjs_kt,
                    "no_bpjs_ks"       => $no_bpjs_ks,
                    "no_rek_payroll"   => $no_rek_payroll,
                    "bank_rek_payroll" => $bank_rek_payroll,
                    "bank_rek_payroll_id" => $bank_rek_payroll_id,
                    "no_rek_dplk"      => $no_rek_dplk,
                    "bank_rek_dplk"    => $bank_rek_dplk,
                    "bank_rek_dplk_id"    => $bank_rek_dplk_id,

                    "pendidikan_id" => $pendidikan_id,
                    "program_studi"       => $prog_studi,

                    "nama_ibu"            => $nama_ibu,
                    "nama_pasangan_hidup" => $nama_pasangan,
                    "nama_anak_1"         => $nama_anak_1,
                    "nama_anak_2"         => $nama_anak_2,
                    "nama_anak_3"         => $nama_anak_3,

                    "no_skk_1" => $no_skk1,
                    "no_skk_2" => $no_skk2,

                    "keterangan" => $keterangan,

                    "import_tanggal" => date('Y-m-d H:i:s'),
                    "import_oleh" => $user_id
                ];

                // Save data to batch
                $batchData[] = $imp_data;
            }

            if ($cek_file_import == "OK") {
                if (count($batchData) != 0) {
                    $simpan = $dtTenagakerjaTemp->insertBatchDataFromXls($batchData);
                    if ($simpan) {
                        $jml_data_import = $simpan;
                        if ($jml_data_import == 0) {
                            session()->setFlashdata('warning', 'Data Tenaga kerja tidak berhasil di import.<br>Silahkan cek kembali file excel yang akan di import.');
                        } else {
                            $ket_hasil_validasi =  '<hr>' .
                                'Jumlah data yang akan di import   : ' . $jml_data_import . ' Data Ditemukan<br><br>' .

                                '- Data Baru      : ' . $jml_data_baru . ' Ditemukan.<br>' .
                                '- Pembaruan Data : ' . $jml_data_updated . ' Ditemukan.<br><br>';

                            if ($jml_data_gl == 0) {
                                $ket_hasil_validasi .= 'Proses Validasi Data Selesai. <br> Silahkan lanjutkan dengan mengklik tombol "KOMFIRMASI" di akhir halaman ini.';
                            } else {
                                $ket_hasil_validasi .= 'Hasil validasi : ' . $jml_data_gl . ' Data tidak dapat di import.<br><br>';
                                $ket_hasil_validasi .= 'FILE EXCEL TIDAK DAPAT DI IMPORT !!!<br><br> Cek kembali data pada file excel yang akan diimport.';
                            }
                            session()->setFlashdata('success-validation-import', $ket_hasil_validasi);
                        }
                    } else {
                        session()->setFlashdata('danger2', 'Data Tenaga kerja tidak berhasil di import.<br>Silahkan cek kembali file excel yang akan di import.');
                    }
                }
            } else {
                session()->setFlashdata('danger2', $cek_file_import);
            }

            return redirect()->to($redirectPath);
        }
    }

    public function proses_data_import_tk_xlsx()
    {
        $user_id = $this->user_id;

        $batchImportData = array();
        $batchUpdateData = array();

        $batchImportDataDetail = array();
        $batchUpdateDataDetail = array();

        $jml_import = 0;
        $jml_update = 0;

        $redirectPath = '/tenagakerja_import_detail';

        $filter_temp = ["import_oleh " => $user_id];
        $dtTenagakerjaTemp = $this->dbHelper->getTenagakerjaTemporary($filter_temp);

        foreach ($dtTenagakerjaTemp as $rowdata) {

            $status_import = $rowdata['status_import'];
            $validasi = $rowdata['validasi'];

            $nip = $rowdata['nip'];
            $kata_kunci = password_hash($nip, PASSWORD_BCRYPT);

            if (strtoupper($status_import) == 'IMPORT DATA') {
                if ($validasi == "Menunggu konfirmasi") {
                    $imp_data = [
                        "nip" => $nip,
                        "nama" => $rowdata['nama'],
                        "jabatan_id" => $rowdata['jabatan_id'],
                        "unitkerja_id" => $rowdata['unitkerja_id'],
                        "penempatan_id" => $rowdata['penempatan_id'],
                        "wilayah_id" => $rowdata['wilayah_id'],
                        "email" => $rowdata['email'],
                        "kata_kunci" => $kata_kunci,
                        "otoritas_id" => 4,
                        "status_id" => 1,
                        "apps_id" => 0
                    ];

                    // Save to batchdata
                    $batchImportData[] = $imp_data;
                }
            } else if (strtoupper($status_import) == 'UPDATE DATA') {
                if ($validasi == "Menunggu konfirmasi") {
                    $upd_data = [
                        "id" => $rowdata['tenagakerja_id'],
                        "nip" => $nip,
                        "nama" => $rowdata['nama'],
                        "jabatan_id" => $rowdata['jabatan_id'],
                        "unitkerja_id" => $rowdata['unitkerja_id'],
                        "penempatan_id" => $rowdata['penempatan_id'],
                        "wilayah_id" => $rowdata['wilayah_id'],
                        "email" => $rowdata['email'],
                        "kata_kunci" => $kata_kunci,
                        "otoritas_id" => 4,
                        "status_id" => 1,
                        "apps_id" => 0
                    ];

                    // Save to batchdata
                    $batchUpdateData[] = $upd_data;
                }
            }
        }

        if (count($batchImportData) != 0) {
            $simpan = $this->dbTenagakerja->insertBatchDataFromXls($batchImportData);
            $jml_import = $simpan;
        }

        if (count($batchUpdateData) != 0) {
            $simpan_update = $this->dbTenagakerja->updateBatchDataFromXls($batchUpdateData);
            $jml_update = $simpan_update;
        }

        //import data detail
        foreach ($dtTenagakerjaTemp as $rowdata) {
            $status_import = $rowdata['status_import'];
            $validasi = $rowdata['validasi'];

            $nip = $rowdata['nip'];
            $dtTenagakerja = $this->dbHelper->getTenagakerjaIdByNIP($nip);
            $pegawai_id = $dtTenagakerja->id;

            $imp_data_detail = [
                "pegawai_id" => $pegawai_id,
                "no_identitas" => $rowdata['no_identitas'],
                "tempat_lahir" => $rowdata['tempat_lahir'],
                "tanggal_lahir" => $rowdata['tanggal_lahir'],
                "jenis_kelamin" => $rowdata['jenis_kelamin'],
                "alamat" => $rowdata['alamat'],
                "telepon" => $rowdata['telepon'],
                "pendidikan_id" => $rowdata['pendidikan_id'],
                "program_studi" => $rowdata['program_studi'],
            ];

            if (strtoupper($status_import) == 'IMPORT DATA') {
                if ($validasi == "Menunggu konfirmasi") {
                    $batchImportDataDetail[] = $imp_data_detail;
                }
            } else if (strtoupper($status_import) == 'UPDATE DATA') {
                if ($validasi == "Menunggu konfirmasi") {
                    $batchUpdateDataDetail[] = $imp_data_detail;
                }
            }
        }

        if (count($batchImportDataDetail) != 0) {
            $simpan_detail = $this->dbTenagakerjaDetail->insertBatchDataFromXls($batchImportDataDetail);
        }

        if (count($batchUpdateDataDetail) != 0) {
            $simpan_update_detail = $this->dbTenagakerjaDetail->updateBatchDataFromXls($batchUpdateDataDetail);
        }

        //hapus data kontrak di tabel temporary jika sudah berhasil di import ke tabel utama
        if ($jml_import != 0 || $jml_update != 0) {
            $this->dbHelper->deleteTenagakerjaTemporary($filter_temp);
        }

        if (($jml_import + $jml_update) != 0) {
            $ket_import =  '<hr>' .
                'Jumlah data    : ' . $jml_import . '<br>' .
                'Data Baru      : ' . $jml_import . ' Berhasil di import.<br>' .
                'Pembaruan Data : ' . $jml_update . ' Berhasil di perbarui.<br><br>' .
                'Proses Import Data Selesai.';
            session()->setFlashdata('success-import', $ket_import);
        }

        return redirect()->to($redirectPath);
    }
}
