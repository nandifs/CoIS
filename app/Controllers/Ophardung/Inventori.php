<?php

namespace App\Controllers\Ophardung;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperOphardung;
use App\Models\M_tenagakerja;
use App\Models\M_unitkerja;
use App\Models\OPHARDUNG\M_inventori;
use App\Models\OPHARDUNG\M_inventori_histori;

class Inventori extends BaseController
{
    protected $dbHelper;
    protected $dbHelperOphardung;

    protected $dbAlatMaterial;
    protected $dbInventori;
    protected $dbInventoriHistori;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();

        $this->dbTenagakerja = new M_tenagakerja();
        $this->dbUnitkerja = new M_unitkerja();

        $this->dbInventori = new M_inventori();
        $this->dbInventoriHistori = new M_inventori_histori();

        $this->dbHelperOphardung = new DbHelperOphardung();
    }

    public function index()
    {
        if ($this->hasLogin) {
            if ($this->otoritas != "TENAGAKERJA") {

                $selDtAkses = $this->dtAksesMitra;
                $selComboDtAkses = $this->request->getVar("dtakses");

                $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

                if (is_null($selComboDtAkses)) {
                    $selComboDtAkses = $dtMitraKerja[0]['id'];
                }

                $selPeriode = $this->request->getVar('periode');
                $aksi = $this->request->getVar('cmdaksi');

                $selPeriode = (is_null($selPeriode)) ? date("Y-m-1") : $selPeriode;
                $aksi = (is_null($aksi)) ? 'rekapitulasi' : $aksi;
                //dd($selComboDtAkses);
                $dtRekapInventori = $this->dbHelperOphardung->getRekapInventoriByMitrakerja($selComboDtAkses);
                $dtInventori = $this->dbHelperOphardung->getInventoriByMitrakerja($selComboDtAkses);
                //dd($dtRekapInventori);
                //dd($dtInventori);

                $this->dtContent['page'] = "ophardung_inventori";
                $this->dtContent['title'] = "Inventori";

                $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

                $this->dtContent['selDtAkses'] = $selComboDtAkses;
                $this->dtContent['selPeriode'] = $selPeriode;

                $this->dtContent['dtRekapInventori'] = $dtRekapInventori;
                $this->dtContent['dtInventori'] = $dtInventori;

                $appJSFoot = loadJS("ophardung/inventori.js", "appjs");
                $this->dtContent['appJSFoot'] = $appJSFoot;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function inventoriunit()
    {
        if ($this->hasLogin) {
            if ($this->otoritas != "TENAGAKERJA") {
                $keyData = $this->request->getVar("key_data");
                $expKeyData = explode("|", $keyData);

                $mitrakerjaId = $expKeyData[0];
                $periode = $expKeyData[1];

                $dtMitraKerja = $this->dbHelper->getMitraKerja($mitrakerjaId);

                $dtInventori = $this->dbHelperOphardung->getInventoriByMitrakerja($mitrakerjaId);

                $this->dtContent['page'] = "ophardung_inventori_unit";
                $this->dtContent['title'] = "Inventori";

                $this->dtContent['dtMitraKerja'] = $dtMitraKerja[0];
                $this->dtContent['dtInventori'] = $dtInventori;

                $this->dtContent['mitrakerja_id'] = $mitrakerjaId;
                $this->dtContent['periode'] = $periode;

                $appJSFoot = loadJS("ophardung/inventori.js", "appjs");

                $this->dtContent['appJSFoot'] = $appJSFoot;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }
}
