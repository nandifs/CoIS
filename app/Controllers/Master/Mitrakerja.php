<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Models\M_mitrakerja;
use App\Models\M_unitkerja;

class Mitrakerja extends BaseController
{
    protected $dbHelper;
    protected $dbUnitkerja;
    protected $dbMitrakerja;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbUnitkerja = new M_unitkerja();
        $this->dbMitrakerja = new M_mitrakerja();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $page = getControllerName();
        $appJS = loadJS($page . "/form.js", 'appjs');

        $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);
        $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);
        $dtMitkerByKelas = $this->dbMitrakerja->getMitraKerjaByKelas([1, 2]);

        $this->dtContent['title'] = "Mitra Kerja";
        $this->dtContent['page'] = $page;

        $this->dtContent['dtUnitker'] = $dtUnitKerja;
        $this->dtContent['dtMitker'] = $dtMitraKerja;
        $this->dtContent['dtMitkerInduk'] = $dtMitkerByKelas;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function update_data()
    {
        $data_id = $this->request->getVar('data_id');

        $mitrakerja = strtoupper($this->request->getVar('nama_mitrakerja'));
        $singkatan = strtoupper($this->request->getVar('nama_singkat'));

        $kelas_id = $this->request->getVar('kelas_id');
        $induk_id = $this->request->getVar('induk_id');
        $unitkerja_id = $this->request->getVar('unitkerja_id');

        if ($data_id == "") {
            //if add new record
            $kode_unit = $this->generate_kode_unit($induk_id, $kelas_id);
        } else {
            //if update record/data
            $kode_unit = $this->request->getVar('kode_unit');

            $pre_kelas_id = $this->request->getVar('pre_kelas');
            $pre_induk_id = $this->request->getVar('pre_induk_id');

            if ($kelas_id == 1) {
                $induk_id = $data_id;
            }

            if ($pre_kelas_id != $kelas_id || $pre_induk_id != $induk_id) {
                $kode_unit = $this->generate_kode_unit($induk_id, $kelas_id);
            }
        }

        $data = [
            'kode' => $kode_unit,
            'mitrakerja' => $mitrakerja,
            'singkatan' => $singkatan,
            'kelas' => $kelas_id,
            'induk_id' => $induk_id,
            'unitkerja_id' => $unitkerja_id
        ];

        if ($data_id != "") {
            //add new record/data
            $data['id'] = $data_id;
            $msgE = 'Data Mitra Kerja berhasil diupdate.';
        } else {
            //update record/data
            //Check if nama_instansi sudah ada di dalam database
            $qSearch = "mitrakerja='" . $mitrakerja . "' OR singkatan='" . $singkatan . "'";
            $chkDuplicated = $this->dbMitrakerja->checkDuplicateEntry($qSearch);

            if ($chkDuplicated > 0) {
                $returnData = array('status' => 'duplicated', 'message' => "Duplicated Entry");
                echo json_encode($returnData);
                return;
            } else {
                $msgE = 'Data Mitra Kerja berhasil ditambahkan.';
            }
        }

        //Save to database
        $simpan = $this->dbMitrakerja->save($data);
        if ($simpan) {
            $lastId = ($data_id == "") ? $this->dbMitrakerja->getInsertID() : "-";
            //If kelas = Pusat/Utama, kode induk isi dengan id unit tersebut
            if ($data_id == "") {
                //if add new data
                if ($kelas_id == 1) {
                    $data_update = [
                        'id' => (($lastId != "-") ? $lastId : $data_id),
                        'induk_id' => (($lastId != "-") ? $lastId : $data_id)
                    ];
                    $this->dbMitrakerja->save($data_update);
                }
            }

            $returnData = array('status' => 'success', 'message' => $msgE, 'data' => $lastId);
        } else {
            $returnData = array('status' => 'failed', 'message' => $simpan);
        }

        echo json_encode($returnData);
    }

    public function delete($id)
    {
        if ($this->oto_id == "99" || $this->oto_id == "1" || $this->oto_id == "2") {
            if ($this->dbMitrakerja->delete($id)) {
                $status = array('status' => 'success');
            } else {
                $status = array('status' => 'failed');
            }
            echo json_encode($status);
        } else {
            return redirect()->to("/");
        }
    }

    //--------------------------------------------------------------------

    protected function generate_kode_unit($induk_id, $kelas)
    {
        $lastKdUnit = $this->dbHelper->getLastKodeMitra($induk_id, $kelas);
        $newKd = ((int) $lastKdUnit->max_kode) + 1;
        $newKD = str_repeat('0', 3 - strlen($newKd)) . $newKd;

        if ($kelas == 1) {
            $newKD = $newKD . str_repeat('0', 6);
        } else if ($kelas == 2) {
            $dtInduk = $this->dbHelper->getDataByQuery('org__mitrakerja', 'kode', "id=$induk_id")->getRow();
            $psInduk = substr($dtInduk->kode, 0, 3);

            $newKD = $psInduk . $newKD . "000";
        } else if ($kelas == 3) {
            $dtInduk = $this->dbHelper->getDataByQuery('org__mitrakerja', 'kode', "id=$induk_id")->getRow();
            $psInduk = substr($dtInduk->kode, 0, 6);
            $newKD = $psInduk . $newKD;
        }
        //dd($newKD);
        return $newKD;
    }
    //--------------------------------------------------------------------

    /** AJAX */
    public function ajax_get_mitrakerja()
    {
        $data_id = $this->request->getVar('data_id');
        $dtMitraKerja = $this->dbMitrakerja->getMitraKerja($data_id);

        echo json_encode($dtMitraKerja);
    }

    public function ajax_get_mitrakerjabykelas($kelas_id)
    {
        $arr_kelas = explode(",", $kelas_id);
        $dtMitraKerja = $this->dbMitrakerja->getMitraKerjaByKelas($arr_kelas, $this->dtAksesMitra);

        echo json_encode($dtMitraKerja);
    }
}
