<?php

namespace App\Controllers\Satpam;

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
        //dd($this->dtUser);
        //dd($this->otoritas);
        $otorisasi = $this->otoritas;
        if ($otorisasi == 'ADMINISTRATOR' || $otorisasi == 'OPERATOR' || $otorisasi == 'SUPER USER') {
            //Get data Mitrakerja for combo
            $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);
            $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);

            $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
            $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        } else if ($otorisasi == 'KORDINATOR' || $otorisasi == 'TAMU') {
            //dd($this->dtUser);
            $now = date('Y-m-d');
            $currentWeek = getCurrentWeek();

            //For dashbord Admin
            $jmlTamuHariIni = $this->dbHelperSatpam->countStatusTamu($this->dtAksesMitra, 1, $now);
            $jmlTamuKeluar = $this->dbHelperSatpam->countStatusTamu(3, 2, $now);

            $jmlTamuDidalam = (int) $jmlTamuHariIni - (int) $jmlTamuKeluar;

            //Get data Mitrakerja for combo
            $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);
            $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);

            $this->dtContent['title'] = $this->appName;
            $this->dtContent['jmlTamu'] = $jmlTamuHariIni;
            $this->dtContent['jmlTamuKeluar'] = $jmlTamuKeluar;
            $this->dtContent['jmlTamuDidalam'] = $jmlTamuDidalam;
            $this->dtContent['currentWeek'] = $currentWeek;

            $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
            $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        }

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
