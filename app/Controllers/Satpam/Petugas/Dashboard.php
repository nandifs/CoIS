<?php

namespace App\Controllers\Satpam\Petugas;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\SATPAM\M_bukumutasi;

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
        $dtPresensiAktif = $this->dtContent['dtPresensiAktif'];
        if (!is_null($dtPresensiAktif)) {
            $dbBukumutasi = new M_bukumutasi();
            $dtMutasiAktif = $dbBukumutasi->getDataMutasiAktif($this->dtAksesMitra);
            if (is_null($dtMutasiAktif)) {
                return redirect()->to("/satpam_bukumutasi_add");
            } else {
                $dtPetugasPiket = $this->dbHelperSatpam->getPetugasBukuMutasi($dtMutasiAktif['id'], $this->user_id);
                if (empty($dtPetugasPiket)) {
                    return redirect()->to("/satpam_bukumutasi");
                }
            }

            $this->dtContent['dt_mutasi_aktif'] = $dtMutasiAktif;
            // $this->dtContent['dt_petugas_piket'] = $dt_petugas_piket;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }
}
