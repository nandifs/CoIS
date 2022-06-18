<?php

namespace App\Controllers\Ketenagakerjaan;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHelperTenagakerja;

class Tenagakerjahaknormatif extends BaseController
{
    protected $dbHelper;
    protected $dbTenagakerja;


    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->DbHelperTenagakerja = new DbHelperTenagakerja();
    }

    public function upah()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $selDtAkses = $this->dtAksesMitra;
        $selComboDtAkses = $this->request->getVar("dtakses");

        $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

        if (is_null($selComboDtAkses)) {
            $selComboDtAkses = $dtMitraKerja[0]['id'];
        }

        //get tenagakerja by selected mitrakerja
        if ($this->session->has('smk')) {
            $selDtAkses = $this->session->smk;
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailPenempatan($selDtAkses);
        } else {
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailPenempatan($selComboDtAkses);
        }

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('ketenagakerjaan/data_tenagakerja.js', "appjs");

        $this->dtContent['title'] = "Tenaga Kerja - Upah";
        $this->dtContent['page'] = "tenagakerja_upah";

        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        $this->dtContent['selMitraKerja'] = $selDtAkses;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function bpjs_kt()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $selDtAkses = $this->dtAksesMitra;
        $selComboDtAkses = $this->request->getVar("dtakses");

        $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

        if (is_null($selComboDtAkses)) {
            $selComboDtAkses = $dtMitraKerja[0]['id'];
        }

        //get tenagakerja by selected mitrakerja
        if ($this->session->has('smk')) {
            $selDtAkses = $this->session->smk;
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailPenempatan($selDtAkses);
        } else {
            $dtTenagakerja = $this->dbHelper->getTenagakerjaDetailPenempatan($selComboDtAkses);
        }

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('ketenagakerjaan/data_tenagakerja.js', "appjs");

        $this->dtContent['title'] = "Tenaga Kerja - BPJS Ketenagakerjaan";
        $this->dtContent['page'] = "tenagakerja_bpjs_kt";

        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        $this->dtContent['selMitraKerja'] = $selDtAkses;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }
}
