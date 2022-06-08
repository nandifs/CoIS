<?php

namespace App\Controllers\Ophardung\Petugas;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperOphardung;
use App\Models\M_tenagakerja;
use App\Models\M_unitkerja;
use App\Models\OPHARDUNG\M_alatmaterial;
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
        $this->dbAlatMaterial = new M_alatmaterial();

        $this->dbInventori = new M_inventori();
        $this->dbInventoriHistori = new M_inventori_histori();

        $this->dbHelperOphardung = new DbHelperOphardung();
    }

    public function index()
    {
        if ($this->hasLogin) {
            $mitrakerjaId = $this->dtAksesMitra;
            if ($this->otoritas == "TENAGAKERJA") {
                $tenagakerjaNip = $this->user_uid;

                $dtTenagakerja = $this->dbTenagakerja->getTenagakerjaDetailByNip($tenagakerjaNip);
                $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
            }

            //get data alat/ material for combo
            $dtAlatMaterial = $this->dbAlatMaterial->getAlatMaterial();

            //get alat/material by mitrakerja id
            $dtInventori = $this->dbHelperOphardung->getInventoriByMitrakerja($mitrakerjaId);

            $appJS = loadJS("ophardung/inventori.js?v=1.0", "appjs");

            $this->dtContent['appJSFoot'] = $appJS;

            $this->dtContent['page'] = "ophardung_petugas_inventori";
            $this->dtContent['title'] = "Inventori";

            $this->dtContent['dtAlatMaterial'] = $dtAlatMaterial;
            $this->dtContent['dtInventori'] = $dtInventori;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $tenagakerjaId = $this->user_id;
        $mitrakerjaId = $this->dtAksesMitra;

        $produkId = $this->request->getVar('inv_produk');

        $data = [
            'mitrakerja_id' => $mitrakerjaId,
            'produk_id' => $produkId,
            'jumlah' => $this->request->getVar('inv_jumlah'),
            'kondisi' => $this->request->getVar('inv_kondisi'),
            'keterangan' => $this->request->getVar('inv_keterangan'),
            'updated_by' => $tenagakerjaId,
        ];

        //Save to database Inventori
        $this->dbInventoriHistori->save($data);

        //Cek Alat/Material, jika tidak ditemukan tambah bari, jika sudah ada lakukan update data inventori
        $cekData = $this->dbInventori->cekInventori($mitrakerjaId, $produkId);
        if (!empty($cekData)) {
            $data['id'] = $cekData['id'];
        }
        $this->dbInventori->save($data);

        session()->setFlashData('sweet', 'Data Inventori berhasil diperbarui.');
        return redirect()->to('/ophardung_petugas_inventori');
    }

    public function delete($id)
    {
        $this->dbInventori->delete($id);
        session()->setFlashData('sweet', 'Data Inventori berhasil dihapus.');
        return redirect()->to('/ophardung_petugas_inventori');
    }
}
