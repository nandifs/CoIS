<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHelperPegawai;

use App\Models\M_jabatan;
use App\Models\M_mitrakerja;
use App\Models\M_otoritas;
use App\Models\M_pegawai;
use App\Models\M_unitkerja;

class Pegawai extends BaseController
{
    protected $dbHelper;
    protected $dbPegawai;
    protected $dbJabatan;

    protected $dbOtoritasUser;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbPegawai = new M_pegawai();
        $this->dbJabatan = new M_jabatan();

        $this->dbOtoritasUser = new M_otoritas();
    }

    public function index()
    {
        $dtUnitkerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);
        //get pegawai by selected mitrakerja
        if ($this->session->has('smk')) {
            $selUnitkerja = $this->session->smk;
        } else {
            if ($this->dtAksesUnit == "9999") {
                $selUnitkerja = $dtUnitkerja[0]['id'];
            } else {
                $selUnitkerja = $this->dtAksesUnit;
            }
        }

        $dtPegawai = $this->dbHelper->getPegawaiByUnitkerja($selUnitkerja);

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('pegawai/pegawai.js', "appjs");

        $this->dtContent['title'] = "Pegawai";
        $this->dtContent['page'] = "pegawai";

        $this->dtContent['dtPegawai'] = $dtPegawai;
        $this->dtContent['dtUnitkerja'] = $dtUnitkerja;

        $this->dtContent['selUnitkerja'] = $selUnitkerja;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function add()
    {
        $selUnitkerja = $this->request->getVar("dtakses");

        $dtJabatan = $this->dbJabatan->getJabatan($this->appID);

        if (is_null($selUnitkerja)) {
            $dtUnitkerja = $this->dbHelper->getUnitKerja($this->dtAksesMitra);
        } else {
            $dtUnitkerja = $this->dbHelper->getUnitKerja($selUnitkerja);
        }
        //dd($dtUnitkerja);

        $dtDivisi = $this->dbHelper->getDivisi();

        $dtOtoritas = $this->dbOtoritasUser->getOtorisasi();

        $this->dtContent['title'] = "Tambah Pegawai";
        $this->dtContent['page'] = "pegawai_add";
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitkerja'] = $dtUnitkerja;
        $this->dtContent['dtDivisi'] = $dtDivisi;
        $this->dtContent['dtOtoritas'] = $dtOtoritas;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        $selDtPegawai = $this->dbPegawai->getPegawai($id);
        $dtJabatan = $this->dbJabatan->getJabatan($this->appID);
        $dtUnitkerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);

        $dtDivisi = $this->dbHelper->getDivisi();

        $dtOtoritas = $this->dbOtoritasUser->getOtorisasi();

        $this->dtContent['title'] = "Edit Pegawai";
        $this->dtContent['page'] = "pegawai_edit";
        $this->dtContent['dtPegawai'] = $selDtPegawai;
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitkerja'] = $dtUnitkerja;
        $this->dtContent['dtDivisi'] = $dtDivisi;
        $this->dtContent['dtOtoritas'] = $dtOtoritas;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $nip = $this->request->getVar('nip');
        $password = password_hash($nip, PASSWORD_BCRYPT);
        $penempatan_id = $this->request->getVar('penempatan'); //penempatan_id as unitkerja_id
        $data = [
            'nip' => $nip,
            'nama' => $this->request->getVar('nama'),
            'jabatan_id' => $this->request->getVar('jabatan'),
            'unitkerja_id' => $this->request->getVar('unitkerja'),
            'penempatan_id' => $penempatan_id,
            'email' => $this->request->getVar('email'),
            'otoritas_id' => $this->request->getVar('otoritas'),
            'kata_kunci' => $password,
            'status_id' => 1,
            'apps_id' => $this->appID
        ];

        //Save to database
        $simpan = $this->dbPegawai->save($data);
        if ($simpan) {
            session()->setFlashData('success', 'Data Pegawai berhasil ditambahkan.');
        } else {
            session()->setFlashData('danger', 'Data Pegawai Gagal Ditambahkan.');
        }

        $this->session->set('smk', $penempatan_id);

        return redirect()->to('/pegawai');
    }

    public function update($id)
    {
        $nip = $this->request->getVar('nip');
        $password = $this->request->getVar('password');

        $data = [
            'id' => $id,
            'nip' => $nip,
            'nama' => $this->request->getVar('nama'),
            'jabatan_id' => $this->request->getVar('jabatan'),
            'unitkerja_id' => $this->request->getVar('unitkerja'),
            'penempatan_id' => $this->request->getVar('penempatan'),
            'email' => $this->request->getVar('email'),
            'otoritas_id' => $this->request->getVar('otoritas'),
            'status_id' => $this->request->getVar('status')
        ];

        if ($password == "#reset") {
            $newPassword = password_hash($nip, PASSWORD_BCRYPT);
            $data['kata_kunci'] = $newPassword;
        }

        //Save to database
        $simpan = $this->dbPegawai->save($data);

        if ($simpan) {
            session()->setFlashData('success', 'Data Pegawai berhasil diupdate.');
        } else {
            session()->setFlashData('danger', 'Data Pegawai Gagal Diupdate.');
        }

        return redirect()->to('/pegawai');
    }

    public function delete($id)
    {
        $this->dbPegawai->delete($id);
        session()->setFlashData('sweet', 'Data Pegawai berhasil dihapus.');
        return redirect()->to('/pegawai');
    }

    /**
     * AJAX FOR DATA PEGAWAI
     */

    public function delete_by_ajax($id)
    {
        if ($this->dbPegawai->delete($id)) {
            $status = array('status' => 'success');
        } else {
            $status = array('status' => 'failed');
        }
        echo json_encode($status);
    }

    public function ajax_data_pegawai()
    {
        $unitkerja_id = $this->request->getVar('data_id');

        $dbHelperPegawai = new DbHelperPegawai();
        $listPegawai = $dbHelperPegawai->getForTabelPegawai($unitkerja_id);

        $data = array();
        $no = $_POST['start'];

        foreach ($listPegawai as $pegawai) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pegawai->nip;
            $row[] = $pegawai->nama;
            $row[] = $pegawai->jabatan;
            $row[] = $pegawai->unitkerja;
            $row[] = $pegawai->penempatan;

            $row[] = $this->action($unitkerja_id, $pegawai->id, $pegawai->nama);

            $data[] = $row;
        }

        $output = array(
            "draw"                 => $_POST['draw'],
            "recordsTotal"         => $dbHelperPegawai->count_all($unitkerja_id),
            "recordsFiltered"      => $dbHelperPegawai->count_filtered($unitkerja_id),
            "data"                 => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function action($unitkerja_id, $pegawai_id, $pegawai_nama)
    {
        $action = "<div class='btn-group'> <button type='button' class='btn btn-success btn-sm' title='Edit' onclick='location.href=\"" . base_url('pegawai/edit/' . $pegawai_id) . "\";'><i class='fa fa-edit'></i> Edit</button> <button type='button' class='btn btn-danger btn-sm' title='Hapus' onclick='deleteData($pegawai_id,\"$pegawai_nama\");'><i class=' fa fa-trash-alt'></i> Hapus</button>
        </div>";
        return $action;
    }

    /**
     * IMPORT DATA PEGAWAI
     */
    public function import_data()
    {
        $jml_import = 0;
        $jml_import_ada = 0;

        $stat_import = "";
        $ket_import = "";

        $row_number = 0;

        //$dbHelper = new DbHelper();
        $dbUnitkerja = new M_unitkerja();
        $dbUnitkerja = new M_mitrakerja();

        $validation = \Config\Services::validation();
        $file = $this->request->getFile('imp_file');
        $file_import = array('imp_file' => $file);

        $redirectPath = '/pegawai';

        if ($validation->run($file_import, 'import_excel') == FALSE) {
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

            $batchData = array();
            foreach ($data as $idx => $row) {

                //Cek kolom terakhir file import
                //Jika panjang kolom tidak sesuai berarti salah file import
                if ($row_number == 0) {
                    $cek_cols = count($row);
                    if ($cek_cols != 7) {
                        $stat_import = "GAGAL IMPORT KONTRAK: Kolom file import tidak sesuai. Proses import Kontrak dibatalkan.";
                        break;
                    }
                }

                // lewati baris ke 0 pada file excel
                // dalam kasus ini, array ke 0 adalah paratitle
                if ($idx === 0) {
                    continue;
                }

                //Set row number
                $row_number++;

                // get data kontrak from excel
                $nip = trim($row[1]);
                $nama = trim($row[2]);
                $email = trim($row[6]);

                $idJbt = $this->dbJabatan->getJabatanIdBySingkatan(trim($row[3]));
                $idUK = $dbUnitkerja->getUnitKerjaIdByNamaSingkat(trim($row[4]));
                $idMK = $dbUnitkerja->getUnitKerjaIdByNamaSingkat(trim($row[5]));

                $jabatan_id = $idJbt['id'];
                $unitkerja_id = $idUK['id'];
                $penempatan_id = $idMK['id'];

                $kata_kunci = password_hash($nip, PASSWORD_BCRYPT);

                //Validasi data import

                if ($nip == "") {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: 'NIP / Id Pegawai tidak boleh kosong'. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($jabatan_id)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Jabatan '" . $row[3] . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($unitkerja_id)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Unit Kerja '" . $row[4] . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                if (is_null($penempatan_id)) {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: Mitra Kerja '" . $row[5] . "' tidak ditemukan. <br>Proses import Kontrak dibatalkan.";
                    break;
                }

                $data = [
                    "apps_id" => $this->appID,
                    "nip" => $nip,
                    "nama" => $nama,
                    "jabatan_id" => $jabatan_id,
                    "unitkerja_id" => $unitkerja_id,
                    "penempatan_id" => $penempatan_id,
                    "email" => $email,
                    "kata_kunci" => $kata_kunci,
                    "otoritas_id" => 4,
                    "status_id" => 1
                ];
                // Save data to batch
                $batchData[] = $data;
            }

            if ($stat_import != "") {
                session()->setFlashdata('danger2', $stat_import);
            } else {
                if (count($batchData) != 0) {
                    $simpan = $this->dbPegawai->insertBatchDataFromXls($batchData);
                    $jml_import = $simpan;
                    $ket_import = $jml_import . ' Data Pegawai berhasil di import.';
                }

                if ($jml_import == 0) {
                    // if ($jmlKontrakSdhAda > 0) {
                    //     session()->setFlashdata('warning', 'Proses Import Dibatalkan!!!<br>Data Kontrak sudah ada dalam database.<br>Silahkan cek kembali file excel yang telah di import.');
                    // } else if ($jmlKontrakTdkDitemukan > 0) {
                    //     session()->setFlashdata('warning', 'Tidak ditemukan data kontrak pada file excel dari ' . $jmlKontrakTdkDitemukan . ' row data yang di import.');
                    // } else {
                    session()->setFlashdata('warning', 'Data Pegawai tidak berhasil di import.<br>Silahkan cek kembali file excel yang telah di import.');
                    // }
                } else {
                    if ($simpan) {
                        session()->setFlashdata('success', $ket_import);
                    }
                }
            }

            return redirect()->to($redirectPath);
        }
    }

    //--------------------------------------------------------------------

}
