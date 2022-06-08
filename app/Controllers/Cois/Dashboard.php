<?php

namespace App\Controllers\Cois;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_user;

class Dashboard extends BaseController
{
    protected $dbHelper;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1") {
            return redirect()->to("/");
        }

        //Get data Mitrakerja for combo
        $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);
        $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);

        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        return view($this->appName . '/v_app', $this->dtContent);
    }
    //--------------------------------------------------------------------

    public function save_dtakses()
    {
        $user_id = $this->user_id;

        $data = [
            'id' => $user_id,
            'data_unit_id' => $this->request->getVar('dtakses_unitkerja'),
            'data_akses_id' => $this->request->getVar('dtakses_mitrakerja')
        ];

        $userModel = new M_user();

        //Save to database
        $simpan = $userModel->save($data);
        if ($simpan) {
            session()->setFlashData('sweet', 'Data Akses berhasil diupdate.');
        } else {
            session()->setFlashData('warning', 'Gagal mengupdate data akses!!!');
        }

        return redirect()->to('/');
    }
}
