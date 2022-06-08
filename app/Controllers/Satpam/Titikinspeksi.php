<?php

namespace App\Controllers\Satpam;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_mitrakerja;
use App\Models\SATPAM\M_titikinspeksi;

class Titikinspeksi extends BaseController
{
    protected $dbHelper;
    protected $dbHelperSatpam;

    protected $dbTitikInspeksi;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();

        $this->dbTitikInspeksi = new M_titikinspeksi();
    }

    public function index()
    {
        $selMitrakerja = $this->dtAksesMitra;

        $dbMitrakerja = new M_mitrakerja();
        if ($selMitrakerja == "9999") {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($selMitrakerja);

            if (!empty($dtMitraKerja)) {
                $selMitrakerja = $dtMitraKerja[0]['id'];
            } else {
                $selMitrakerja = 0;
            }
        } else {
            $selDtMitrakerja = $dbMitrakerja->getMitraKerja($this->dtAksesMitra);
            $dtMitraKerja = $this->dbHelper->getMitraKerjaForCombo($selDtMitrakerja);
        }

        $appJS =  loadJS('satpam/titikinspeksi.js', "appjs");

        $this->dtContent['page'] = "titikinspeksi";
        $this->dtContent['title'] = "Lokasi Pengawasan";

        $this->dtContent['selMitraKerja'] = $selMitrakerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        $dtTitikInspeksi = $this->dbTitikInspeksi->getTitikInspeksiDetail($id);

        if ($this->dtAksesMitra == 0) {
            $dtMitraKerja = $this->dbHelper->getMitraKerja();
        } else {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);
        }

        $this->dtContent['title'] = "Edit Lokasi Pengawasan";
        $this->dtContent['page'] = "titikinspeksi_edit";
        $this->dtContent['dtTitikInspeksi'] = $dtTitikInspeksi;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $grup = $this->request->getVar('grup_lokasi');
        $lokasi = $this->request->getVar('nama_lokasi');
        $unitkerja_id = $this->request->getVar('penempatan_id');

        $data = [
            'grup' => $grup,
            'lokasi' => $lokasi,
            'mitrakerja_id' => $unitkerja_id
        ];

        //Save to database
        $simpan = $this->dbTitikInspeksi->save($data);
        if ($simpan) {
            session()->setFlashData('sweet', 'Data berhasil ditambahkan.');
        } else {
            session()->setFlashData('sweeterror', 'Data Tidak Berhasil Ditambahkan!!!');
        }

        return redirect()->to('/titikinspeksi');
    }

    public function update()
    {
        $data_id = $this->request->getVar('data_id');
        $grup = $this->request->getVar('grup_lokasi');
        $lokasi = $this->request->getVar('nama_lokasi');
        $unitkerja_id = $this->request->getVar('mitrakerja_id');

        $data = [
            'id' => $data_id,
            'grup' => $grup,
            'lokasi' => $lokasi,
            'mitrakerja_id' => $unitkerja_id
        ];

        //Save to database
        $simpan = $this->dbTitikInspeksi->save($data);
        if ($simpan) {
            session()->setFlashData('success', 'Data berhasil diupdate.');
        } else {
            session()->setFlashData('warning', 'Data Tidak Berhasil Diupdate!!!');
        }

        return redirect()->to('/titikinspeksi');
    }

    public function delete($id)
    {
        if ($this->otoritas == "ADMINISTRATOR") {
            $this->dbTitikInspeksi->delete($id);
            session()->setFlashData('sweet', 'Data Titik Inspeksi berhasil dihapus.');
            return redirect()->to('/titikinspeksi');
        } else {
            session()->setFlashData('danger2', 'Anda tidak punya hak akses untuk menghapus data.');
            return redirect()->to('/titikinspeksi');
        }
    }

    /**
     * DATA AJAX
     */
    public function ajax_data_tabel_titik_inspeksi()
    {
        $mitrakerja_id = $this->request->getVar("data_id");

        $listTitikInspeksi = $this->dbHelperSatpam->getTitikInspeksiByMitraKerja($mitrakerja_id)->getResult();

        // dd($listTitikInspeksi);
        $data = array();
        $no = 0;

        foreach ($listTitikInspeksi as $titikInspeksi) {
            $row_id = $titikInspeksi->id;

            $nama_lokasi = $titikInspeksi->lokasi;
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $titikInspeksi->singkatan;
            $row[] = $titikInspeksi->grup;
            $row[] = $nama_lokasi;

            $action = "<a href='" . base_url('titikinspeksi_edit/' . $row_id) . "' data-toggle='tooltip' data-placement='top' title='Edit'> <button type='button' class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>
            <a href='titikinspeksi_delete/$row_id' data-toggle='tooltip' data-placement='top' title='Hapus' onclick='return confirm('Hapus Lokasi Inspeksi : " . $nama_lokasi . " ?')'><button type='button' class='btn btn-danger btn-xs'><i class='fa fa-trash-alt'></i></button></a>";

            $row[] = $action;

            $data[] = $row;
        }

        echo json_encode($data);
    }
}
