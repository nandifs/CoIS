<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Models\M_wilayahkerja;

class Wilayahkerja extends BaseController
{
    protected $dbHelper;
    protected $dbWilayahkerja;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbWilayahkerja = new M_wilayahkerja();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $page = getControllerName();

        $dtWilayahKerja = $this->dbHelper->getWilayahKerja();

        $this->dtContent['title'] = "Wilayah Kerja";
        $this->dtContent['page'] = $page;
        $this->dtContent['mitker'] = $dtWilayahKerja;

        $appJS = loadJS($page . "/form.js", 'appjs');
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function update()
    {
        $data_id = $this->request->getVar('data_id');

        $kode = strtoupper($this->request->getVar('kode_wilayah'));
        $wilayah = strtoupper($this->request->getVar('nama_wilayah'));
        $singkatan = strtoupper($this->request->getVar('nama_singkat'));

        $data = [
            'kode' => $kode,
            'wilayah' => $wilayah,
            'singkatan' => $singkatan
        ];

        if ($data_id != "") {
            $data['id'] = $data_id;
            $msgE = 'Data ' . strtoupper("Wilayah Kerja") . ' berhasil diupdate.';
        } else {
            //Check if nama_instansi sudah ada di dalam database
            $qSearch = "wilayah='" . $wilayah . "' OR singkatan='" . $singkatan . "'";
            $chkDuplicated = $this->dbWilayahkerja->checkDuplicateEntry($qSearch);

            if ($chkDuplicated > 0) {
                $returnData = array('status' => 'duplicated', 'message' => "Duplicated Entry");
                echo json_encode($returnData);
                return;
            } else {
                $msgE = 'Data ' . strtoupper("Wilayah Kerja") . ' berhasil ditambahkan.';
            }
        }

        //Save to database
        $simpan = $this->dbWilayahkerja->save($data);
        if ($simpan) {
            $lastId = ($data_id == "") ? $this->dbWilayahkerja->getInsertID() : "-";
            $returnData = array('status' => 'success', 'message' => $msgE, 'data' => $lastId);
        } else {
            $returnData = array('status' => 'failed', 'message' => $simpan);
        }

        echo json_encode($returnData);
    }

    public function delete($id)
    {
        if ($this->oto_id == "99" || $this->oto_id == "1" || $this->oto_id == "2") {
            if ($this->dbWilayahkerja->delete($id)) {
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

    /** AJAX */
    public function ajax_get_wilayahkerja()
    {
        $data_id = $this->request->getVar('data_id');
        $dtWilayah = $this->dbWilayahkerja->getWilayahKerja($data_id);

        echo json_encode($dtWilayah);
    }
}
