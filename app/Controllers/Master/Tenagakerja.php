<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHelperTenagakerja;

use App\Models\M_jabatan;
use App\Models\M_mitrakerja;
use App\Models\M_otoritas;
use App\Models\M_tenagakerja;
use App\Models\M_unitkerja;

class Tenagakerja extends BaseController
{
    protected $dbHelper;
    protected $dbTenagakerja;
    protected $dbJabatan;

    protected $dbOtoritasUser;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbTenagakerja = new M_tenagakerja();
        $this->dbJabatan = new M_jabatan();

        $this->dbOtoritasUser = new M_otoritas();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);

        //get tenagakerja by selected mitrakerja
        if ($this->session->has('smk')) {
            $selMitrakerja = $this->session->smk;
            $dtTenagakerja = $this->dbHelper->getTenagakerjaPenempatan($this->appID, $selMitrakerja);
        } else {
            $selMitrakerja = "";
            $dtTenagakerja = $this->dbHelper->getTenagakerjaPenempatan($this->appID, $this->dtAksesMitra);
        }

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('tenagakerja/tenagakerja.js', "appjs");

        $this->dtContent['title'] = "Tenagakerja";
        $this->dtContent['page'] = "tenagakerja";

        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        $this->dtContent['selMitraKerja'] = $selMitrakerja;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function add()
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
        $dtOtoritas = $this->dbOtoritasUser->getOtorisasi();

        $this->dtContent['title'] = "Tambah Tenagakerja";
        $this->dtContent['page'] = "tenagakerja_add";
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtWilayahKerja'] = $dtWilayahKerja;
        $this->dtContent['dtOtoritas'] = $dtOtoritas;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $selDtTenagakerja = $this->dbTenagakerja->getTenagakerja($id);
        $dtJabatan = $this->dbJabatan->getJabatan($this->appID);
        $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);
        $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);
        $dtOtoritas = $this->dbOtoritasUser->getOtorisasi();

        $this->dtContent['title'] = "Edit Tenagakerja";
        $this->dtContent['page'] = "tenagakerja_edit";
        $this->dtContent['dtTenagakerja'] = $selDtTenagakerja;
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtOtoritas'] = $dtOtoritas;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $nip = $this->request->getVar('nip');
        $password = password_hash($nip, PASSWORD_BCRYPT);
        $penempatan_id = $this->request->getVar('penempatan'); //penempatan_id as mitrakerja_id
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
        $simpan = $this->dbTenagakerja->save($data);
        if ($simpan) {
            session()->setFlashData('success', 'Data Tenagakerja berhasil ditambahkan.');
        } else {
            session()->setFlashData('danger', 'Data Tenagakerja Gagal Ditambahkan.');
        }

        $this->session->set('smk', $penempatan_id);

        return redirect()->to('/tenagakerja');
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
        $simpan = $this->dbTenagakerja->save($data);

        if ($simpan) {
            session()->setFlashData('success', 'Data Tenagakerja berhasil diupdate.');
        } else {
            session()->setFlashData('danger', 'Data Tenagakerja Gagal Diupdate.');
        }

        return redirect()->to('/tenagakerja');
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

    public function ajax_get_data_tenagakerja()
    {
        $mitrakerja_id = $this->request->getVar('data_id');
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
            $row[] = $tenagakerja->wilayah;

            $row[] = $this->action($tenagakerja->id, $tenagakerja->nama);

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

    function action($tenagakerja_id, $tenagakerja_nama)
    {
        $action = "<div class='btn-group'> <button type='button' class='btn btn-success btn-sm' title='Edit' onclick='location.href=\"" . base_url('tenagakerja_edit/' . $tenagakerja_id) . "\";'><i class='fa fa-edit'></i> Edit</button> <button type='button' class='btn btn-danger btn-sm' title='Hapus' onclick='deleteData($tenagakerja_id,\"$tenagakerja_nama\");'><i class=' fa fa-trash-alt'></i> Hapus</button>
        </div>";
        return $action;
    }

    /**
     * IMPORT DATA TENAGAKERJA
     */
    public function import_data()
    {
        $jml_import = 0;
        $jml_import_ada = 0;

        $stat_import = "";
        $ket_import = "";

        $row_number = 0;

        $jmlKontrakSdhAda = 0;
        $jmlKontrakTdkDitemukan = 0;

        //$dbHelper = new DbHelper();
        $dbUnitkerja = new M_unitkerja();
        $dbMitrakerja = new M_mitrakerja();

        $validation = \Config\Services::validation();
        $file = $this->request->getFile('imp_file');
        $file_import = array('imp_file' => $file);

        $redirectPath = '/tenagakerja';

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
                $idMK = $dbMitrakerja->getMitraKerjaIdByNamaSingkat(trim($row[5]));

                $jabatan_id = $idJbt['id'];
                $unitkerja_id = $idUK['id'];
                $penempatan_id = $idMK['id'];

                $kata_kunci = password_hash($nip, PASSWORD_BCRYPT);

                //Validasi data import

                if ($nip == "") {
                    $stat_import = "GAGAL IMPORT : <br> Row Number: " . $row_number . " <br> Err desk: 'NIP / Id Tenagakerja tidak boleh kosong'. <br>Proses import Kontrak dibatalkan.";
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
                    $simpan = $this->dbTenagakerja->insertBatchDataFromXls($batchData);
                    $jml_import = $simpan;
                    $ket_import = $jml_import . ' Data Tenagakerja berhasil di import.';
                }

                if ($jml_import == 0) {
                    // if ($jmlKontrakSdhAda > 0) {
                    //     session()->setFlashdata('warning', 'Proses Import Dibatalkan!!!<br>Data Kontrak sudah ada dalam database.<br>Silahkan cek kembali file excel yang telah di import.');
                    // } else if ($jmlKontrakTdkDitemukan > 0) {
                    //     session()->setFlashdata('warning', 'Tidak ditemukan data kontrak pada file excel dari ' . $jmlKontrakTdkDitemukan . ' row data yang di import.');
                    // } else {
                    session()->setFlashdata('warning', 'Data Tenaga Kerja tidak berhasil di import.<br>Silahkan cek kembali file excel yang telah di import.');
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
