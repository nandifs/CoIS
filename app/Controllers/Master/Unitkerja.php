<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Models\M_unitkerja;
use App\Models\M_wilayahkerja;

class Unitkerja extends BaseController
{
    protected $dbHelper;

    protected $dbWilayah;
    protected $dbUnitkerja;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();

        $this->dbWilayah = new M_wilayahkerja();
        $this->dbUnitkerja = new M_unitkerja();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $page = getControllerName();
        $appJS = loadJS($page . "/form.js", 'appjs');
        $dtWilayah = $this->dbWilayah->getWilayahKerja();
        $dtUnitKerja = $this->dbHelper->getUnitKerja();
        $unitKerjaByKelas = $this->dbUnitkerja->getUnitKerjaByKelas([1, 2]);

        $this->dtContent['title'] = "Unit Kerja";
        $this->dtContent['page'] = $page;

        $this->dtContent['dtWilayah'] = $dtWilayah;
        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtUnitInduk'] = $unitKerjaByKelas;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function update_data()
    {
        $data_id = $this->request->getVar('data_id');

        $unitkerja = strtoupper($this->request->getVar('nama_unitkerja'));
        $singkatan = strtoupper($this->request->getVar('nama_singkat'));

        $kelas_id = strtoupper($this->request->getVar('kelas_id'));
        $induk_id = strtoupper($this->request->getVar('induk_id'));
        $wilayah_id = strtoupper($this->request->getVar('wilayah_id'));

        if ($data_id == "") {
            //if add new record
            $kode_unit = $this->generate_kode_unitkerja($induk_id, $kelas_id);
        } else {
            //if update record/data
            $kode_unit = $this->request->getVar('kode_unit');

            $pre_kelas_id = $this->request->getVar('pre_kelas');
            $pre_induk_id = $this->request->getVar('pre_induk_id');

            if ($kelas_id == 1) {
                $induk_id = $data_id;
            }

            if ($pre_kelas_id != $kelas_id || $pre_induk_id != $induk_id) {
                $kode_unit = $this->generate_kode_unitkerja($induk_id, $kelas_id);
            }
        }

        $data = [
            'kode' => $kode_unit,
            'unitkerja' => $unitkerja,
            'singkatan' => $singkatan,
            'kelas_id' => $kelas_id,
            'induk_id' => $induk_id,
            'wilayah_id' => $wilayah_id
        ];

        if ($data_id != "") {
            $data['id'] = $data_id;
            $msgE = 'Data Unit Kerja berhasil diupdate.';
        } else {
            //Check if nama_instansi sudah ada di dalam database
            $qSearch = "unitkerja='" . $unitkerja . "' OR singkatan='" . $singkatan . "'";
            $chkDuplicated = $this->dbUnitkerja->checkDuplicateEntry($qSearch);

            if ($chkDuplicated > 0) {
                $returnData = array('status' => 'duplicated', 'message' => "Duplicated Entry");
                echo json_encode($returnData);
                return;
            } else {
                $msgE = 'Data Unit Kerja berhasil ditambahkan.';
            }
        }

        //Save to database
        $simpan = $this->dbUnitkerja->save($data);
        if ($simpan) {
            $lastId = ($data_id == "") ? $this->dbUnitkerja->getInsertID() : "-";
            $returnData = array('status' => 'success', 'message' => $msgE, 'data' => $lastId);
        } else {
            $returnData = array('status' => 'failed', 'message' => $simpan);
        }

        echo json_encode($returnData);
    }

    public function delete($id)
    {
        if ($this->oto_id == "99" || $this->oto_id == "1" || $this->oto_id == "2") {
            if ($this->dbUnitkerja->delete($id)) {
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

    protected function generate_kode_unitkerja($induk_id, $kelas)
    {
        $lastKdUnit = $this->dbHelper->getLastKodeUnitkerja($induk_id, $kelas);
        $newKd = ((int) $lastKdUnit->max_kode) + 1;
        $newKD = str_repeat('0', 3 - strlen($newKd)) . $newKd;

        if ($kelas == 1) {
            $newKD = $newKD . str_repeat('0', 6);
        } else if ($kelas == 2) {
            $dtInduk = $this->dbHelper->getDataByQuery('org__unitkerja', 'kode', "id=$induk_id")->getRow();
            $psInduk = substr($dtInduk->kode, 0, 3);

            $newKD = $psInduk . $newKD . "000";
        } else if ($kelas == 3) {
            $dtInduk = $this->dbHelper->getDataByQuery('org__unitkerja', 'kode', "id=$induk_id")->getRow();
            $psInduk = substr($dtInduk->kode, 0, 6);
            $newKD = $psInduk . $newKD;
        }
        //dd($newKD);
        return $newKD;
    }

    /** AJAX */
    public function ajax_get_unitkerja()
    {
        $data_id = $this->request->getVar('data_id');
        $dtUnitkerja = $this->dbUnitkerja->getUnitKerja($data_id);

        echo json_encode($dtUnitkerja);
    }

    public function ajax_get_unitkerjabykelas($kelas_id)
    {
        $arr_kelas = explode(",", $kelas_id);
        $dtUnitkerja = $this->dbUnitkerja->getUnitKerjaByKelas($arr_kelas);

        echo json_encode($dtUnitkerja);
    }
}
