<?php

namespace App\Controllers\Satpam;

use App\Controllers\BaseController;
use App\Models\M_tenagakerja;
use App\Models\M_unitkerja;
use App\Models\SATPAM\M_bukumutasi;
use App\Models\SATPAM\M_kegiatan;
use App\Models\SATPAM\M_titikinspeksi;
use TCPDF;

class Kegiatan extends BaseController
{
    protected $dbKegiatan;
    protected $dbTitikinspeksi;

    public function __construct()
    {
        $this->dbBukumutasi = new M_bukumutasi();

        $this->dbTenagakerja = new M_tenagakerja();
        $this->dbUnitkerja = new M_unitkerja();

        $this->dbKegiatan = new M_kegiatan();
        $this->dbTitikinspeksi = new M_titikinspeksi();
    }

    public function index()
    {
        $pathFotoKegiatan = $this->pathUploadImgApp . "/kegiatan/";

        if ($this->hasLogin) {
            if ($this->otoritas == "TENAGAKERJA") {
                $tenagakerjaNip = $this->user_id;
                $dtTenagakerja = $this->dbTenagakerja->getTenagakerjaDetailByNip($tenagakerjaNip);

                $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
            }

            //Ambil data mutasi dengan Status Aktif
            $dt_mutasi_aktif = $this->dbBukumutasi->getDataMutasiAktif($this->dtAksesMitra);

            if (!is_null($dt_mutasi_aktif)) {
                $dt_kegiatan  = $this->dbKegiatan->getKegiatanBukuMutasi($dt_mutasi_aktif['id']);
                $this->dtContent['dtKegiatan'] = $dt_kegiatan;
            }

            //CSS for datatable

            $appCSS = loadCSS("kegiatan.css", "appcss");
            $appJSFoot = loadJS("satpam/kegiatan.js", "appjs");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;

            $this->dtContent['page'] = "kegiatan_satpam";
            $this->dtContent['title'] = "Kegiatan";

            $this->dtContent['dtMutasiAktif'] = $dt_mutasi_aktif;

            $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function add()
    {
        if ($this->hasLogin) {
            if ($this->otoritas == "TENAGAKERJA") {
                $tenagakerjaNip = $this->user_uid;

                $dtTenagakerja = $this->dbTenagakerja->getTenagakerjaDetailByNip($tenagakerjaNip);

                $bukuMutasiId = 0;
                $dt_mutasi = $this->dbBukumutasi->getDataMutasiAktif($this->dtAksesMitra);
                if (!is_null($dt_mutasi)) {
                    $bukuMutasiId = $dt_mutasi['id'];
                }

                $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
                $this->dtContent['bukuMutasiId'] = $bukuMutasiId;
            }

            //Load CSS & JS File
            $cssWebCam =  loadCSS("webcam-easy/css/webcam-app.css", "appplugins");
            $appCSS = $cssWebCam  . loadCSS("inspeksi.css", "appcss");

            $jsWebCam = loadJS("webcam-easy/js/webcam-easy.min.js", "appplugins");
            $appJS = $jsWebCam . loadJS("webcam-easy.app.js", "appjs") . "  " . loadJS("satpam/kegiatan_add.js", "appjs");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJS;

            $this->dtContent['page'] = "satpam_kegiatan_add";
            $this->dtContent['title'] = "Kegiatan";
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        if ($this->hasLogin) {
            $dt_satker = $this->dbUnitkerja->getUnitKerja();
            $dt_kegiatan = $this->dbKegiatan->getKegiatan($id);

            $this->dtContent['page'] = "kegiatan_edit";
            $this->dtContent['title'] = "Kegiatan";
            $this->dtContent['dt_satker'] = $dt_satker;
            $this->dtContent['dt_kegiatan'] = $dt_kegiatan;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $blnThn = ambil_angka_bulan_tahun();

        $tglKegiatan = $this->request->getVar('tanggal');
        $id_file = str_replace('-', '', url_title($tglKegiatan));

        $encfoto = $this->request->getVar('urifoto');

        if ($encfoto != "") {
            $binfoto = base64_decode($encfoto);


            $foto_id = "kgt" . $id_file . ".jpg";
            $pathfotoid = $this->pathUploadImgApp . "/kegiatan/";

            //check and crete folder if not exist            
            if (!checkAndCreatePath($pathfotoid)) {
                session()->setFlashData('danger2', ' Folder Foto Tidak Ditemukan. <br>Hubungi administrator.');
                return redirect()->to('/satpam_kegiatan_add');
            }

            //simpan foto            
            $pathfotoid = $pathfotoid . $foto_id;


            file_put_contents($pathfotoid, $binfoto);

            if (!file_exists($pathfotoid)) {
                session()->setFlashData('danger2', ' Data Foto Tidak Berhasil Diupload. Proses simpan dibatalkan.');
                return redirect()->to('/satpam_kegiatan_add');
            }

            $image = \Config\Services::image();
            $image->withFile($pathfotoid)
                ->resize(600, 400, true, "height")
                ->save($pathfotoid);
        } else {
            session()->setFlashData('warning', ' Anda belum mengambil foto presensi. Proses simpan dibatalkan.');
            return redirect()->to('/satpam_kegiatan_add');
        }

        $data = [
            'jenis' => $this->request->getVar('jenis'),
            'tanggal' => $this->request->getVar('tanggal'),
            'lokasi' => $this->request->getVar('lokasi'),
            'kondisi' => $this->request->getVar('kondisi'),
            'keterangan' => $this->request->getVar('keterangan'),
            'foto' => $foto_id,
            'petugas_id' => $this->request->getVar('petugas_id'),
            'mitrakerja_id' => $this->request->getVar('mitrakerja_id'),
            'buku_mutasi_id' => $this->request->getVar('bm_id')
        ];

        //Save to database
        $this->dbKegiatan->save($data);

        session()->setFlashData('sweet', 'Data Kegiatan berhasil ditambahkan.');
        return redirect()->to('/');
    }

    public function delete($id)
    {
        $this->dbKegiatan->delete($id);

        session()->setFlashData('sweet', 'Data Kegiatan  berhasil dihapus.');
        return redirect()->to('/satpam_kegiatan');
    }

    public function cetak()
    {
        // if ($this->hasLogin) {
        //     $dtKegiatan  = $this->dbKegiatan->getKegiatan();

        //     $this->dtContent['title'] = "Laporan Data Kegiatan";
        //     $this->dtContent['page'] = "cetak_kegiatan_rutin";
        //     $this->dtContent['dtKegiatan'] = $dtKegiatan;

        //     $html = view('pages/siap/kegiatan/laporan', $this->dtContent);

        //     $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //     $pdf->SetCreator(PDF_CREATOR);
        //     $pdf->SetAuthor('CoIS');
        //     $pdf->SetTitle('Laporan');
        //     $pdf->SetSubject('Kegiatan Rutin');


        //     $pdf->setPrintHeader(false);
        //     $pdf->setPrintFooter(false);
        //     $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        //     $pdf->addPage();
        //     // output the HTML content
        //     $pdf->writeHTML($html);
        //     //line ini penting
        //     $this->response->setContentType('application/pdf');
        //     //Close and output PDF document
        //     $pdf->Output('laporan.pdf', 'D');
        // }
    }

    //--------------------------------------------------------------------

    public function ajax_get_kegiatan($id)
    {
        $dtKegiatan = $this->dbKegiatan->getKegiatan($id);
        //output to json format
        echo json_encode($dtKegiatan);
    }

    public function ajax_get_kegiatannr($id)
    {
        $dtKegiatan = $this->kegiatanNRModel->getKegiatan($id);
        //output to json format
        echo json_encode($dtKegiatan);
    }
}
