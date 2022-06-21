<?php

namespace App\Controllers\Ketenagakerjaan;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHelperTenagakerja;
use App\Models\M_jabatan;

class Tenagakerjamutasi extends BaseController
{
    protected $dbHelper;
    protected $dbTenagakerja;
    protected $dbJabatan;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->DbHelperTenagakerja = new DbHelperTenagakerja();

        $this->dbJabatan = new M_jabatan();
    }

    public function mutasi()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dtAksesUnitkerja = $this->dtAksesUnit;
        $dtAksesMitrakerja = $this->dtAksesMitra;


        $dtUnitKerja = $this->dbHelper->getUnitKerja($dtAksesUnitkerja);
        $dtMitraKerja = $this->dbHelper->getMitraKerja($dtAksesMitrakerja);
        $dtWilayahKerja = $this->dbHelper->getWilayahKerja(null, ["a.kelas" => 2]);

        if ($this->appID == "40") {
            $dtJabatan = $this->dbJabatan->getJabatan("All");
        } else {
            $dtJabatan = $this->dbJabatan->getJabatan($this->appID);
        }

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('ketenagakerjaan/mutasi/tenagakerja_mutasi.js', "appjs");

        $this->dtContent['title'] = "Ketenagakerjaan - Mutasi & Rotasi";
        $this->dtContent['page'] = "ketenagakerjaan_mutasi";

        $this->dtContent['dtJabatan'] = $dtJabatan;

        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtWilayahKerja'] = $dtWilayahKerja;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }
}
