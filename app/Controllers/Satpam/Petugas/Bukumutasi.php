<?php

namespace App\Controllers\Satpam\Petugas;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_tenagakerja;
use App\Models\M_shift;

use App\Models\SATPAM\M_bukumutasi;
use App\Models\SATPAM\M_bukumutasiinventaris;
use App\Models\SATPAM\M_bukumutasipetugas;
use App\Models\SATPAM\M_kegiatan;

class Bukumutasi extends BaseController
{
    protected $dbHelper;
    protected $dbHelperSatpam;

    protected $dbShift;

    protected $dbBukumutasi;
    protected $dbTenagakerja;

    protected $dbBukumutasipetugas;
    protected $dbBukumutasiinventaris;

    protected $kegiatanModel;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();

        $this->dbShift = new M_shift();

        $this->dbTenagakerja = new M_tenagakerja();

        $this->dbBukumutasi = new M_bukumutasi();
        $this->dbBukumutasipetugas = new M_bukumutasipetugas();
        $this->dbBukumutasiinventaris = new M_bukumutasiinventaris();

        $this->kegiatanModel = new M_kegiatan();
    }

    public function index()
    {
        if ($this->hasLogin) {
            $pathFotoKegiatan = $this->pathUploadImgApp . "/kegiatan/";

            //CSS for datatable
            $appCSS = loadCSS("datatables-bs4/css/dataTables.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("datatables-responsive/css/responsive.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("datatables-buttons/css/buttons.bootstrap4.min.css", "adminlte_plugins");
            /*            
            <script src="<?= path_alte(); ?>/plugins/jszip/jszip.min.js"></script>
            <script src="<?= path_alte(); ?>/plugins/pdfmake/pdfmake.min.js"></script>
            <script src="<?= path_alte(); ?>/plugins/pdfmake/vfs_fonts.js"></script>
            <script src="<?= path_alte(); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
            <script src="<?= path_alte(); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
            <script src="<?= path_alte(); ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
            */

            $appJSFoot =  loadJS("datatables/jquery.dataTables.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-responsive/js/dataTables.responsive.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-responsive/js/responsive.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-buttons/js/dataTables.buttons.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-buttons/js/buttons.bootstrap4.min.js", "adminlte_plugins");

            $appJSFoot .=  loadJS("satpam/bukumutasi_petugas.js?v=1.0", "appjs");

            $dt_petugas_piket = null;
            $dt_inventaris = null;
            $dt_kegiatan  = null;

            $petugasAlreadyAdded = "OK";

            //Ambil data mutasi dengan Status Aktif
            $dt_mutasi_aktif = $this->dbBukumutasi->getDataMutasiAktif($this->dtAksesMitra);

            //dd($dt_mutasi);
            if (!is_null($dt_mutasi_aktif)) {
                $dt_petugas_piket = $this->dbHelperSatpam->getPetugasBukuMutasi($dt_mutasi_aktif['id']);
                $dt_inventaris = $this->dbHelperSatpam->getInventarisBukuMutasi($dt_mutasi_aktif['id']);

                $dt_kegiatan  = $this->dbHelperSatpam->getKegiatanBukuMutasi($dt_mutasi_aktif['id']);

                //cek if petugas already add to petugas piket
                $dtPetugasPiketAktif = $this->dbHelperSatpam->getPetugasBukuMutasi($dt_mutasi_aktif['id'], $this->user_id);
                if (empty($dtPetugasPiketAktif)) {
                    $petugasAlreadyAdded = "not_yet";
                }
            }

            $this->dtContent['title'] = "Buku Mutasi";
            $this->dtContent['page'] = "bukumutasi_petugas";

            $this->dtContent['dt_mutasi_aktif'] = $dt_mutasi_aktif;

            $this->dtContent['dt_petugas_piket'] = $dt_petugas_piket;
            $this->dtContent['dt_inventaris'] = $dt_inventaris;
            $this->dtContent['dt_kegiatan'] = $dt_kegiatan;

            $this->dtContent['dt_petugas_added'] = $petugasAlreadyAdded;

            $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;

            if ($this->otoritas == "TENAGAKERJA") { //Tenagakerja
                $tenagakerjaNip = $this->user_uid;
                $dtTenagakerja = $this->dbTenagakerja->getTenagakerjaDetailByNip($tenagakerjaNip);

                $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
            }

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function add($pre_mutasi_id = 0)
    {
        if ($this->hasLogin) {
            $dt_shift = $this->dbShift->getShift();

            $getValForJS = "<script type='text/javascript'> var dtShift = " . json_encode($dt_shift) . "; </script>" . PHP_EOL;
            $pathJS = loadJS("satpam/bukumutasi_add.js?v=1.0", "appjs");
            $appJSFoot = $getValForJS . $pathJS;

            if ($this->otoritas == "TENAGAKERJA") {
                $tenagakerjaNip = $this->user_uid;
                $dtTenagakerja = $this->dbTenagakerja->getTenagakerjaDetailByNip($tenagakerjaNip);

                $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
            }

            $this->dtContent['title'] = "Shift Baru";
            $this->dtContent['page'] = "bukumutasi_tenagakerja_add";
            $this->dtContent['dt_shift'] = $dt_shift;
            $this->dtContent['pre_mutasi_id'] = $pre_mutasi_id;

            $this->dtContent['appJSFoot'] = $appJSFoot;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        if ($this->hasLogin) {
            $dt_mutasi = $this->dbBukumutasi->getDataMutasi($id);

            $this->dtContent['title'] = "Edit Mutasi";
            $this->dtContent['page'] = "jabatan_edit";
            $this->dtContent['dt_mutasi'] = $dt_mutasi;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        //Tutup shift jika ada shift aktif        
        $pre_mutasi_id = $this->request->getVar('pre_mutasi_id');

        if ($pre_mutasi_id != 0) {
            $this->shift_selesai($pre_mutasi_id);
        }

        $tanggal = $this->request->getVar('tanggal'); //ambil tanggal        

        $tglforslug = str_replace("-", "", $tanggal);

        $gshift = $this->request->getVar('shift');
        $jam_dinas = $this->request->getVar('jam_dinas');
        $petugas = $this->request->getVar('created_by');
        $mitrakerja_id = $this->request->getVar('mitrakerja_id');
        $created_by = $this->request->getVar('created_by_id');

        $slug = $mitrakerja_id . "-" . $tglforslug . "-" . $gshift;

        $shift = $this->dbShift->getShift($gshift);

        $data = [
            'tanggal' => $tanggal,
            'shift' => $shift['shift'],
            'jam_dinas' => $jam_dinas,
            'petugas' => $petugas,
            'mitrakerja_id' => $mitrakerja_id,
            'status' => 'Aktif',
            'slug' => $slug,
            'created_by' => $created_by
        ];

        //Save to database
        $simpan = $this->dbBukumutasi->save($data);
        if ($simpan) {
            $lastId = $this->dbBukumutasi->getInsertID();
            $data = [
                'buku_mutasi_id' => $lastId,
                'petugas_id' => $created_by,
                'keterangan' => "Created."
            ];

            //Save to database
            $this->dbBukumutasipetugas->save($data);

            session()->setFlashData('sweet', 'Data Buku Mutasi berhasil ditambahkan.');
        } else {
            session()->setFlashData('danger', 'Buku Mutasi gagal dibuat.');
        }


        return redirect()->to('/satpam_bukumutasi');
    }

    protected function shift_selesai($id)
    {
        $data = [
            'id' => $id,
            'status' => "Selesai"
        ];

        //Save to database
        $this->dbBukumutasi->save($data);
    }
    public function update($id)
    {
        $data = [
            'id' => $id,
            'jabatan' => $this->request->getVar('nama'),
            'singkatan' => $this->request->getVar('singkatan')
        ];

        //Save to database
        $this->dbBukumutasi->save($data);

        session()->setFlashData('info', 'Data Mutasi berhasil diupdate.');

        return redirect()->to('/satpam_bukumutasi');
    }

    public function delete($id)
    {
        $this->dbBukumutasi->delete($id);
        session()->setFlashData('info', 'Data Mutasi berhasil dihapus.');
        return redirect()->to('/satpam_bukumutasi');
    }

    //--------------------------------------------------------------------

    public function save_petugas()
    {
        $buku_mutasi_id = $this->request->getVar('buku_mutasi_id');
        $petugas_id = $this->request->getVar('petugas_id');
        $keterangan = $this->request->getVar('keterangan');

        $data = [
            'buku_mutasi_id' => $buku_mutasi_id,
            'petugas_id' => $petugas_id,
            'keterangan' => $keterangan
        ];

        //Save to database
        $this->dbBukumutasipetugas->save($data);

        $this->update_petugas_mutasi($buku_mutasi_id);

        session()->setFlashData('sweet', 'Data Petugas berhasil ditambahkan.');

        return redirect()->to('/satpam_bukumutasi');
    }

    public function delete_petugas($id_petugas)
    {
        $buku_mutasi_id = $this->request->getVar('buku_mutasi_id');

        //Save to database
        $this->dbBukumutasipetugas->delete($id_petugas);

        $this->update_petugas_mutasi($buku_mutasi_id);

        session()->setFlashData('info', 'Data Petugas berhasil dihapus.');

        return redirect()->to('/satpam_bukumutasi');
    }

    protected function update_petugas_mutasi($buku_mutasi_id)
    {
        $dt_mutasi_petugas = $this->dbHelperSatpam->getDataMutasiPetugasByMutasiId($buku_mutasi_id);

        $petugas = "";
        foreach ($dt_mutasi_petugas as $row) {
            $petugas = $petugas . $row['petugas'] . ", ";
        }
        $petugas = rtrim($petugas, ", ");

        $data = [
            'id' => $buku_mutasi_id,
            'petugas' => $petugas
        ];

        $this->dbBukumutasi->save($data);
    }

    //--------------------------------------------------------------------

    public function save_inventaris()
    {
        $buku_mutasi_id = $this->request->getVar('inv_buku_mutasi_id');
        $nama_barang = $this->request->getVar('inv_barang');
        $jumlah = $this->request->getVar('inv_jumlah');
        $kondisi = $this->request->getVar('inv_kondisi');
        $keterangan = $this->request->getVar('inv_keterangan'); //ambil tanggal

        $data = [
            'buku_mutasi_id' => $buku_mutasi_id,
            'barang' => $nama_barang,
            'jumlah' => $jumlah,
            'kondisi' => $kondisi,
            'keterangan' => $keterangan
        ];

        //Save to database
        $this->dbBukumutasiinventaris->save($data);

        session()->setFlashData('sweet', 'Data Inventaris berhasil ditambahkan.');

        return redirect()->to('/satpam_bukumutasi');
    }

    //--------------------------------------------------------------------
}
