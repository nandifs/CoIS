<?php

namespace App\Controllers\Satpam\Petugas;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_tenagakerja;
use App\Models\M_unitkerja;
use App\Models\SATPAM\M_bukumutasi;
use App\Models\SATPAM\M_kegiatan;
use App\Models\SATPAM\M_titikinspeksi;

class Inspeksi extends BaseController
{
    protected $dbHelper;
    protected $dbHelperSatpam;

    protected $dbTenagakerja;
    protected $dbUnitkerja;

    protected $dbInspeksi;
    protected $dbTitikinspeksi;

    protected $dbBukumutasi;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();

        $this->dbTenagakerja = new M_tenagakerja();
        $this->dbUnitkerja = new M_unitkerja();

        $this->dbInspeksi = new M_kegiatan();
        $this->dbTitikinspeksi = new M_titikinspeksi();

        $this->dbBukumutasi = new M_bukumutasi();
    }

    public function add()
    {
        if ($this->hasLogin) {
            if ($this->otoritas == "TENAGAKERJA") {
                $tenagakerjaNip = $this->user_uid;
                $mitraKerjaId = $this->dtAksesMitra;

                $dtTenagakerja = $this->dbTenagakerja->getTenagakerjaDetailByNip($tenagakerjaNip);

                $dtGrupTitikInspeksi = $this->dbHelperSatpam->getGrupTitikInspeksiByMitraKerja($mitraKerjaId)->getResultArray();

                // Jika Grup Titik inspeksi tidak ditemukan set ke Default Titik Inspeksi
                // jika ditemukan tampilkan titik lokasi milik mitrakerja tersebut
                if (empty($dtGrupTitikInspeksi)) {
                    // Get Default Titik Inspeksi
                    $dtGrupTitikInspeksi = $this->dbHelperSatpam->getGrupTitikInspeksiByMitraKerja("0")->getResultArray();
                    $dtTitikInspeksi = $this->dbHelperSatpam->getTitikInspeksiByMitraKerja("0", $dtGrupTitikInspeksi[0]['grup'])->getResultArray();
                } else {
                    $dtTitikInspeksi = $this->dbHelperSatpam->getTitikInspeksiByMitraKerja($mitraKerjaId, $dtGrupTitikInspeksi[0]['grup'])->getResultArray();
                }

                $dt_mutasi = $this->dbBukumutasi->getDataMutasiAktif($mitraKerjaId);
                if (!is_null($dt_mutasi)) {
                    $bukuMutasiId = $dt_mutasi['id'];
                }
                //dd($dtTitikInspeksi);
                $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
                $this->dtContent['dtGrupTitikInspeksi'] = $dtGrupTitikInspeksi;
                $this->dtContent['dtTitikInspeksi'] = $dtTitikInspeksi;
                $this->dtContent['bukuMutasiId'] = $bukuMutasiId;
            }

            //Load CSS & JS File
            $cssWebCam =  loadCSS("webcam-easy/css/webcam-app.css", "appplugins");
            $appCSS = $cssWebCam  . loadCSS("inspeksi.css", "appcss");

            $jsWebCam = loadJS("webcam-easy/js/webcam-easy.min.js", "appplugins");
            $appJS = $jsWebCam . loadJS("webcam-easy.app.js", "appjs") . "  " . loadJS("satpam/kegiatan_add.js?v=1.0", "appjs");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJS;

            $this->dtContent['page'] = "satpam_inspeksi_add";
            $this->dtContent['title'] = "Inspeksi";
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        if ($this->hasLogin) {
            $dt_satker = $this->dbUnitkerja->getUnitKerja();
            $dt_inspeksi = $this->dbInspeksi->getInspeksi($id);

            $this->dtContent['page'] = "inspeksi_edit";
            $this->dtContent['title'] = "Inspeksi";
            $this->dtContent['dt_satker'] = $dt_satker;
            $this->dtContent['dt_inspeksi'] = $dt_inspeksi;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $tglInspeksi = $this->request->getVar('tanggal');

        $id_file = str_replace('-', '', url_title($tglInspeksi));

        $encfoto = $this->request->getVar('urifoto');

        $grup_lokasi = $this->request->getVar('grup_lokasi');
        $lokasi = $this->request->getVar('lokasi');
        if ($grup_lokasi != "") {
            if ($grup_lokasi != $lokasi) {
                if ($grup_lokasi != "HALAMAN & PARKIR") {
                    $lokasi = $grup_lokasi . " - " . $lokasi;
                }
            }
        }

        if ($encfoto != "") {
            $binfoto = base64_decode($encfoto);

            $foto_id = "fin" . $id_file . ".jpg";
            $pathfotoid = $this->pathUploadImgApp . "/kegiatan/";

            //check and crete folder if not exist            
            if (!checkAndCreatePath($pathfotoid)) {
                session()->setFlashData('danger2', ' Folder Foto Tidak Ditemukan. <br>Hubungi administrator.');
                return redirect()->to('/satpam_inspeksi_add');
            }

            //simpan foto            
            $pathfotoid = $pathfotoid . $foto_id;

            file_put_contents($pathfotoid, $binfoto);

            if (!file_exists($pathfotoid)) {
                session()->setFlashData('danger2', ' Data Foto Tidak Berhasil Diupload. Proses simpan dibatalkan.');
                return redirect()->to('/satpam_inspeksi_add');
            }

            $image = \Config\Services::image();
            $image->withFile($pathfotoid)
                ->resize(600, 400, true, "height")
                ->save($pathfotoid);
        } else {
            session()->setFlashData('warning', ' Anda belum mengambil foto presensi. Proses simpan dibatalkan.');
            return redirect()->to('/satpam_inspeksi_add');
        }

        $data = [
            'jenis' => $this->request->getVar('jenis'),
            'tanggal' => $tglInspeksi,
            'lokasi' =>  $lokasi,
            'kondisi' => $this->request->getVar('kondisi'),
            'keterangan' => $this->request->getVar('keterangan'),
            'foto' => $foto_id,
            'petugas_id' => $this->request->getVar('petugas_id'),
            'mitrakerja_id' => $this->request->getVar('mitrakerja_id'),
            'buku_mutasi_id' => $this->request->getVar('bm_id')
        ];

        //dd($data);
        //Save to database
        $this->dbInspeksi->save($data);

        session()->setFlashData('sweet', 'Data Inspeksi berhasil ditambahkan.');
        return redirect()->to('/');
    }

    public function delete($id)
    {
        $this->dbInspeksi->delete($id);

        session()->setFlashData('sweet', 'Data Inspeksi  berhasil dihapus.');
        return redirect()->to('/satpam_kegiatan');
    }

    /**
     * AJAX
     */
    public function ajax_get_titik_lokasi_by_grup()
    {
        $nama_grup = $this->request->getVar("data_id");
        $dtGrupTitikInspeksi = $this->dbHelperSatpam->getGrupTitikInspeksiByMitraKerja($this->dtAksesMitra)->getResultArray();
        if (empty($dtGrupTitikInspeksi)) {
            //get default titik inspkesi by group
            $dtTitikInspeksi = $this->dbHelperSatpam->getTitikInspeksiByMitraKerja("0", $nama_grup)->getResult();
        } else {
            $dtTitikInspeksi = $this->dbHelperSatpam->getTitikInspeksiByMitraKerja($this->dtAksesMitra, $nama_grup)->getResult();
        }
        $data = [
            'status' => "success",
            'titik_lokasi' => $dtTitikInspeksi,
        ];
        echo json_encode($data);
    }
}
