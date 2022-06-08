<?php

namespace App\Controllers\Satpam;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_mitrakerja;
use App\Models\M_tenagakerja;
use App\Models\M_shift;
use App\Models\SATPAM\M_bukumutasi;
use App\Models\SATPAM\M_bukumutasiinventaris;
use App\Models\SATPAM\M_bukumutasipetugas;
use App\Models\SATPAM\M_kegiatan;

class Bukumutasi extends BaseController
{
    protected $dbHelper;

    protected $dbShift;

    protected $dbBukuMutasi;
    protected $dbTenagakerja;

    protected $dbBukuMutasiTenagakerja;
    protected $dbBukuMutasiInventaris;

    protected $dbKegiatan;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();
        $this->dbShift = new M_shift();

        $this->dbBukuMutasi = new M_bukumutasi();
        $this->dbBukuMutasiTenagakerja = new M_bukumutasipetugas();
        $this->dbBukuMutasiInventaris = new M_bukumutasiinventaris();

        $this->dbTenagakerja = new M_tenagakerja();

        $this->dbKegiatan = new M_kegiatan();
    }

    public function index($selCmbDtAkses = null)
    {
        if ($this->hasLogin) {

            $selDtAkses = $this->dtAksesMitra;

            $dbMitrakerja = new M_mitrakerja();
            if ($this->dtAksesMitra == "9999") {
                $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

                if (!empty($dtMitraKerja)) {
                    $selDtAkses = $dtMitraKerja[0]['id'];
                } else {
                    $selDtAkses = 0;
                }
            } else {
                $selDtMitrakerja = $dbMitrakerja->getMitraKerja($this->dtAksesMitra);
                $dtMitraKerja = $this->dbHelper->getMitraKerjaForCombo($selDtMitrakerja);
            }

            $this->dtContent['title'] = "Buku Mutasi";
            $this->dtContent['page'] = "bukumutasi";

            $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
            $this->dtContent['selComboDtAkses'] = $selCmbDtAkses;
        }

        $appJSFoot =  loadJS("satpam/bukumutasi.js", "appjs");

        $this->dtContent['appJSFoot'] = $appJSFoot;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function detail($id)
    {
        if ($this->hasLogin) {
            $dt_petugas_piket = null;
            $dt_inventaris = null;
            $dt_kegiatan  = null;

            $dt_mutasi = $this->dbHelperSatpam->getBukuMutasi($id);
            $dt_petugas_piket = $this->dbHelperSatpam->getPetugasBukuMutasi($dt_mutasi['id']);
            $dt_inventaris = $this->dbHelperSatpam->getInventarisBukuMutasi($dt_mutasi['id']);
            $dt_kegiatan  = $this->dbHelperSatpam->getKegiatanBukuMutasi($dt_mutasi['id']);

            $blnThn = ambil_angka_bulan_tahun();
            $folderMK = addZeroSpaces($dt_mutasi['mitrakerja_id'], "mk", 5);
            $pathFotoKegiatan = "./uploads/$this->appName/$folderMK/$blnThn/kegiatan/";

            $this->dtContent['title'] = "Laporan Mutasi Harian";
            $this->dtContent['page'] = "bukumutasidetail";

            $this->dtContent['dt_mutasi'] = $dt_mutasi;
            $this->dtContent['dt_petugas_piket'] = $dt_petugas_piket;
            $this->dtContent['dt_inventaris'] = $dt_inventaris;
            $this->dtContent['dt_kegiatan'] = $dt_kegiatan;
            $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
        }

        $appJSFoot =  loadJS("satpam/bukumutasi_detail.js", "appjs");

        $this->dtContent['appJSFoot'] = $appJSFoot;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function laporan_detail($id)
    {
        if ($this->hasLogin) {
            $dt_petugas_piket = null;
            $dt_inventaris = null;
            $dt_kegiatan  = null;

            $dt_mutasi = $this->dbHelperSatpam->getBukuMutasi($id);
            $dt_petugas_piket = $this->dbHelperSatpam->getPetugasBukuMutasi($dt_mutasi['id']);
            $dt_inventaris = $this->dbHelperSatpam->getInventarisBukuMutasi($dt_mutasi['id']);
            $dt_kegiatan  = $this->dbHelperSatpam->getKegiatanBukuMutasi($dt_mutasi['id']);

            $blnThn = ambil_angka_bulan_tahun();
            $folderMK = addZeroSpaces($dt_mutasi['mitrakerja_id'], "mk", 5);
            $pathFotoKegiatan = "./uploads/$this->appName/$folderMK/$blnThn/kegiatan/";

            $this->dtContent['title'] = "Laporan Mutasi Harian";
            $this->dtContent['page'] = "laporan_bukumutasi_detail";

            $this->dtContent['dt_mutasi'] = $dt_mutasi;
            $this->dtContent['dt_petugas_piket'] = $dt_petugas_piket;
            $this->dtContent['dt_inventaris'] = $dt_inventaris;
            $this->dtContent['dt_kegiatan'] = $dt_kegiatan;
            $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
        }

        $appJSFoot =  loadJS("satpam/bukumutasi_detail.js", "appjs");

        $this->dtContent['appJSFoot'] = $appJSFoot;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        if ($this->hasLogin) {
            $dt_mutasi = $this->dbBukuMutasi->getDataMutasi($id);

            $this->dtContent['title'] = "Edit Mutasi";
            $this->dtContent['page'] = "mutasi_edit";
            $this->dtContent['dt_mutasi'] = $dt_mutasi;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function delete($id)
    {
        $this->dbBukuMutasi->delete($id);
        session()->setFlashData('info', 'Data Mutasi berhasil dihapus.');
        return redirect()->to('/bukumutasi');
    }
    //--------------------------------------------------------------------
    /**
     * AJAX
     */
    public function ajax_data_tabel_buku_mutasi()
    {
        $mitrakerja_id = $this->request->getVar("data_id");

        $dbMitrakerja = new M_mitrakerja();
        $selDtMitrakerja = $dbMitrakerja->getMitraKerja($mitrakerja_id);

        $periode = $this->request->getVar("periode");

        $listBukuMutasi = $this->dbHelperSatpam->getBukuMutasiByMitraKerja($selDtMitrakerja, $periode)->getResult();

        //dd($listBukuMutasi);
        $data = array();
        $no = 0;

        foreach ($listBukuMutasi as $bukuMutasi) {
            $row_id = $bukuMutasi->id;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bukuMutasi->tanggal;
            $row[] = $bukuMutasi->shift;
            $row[] = $bukuMutasi->jam_dinas;
            $row[] = $bukuMutasi->petugas;
            $row[] = $bukuMutasi->mitrakerja;
            $row[] = $bukuMutasi->status;

            $action = "<a href='/bukumutasidetail/$row_id' class='btn btn-success btn-sm' data-toggle='tooltip' data-placement='top' title='Detail'><i class='fa fa-book'></i> Detail</a>
            <a href='/bukumutasidelete/$row_id' data-toggle='tooltip' data-placement='top' title='Hapus' onclick='return confirm(\"Hapus Data Mutasi Harian ?)\"> <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash-alt'></i></button> </a>";;

            $row[] = $action;

            $data[] = $row;
        }
        echo json_encode($data);
    }
}
