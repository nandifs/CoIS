<?php

namespace App\Controllers\Satpam;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_tenagakerja;
use App\Models\SATPAM\M_regu;
use App\Models\SATPAM\M_reguanggota;

class Reguanggota extends BaseController
{
    protected $dbHelper;
    protected $dbHelperSatpam;

    protected $dbTenagakerja;
    protected $dbRegu;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam;

        $this->dbTenagakerja = new M_tenagakerja();
        $this->dbRegu = new M_regu();
        $this->dbAnggotaRegu = new M_reguanggota();
    }

    public function index($selDtAkses = null)
    {
        //Ambil jabatan SATPAN DAN DANRU                        
        $dtTenagakerja = $this->dbTenagakerja->getTenagakerjaForComboBy($selDtAkses, "jabatan_id", array(2, 3));
        //dd($dtTenagakerja);
        $dtRegu = $this->dbRegu->getRegu();
        $dtAnggotaRegu = $this->dbHelperSatpam->getAnggotaReguDetail($selDtAkses);

        //dd($dtAnggotaRegu);

        $loadJS = loadJS("satpam/reguanggota.js", "appjs");

        $this->dtContent['page'] = "reguanggota";
        $this->dtContent['title'] = "Regu Satuan Pengamanan";

        $this->dtContent['appJSFoot'] = $loadJS;

        $this->dtContent['dtRegu'] = $dtRegu;
        $this->dtContent['dtAnggotaRegu'] = $dtAnggotaRegu;
        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;

        $this->dtContent['selDtAkses'] = $selDtAkses;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function tambah()
    {
        $id_regu = $this->request->getVar('regu_id');
        $id_petugas = $this->request->getVar('petugas_id');

        $penempatan_id = $this->request->getVar('penempatan_id');

        $checkData = $this->dbAnggotaRegu->checkIfAlreadySet($id_petugas);

        if (is_null($checkData)) {
            $data = [
                'regu_id' => $id_regu,
                'petugas_id' => $id_petugas
            ];
        } else {
            $data = [
                'id' => $checkData['id'],
                'regu_id' => $id_regu,
                'petugas_id' => $id_petugas
            ];
        }

        //Save to database
        $this->dbAnggotaRegu->save($data);

        session()->setFlashData('sweet', 'Anggota Regu berhasil ditambahkan.');

        return redirect()->to("/satpam/reguanggota/$penempatan_id");
    }

    //--------------------------------------------------------------------

    public function ajax_get_tenagakerja($id)
    {
        $dtTenagakerja = $this->dbTenagakerja->getTenagakerjaAjax($id);
        //dd($data);

        //output to json format
        echo json_encode($dtTenagakerja);
    }
}
