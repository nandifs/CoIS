<?php

namespace App\Controllers\Amkp\Pegawai;

use App\Controllers\BaseController;
use App\Database\DbHelperAmkp;
use App\Models\M_unitkerja;
use App\Models\M_pegawai;
use App\Models\AMKP\M_kegiatan;

class Kegiatan extends BaseController
{
    protected $dbHelperAMKP;
    protected $dbKegiatan;
    protected $dbTitikinspeksi;

    public function __construct()
    {
        $this->dbHelperAMKP = new DbHelperAmkp;

        $this->dbPegawai = new M_pegawai();
        $this->dbUnitkerja = new M_unitkerja();

        $this->dbKegiatan = new M_kegiatan();
    }

    public function index()
    {
        $pathFotoKegiatan = $this->pathUploadImgApp . "/kegiatan/";

        if ($this->hasLogin) {
            if ($this->otoritas == "PEGAWAI") {
                $tenagakerjaId = $this->user_id;
                $dt_kegiatan  = $this->dbHelperAMKP->getKegiatanPetugas($tenagakerjaId);

                $this->dtContent['dtKegiatan'] = $dt_kegiatan;
            }

            //CSS for datatable
            $appCSS = loadCSS("datatables-bs4/css/dataTables.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("datatables-responsive/css/responsive.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("datatables-buttons/css/buttons.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("kegiatan.css", "appcss");

            $appJSFoot = loadJS("datatables/jquery.dataTables.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("datatables-responsive/js/dataTables.responsive.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("datatables-responsive/js/responsive.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("amkp/kegiatan.js", "appjs");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;

            $this->dtContent['page'] = "pegawai_kegiatan_list";
            $this->dtContent['title'] = "Kegiatan";

            $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
        }
        //dd($dt_kegiatan);
        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function add()
    {
        if ($this->hasLogin) {
            if ($this->otoritas == "PEGAWAI") {
                $pegawaiNip = $this->user_uid;

                $dtPegawai = $this->dbPegawai->getPegawaiDetailByNip($pegawaiNip);
                $this->dtContent['dtPegawai'] = $dtPegawai;
            }

            //Load CSS & JS File
            $cssWebCam =  loadCSS("webcam-easy/css/webcam-app.css", "appplugins");
            $appCSS = $cssWebCam  . loadCSS("inspeksi.css", "appcss");

            $jsWebCam = loadJS("webcam-easy/js/webcam-easy.min.js", "appplugins");
            $appJS = $jsWebCam . loadJS("webcam-easy.app.js", "appjs") . "  " . loadJS("amkp/kegiatan_add.js?v=1.0", "appjs");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJS;

            $this->dtContent['page'] = "pegawai_kegiatan_add";
            $this->dtContent['title'] = "Kegiatan";
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        if ($this->hasLogin) {
            $pathFotoKegiatan = $this->pathUploadImgApp . "/kegiatan/";

            $appCSS = loadCSS("kegiatan.css", "appcss");

            if ($this->otoritas == "PEGAWAI") {
                $pegawaiNip = $this->user_uid;

                $dtPegawai = $this->dbPegawai->getPegawaiDetailByNip($pegawaiNip);
                $dtKegiatan = $this->dbKegiatan->getKegiatan($id);

                $this->dtContent['dtPegawai'] = $dtPegawai;
                $this->dtContent['dtKegiatan'] = $dtKegiatan;
            }

            $this->dtContent['page'] = "pegawai_kegiatan_edit";
            $this->dtContent['title'] = "Kegiatan";

            $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
            $this->dtContent['appCSS'] = $appCSS;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $tglKegiatan = $this->request->getVar('tanggal');
        $id_file = str_replace('-', '', url_title($tglKegiatan));

        $encfoto = $this->request->getVar('urifoto');

        if ($encfoto != "") {
            $binfoto = base64_decode($encfoto);


            $foto_id = "kgt" . $id_file . ".jpg";
            $pathfotoid = $this->pathUploadImgApp . "/kegiatan/";

            //check and crete folder if not exist            
            if (!checkAndCreatePath($pathfotoid)) {
                session()->setFlashData('danger2', ' Folder Foto Tidak Ditemukan. <br>Hubungi administrator aplikasi.');
                return redirect()->to('/pegawai_kegiatan_add');
            }

            //simpan foto            
            $pathfotoid = $pathfotoid . $foto_id;

            file_put_contents($pathfotoid, $binfoto);

            if (!file_exists($pathfotoid)) {
                session()->setFlashData('danger2', ' Data Foto Tidak Berhasil Diupload. Proses simpan dibatalkan.');
                return redirect()->to('/pegawai_kegiatan_add');
            }

            $image = \Config\Services::image();
            $image->withFile($pathfotoid)
                ->resize(600, 400, true, "height")
                ->save($pathfotoid);
        } else {
            session()->setFlashData('warning', ' Anda belum mengambil foto kegiatan. Proses simpan dibatalkan.');
            return redirect()->to('/pegawai_kegiatan_add');
        }

        $data = [
            'jenis' => $this->request->getVar('jenis'),
            'tanggal' => $this->request->getVar('tanggal'),
            'lokasi' => $this->request->getVar('lokasi'),
            'kondisi' => $this->request->getVar('kondisi'),
            'keterangan' => $this->request->getVar('keterangan'),
            'foto' => $foto_id,
            'petugas_id' => $this->request->getVar('petugas_id'),
        ];

        //Save to database
        $this->dbKegiatan->save($data);

        session()->setFlashData('sweet', 'Data Kegiatan berhasil ditambahkan.');
        return redirect()->to('/');
    }

    public function update()
    {
        $kegiatan_id = $this->request->getVar('kegiatan_id');
        $data = [
            'id' => $kegiatan_id,
            'jenis' => $this->request->getVar('jenis'),
            'kondisi' => $this->request->getVar('kondisi'),
            'keterangan' => $this->request->getVar('keterangan'),
        ];

        //Save to database
        $this->dbKegiatan->save($data);

        session()->setFlashData('info', 'Data Kegiatan berhasil diupdate.');

        return redirect()->to('/pegawai_kegiatan_list');
    }

    public function delete($id)
    {
        $this->dbKegiatan->delete($id);

        session()->setFlashData('sweet', 'Data Kegiatan  berhasil dihapus.');
        return redirect()->to('/pegawai_kegiatan_list');
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
