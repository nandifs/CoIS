<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Models\M_upahregional;

class Upahregional extends BaseController
{
    protected $dbHelper;

    protected $dbUpahRegional;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();

        $this->dbUpahRegional = new M_upahregional();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $page = getControllerName();
        $appJS = loadJS($page . "/form.js", 'appjs');
        $filter = ['tahun' => 2022];
        $dtUpahRegional = $this->dbHelper->getUpahRegional($filter);

        $this->dtContent['title'] = "Upah Regional";
        $this->dtContent['page'] = $page;

        $this->dtContent['dtUpahRegional'] = $dtUpahRegional;

        //$this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function update_data()
    {
        $data_id = $this->request->getVar('data_id');

        $wilayah_id = strtoupper($this->request->getVar('wilayah_id'));
        $umr_tahun = strtoupper($this->request->getVar('umr_tahun'));

        $data = [
            'wilayah_id' => $wilayah_id
        ];

        if ($data_id != "") {
            $data['id'] = $data_id;
            $msgE = 'Data Unit Kerja berhasil diupdate.';
        } else {
            //Check if nama_instansi sudah ada di dalam database
            $qSearch = "wilayah_id='" . $wilayah_id . "' AND tahun='" . $umr_tahun . "'";
            $chkDuplicated = $this->dbUpahRegional->checkDuplicateEntry($qSearch);

            if ($chkDuplicated > 0) {
                $returnData = array('status' => 'duplicated', 'message' => "Duplicated Entry");
                echo json_encode($returnData);
                return;
            } else {
                $msgE = 'Data Upah berhasil ditambahkan.';
            }
        }

        //Save to database
        $simpan = $this->dbUpahRegional->save($data);
        if ($simpan) {
            $lastId = ($data_id == "") ? $this->dbUpahRegional->getInsertID() : "-";
            $returnData = array('status' => 'success', 'message' => $msgE, 'data' => $lastId);
        } else {
            $returnData = array('status' => 'failed', 'message' => $simpan);
        }

        echo json_encode($returnData);
    }

    public function delete($id)
    {
        if ($this->oto_id == "99" || $this->oto_id == "1" || $this->oto_id == "2") {
            if ($this->dbUpahRegional->delete($id)) {
                $status = array('status' => 'success');
            } else {
                $status = array('status' => 'failed');
            }
            echo json_encode($status);
        } else {
            return redirect()->to("/");
        }
    }


    /** AJAX */
    public function ajax_get_upahregional()
    {
        $data_id = $this->request->getVar('data_id');
        $dtUnitkerja = $this->dbUpahRegional->getUpahRegional($data_id);

        echo json_encode($dtUnitkerja);
    }

    public function ajax_get_upahregionalbytahun($kelas_id)
    {
        $arr_kelas = explode(",", $kelas_id);
        $dtUnitkerja = $this->dbUpahRegional->getUpahRegionalByTahun($arr_kelas);

        echo json_encode($dtUnitkerja);
    }
}
