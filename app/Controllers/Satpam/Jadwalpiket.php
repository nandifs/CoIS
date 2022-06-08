<?php

namespace App\Controllers\Satpam;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_mitrakerja;
use App\Models\SATPAM\M_jadwalpiket;
use App\Models\SATPAM\M_regu;
use App\Models\SATPAM\M_reguanggota;

class Jadwalpiket extends BaseController
{
    protected $dbHelper;
    protected $dbHelperSatpam;
    protected $reguSatpam;
    protected $jadwalPiket;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();

        $this->jadwalPiket = new M_jadwalpiket();
        $this->reguSatpam = new M_regu();
        $this->anggotaReguModel = new M_reguanggota();
    }

    public function index($selMitraKerja = null)
    {
        if (is_null($selMitraKerja)) {
            $selMitraKerja = $this->dtAksesMitra;
        }

        $selDbMitrakerja = new M_mitrakerja();
        if ($selMitraKerja == "9999") {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($selMitraKerja);

            if (!empty($dtMitraKerja)) {
                $selMitraKerja = $dtMitraKerja[0]['id'];
            } else {
                $selMitraKerja = 0;
            }
        } else {
            $selDtMitrakerja = $selDbMitrakerja->getMitraKerja($this->dtAksesMitra);
            $dtMitraKerja = $this->dbHelper->getMitraKerjaForCombo($selDtMitrakerja);
        }

        $dtJadwalPiket = $this->jadwalPiket->getJadwalPiket();

        $dtRegu = $this->dbHelperSatpam->getReguByPenempatan($selMitraKerja);

        $bln_tahun = strtoupper(ambil_bulan_tahun());

        $appJS =  loadJS('satpam/jadwalpiket.js', "appjs");

        $this->dtContent['page'] = "jadwalpiket";
        $this->dtContent['appJSFoot'] = $appJS;

        $this->dtContent['title'] = "JADWAL PIKET PER REGU";
        $this->dtContent['blnTahun'] = $bln_tahun;

        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtJadwalPiket'] = $dtJadwalPiket;
        $this->dtContent['dtRegu'] = $dtRegu;

        $this->dtContent['selMitraKerja'] = $selMitraKerja;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function anggota($selMitraKerja = null)
    {
        if (is_null($selMitraKerja)) {
            $selMitraKerja = $this->dtAksesMitra;
        }

        $selDbMitrakerja = new M_mitrakerja();
        if ($selMitraKerja == "9999") {
            $selDtMitrakerja = $selDbMitrakerja->getMitraKerja($selMitraKerja);
            $dtMitraKerja = $this->dbHelper->getMitraKerjaForCombo($selDtMitrakerja);

            if (!empty($dtMitraKerja)) {
                $selMitraKerja = $dtMitraKerja[0]['id'];
            } else {
                $selMitraKerja = 0;
            }
        } else {
            $selDtMitrakerja = $selDbMitrakerja->getMitraKerja($this->dtAksesMitra);
            $dtMitraKerja = $this->dbHelper->getMitraKerjaForCombo($selDtMitrakerja);
        }

        $dtJadwalPiket = $this->jadwalPiket->getJadwalPiket();
        $dtRegu = $this->dbHelperSatpam->getAnggotaReguDetail($selMitraKerja);

        $bln_tahun = strtoupper(ambil_bulan_tahun());

        $appJS =  loadJS('satpam/jadwalpiket.js', "appjs");

        $this->dtContent['page'] = "jadwalanggota";
        $this->dtContent['appJSFoot'] = $appJS;

        $this->dtContent['title'] = "JADWAL PIKET PER ANGGOTA";

        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        $this->dtContent['selMitraKerja'] = $selMitraKerja;

        $this->dtContent['blnTahun'] = $bln_tahun;
        $this->dtContent['dtJadwalPiket'] = $dtJadwalPiket;
        $this->dtContent['dtRegu'] = $dtRegu;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    //--------------------------------------------------------------------

}
