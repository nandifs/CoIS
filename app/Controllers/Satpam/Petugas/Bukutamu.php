<?php

namespace App\Controllers\Satpam\Petugas;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;

use App\Models\SATPAM\M_bukutamu;

class Bukutamu extends BaseController
{
    protected $dbHelper;
    protected $dbHelperSatpam;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();

        $this->dbBukuTamu = new M_bukutamu();
    }

    public function index()
    {
        if ($this->hasLogin) {
            //CSS for datatable
            $appCSS = loadCSS("datatables-bs4/css/dataTables.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("datatables-responsive/css/responsive.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("datatables-buttons/css/buttons.bootstrap4.min.css", "adminlte_plugins");

            $appCSS .= loadCSS("bukutamu.css", "appcss");

            $appJSFoot =  loadJS("datatables/jquery.dataTables.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-responsive/js/dataTables.responsive.min.js", "adminlte_plugins");
            $appJSFoot .=  loadJS("datatables-responsive/js/responsive.bootstrap4.min.js", "adminlte_plugins");

            $appJSFoot .=  loadJS("satpam/bukutamu.js?v=1.0", "appjs");

            $selPeriode = $this->request->getVar("sel_periode");

            if (is_null($selPeriode)) {
                $selPeriode = "Hari Ini";
            }

            $selDtAkses = $this->dtAksesMitra;

            if ($this->otoritas != "TENAGAKERJA") {
                $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);
                if (!empty($dtMitraKerja)) {
                    $selDtAkses = $this->request->getVar("dtakses");
                    if (is_null($selDtAkses)) {
                        $selDtAkses = $dtMitraKerja[0]['id'];
                    }
                }

                $this->dtContent['selDtAkses'] = $selDtAkses;
                $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
            }

            $dtTamu = $this->dbHelperSatpam->getTamuPerUnit($selPeriode, $selDtAkses);

            $jmlTamuHariIni = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 1, "Hari Ini");
            $jmlTamuKeluar = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 2, "Hari Ini");
            $jmlTamuDidalam = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 1, "Bulan Ini");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;

            $this->dtContent['page'] = "satpam_bukutamu";
            $this->dtContent['title'] = "Buku Tamu";
            $this->dtContent['dtTamu'] = $dtTamu;

            $this->dtContent['jmlTamu'] = $jmlTamuHariIni;
            $this->dtContent['jmlTamuKeluar'] = $jmlTamuKeluar;
            $this->dtContent['jmlTamuDidalam'] = $jmlTamuDidalam;

            $this->dtContent['selPeriode'] = $selPeriode;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    //--------------------------------------------------------------------
    public function add()
    {
        if ($this->hasLogin) {

            $appCSS = loadCSS("webcam-easy/css/webcam-app.css", "appplugins");
            $appCSS .= loadCSS("signature-pad/jquery.signaturepad.css", "appplugins");
            $appCSS .= loadCSS("bukutamu.css", "appcss");

            $appJSFoot = loadJS("webcam-easy/js/webcam-easy.min.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/bezier.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/numeric-1.2.6.min.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/jquery.signaturepad.js", "appplugins");
            $appJSFoot .= loadJS("webcam-easy.app.js", "appjs");
            $appJSFoot .= loadJS("satpam/bukutamuupdate.js?v=1.0", "appjs");

            $this->dtContent['page'] = "satpam_bukutamu_add";
            $this->dtContent['title'] = "Tambah Buku Tamu";
            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        if ($this->hasLogin) {
            $appCSS = loadCSS("bukutamu.css", "appcss");
            $appJS = loadJS("satpam/bukutamuupdate.js?v=1.0", "appjs");

            $dtTamu = $this->dbBukuTamu->getTamu($id);

            $this->dtContent['page'] = "satpam_bukutamu_edit";
            $this->dtContent['title'] = "Buku Tamu";
            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJS;

            $this->dtContent['dtTamu'] = $dtTamu;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $created_by = $this->user_id;

        //$unitkerja_id = 3; //Ini sementara, nanti ambil dari database
        $mitrakerja_id = $this->dtAksesMitra;

        $tanggal = $this->request->getVar('tanggal');
        $jam_masuk = $this->request->getVar('jam_masuk');

        //Create File Id
        $id_file =  $created_by . str_replace("-", "", $tanggal) . str_replace(":", "", $jam_masuk) . mt_rand(100, 999);

        //Get Foto Id
        $encfoto1 =  $this->request->getVar('urifoto1');

        $binfoto1 = base64_decode($encfoto1);
        $pathfotoid = $this->pathUploadImgApp . "/bukutamu/id/";
        $foto_id = "fid" . $id_file . ".jpg";

        //check and crete folder if not exist            
        if (!checkAndCreatePath($pathfotoid)) {
            session()->setFlashData('danger2', ' Folder Foto Tidak Ditemukan. <br>Hubungi administrator.');
            return redirect()->to('/simpan_bukutamu_add');
        }

        //simpan foto
        $pathfotoid = $pathfotoid . $foto_id;
        file_put_contents($pathfotoid, $binfoto1);
        if (!file_exists($pathfotoid)) {
            session()->setFlashData('danger2', ' Data Foto Tidak Berhasil Diupload. Proses simpan dibatalkan.');
            return redirect()->to('/simpan_bukutamu_add');
        }
        //resize foto
        $image = \Config\Services::image();
        $image->withFile($pathfotoid)
            ->resize(600, 400, true, "height")
            ->save($pathfotoid);


        //Get Foto Tamu
        $encfoto2 = $this->request->getVar('urifoto2');
        $binfoto2 = base64_decode($encfoto2);

        $pathfototamu = $this->pathUploadImgApp . "/bukutamu/foto/";
        $foto_tamu = "ftm" . $id_file . ".jpg";

        //check and crete folder if not exist            
        if (!checkAndCreatePath($pathfototamu)) {
            session()->setFlashData('danger2', ' Folder Foto Tidak Ditemukan. <br>Hubungi administrator.');
            return redirect()->to('/simpan_bukutamu_add');
        }
        //simpan foto
        $pathfototamu = $pathfototamu . $foto_tamu;
        file_put_contents($pathfototamu, $binfoto2);

        //Get Ttd Tamu
        $encttdtamu = $this->request->getVar('urittd');
        $binttdtamu = base64_decode($encttdtamu);

        $pathttdtamu = $this->pathUploadImgApp . "/bukutamu/ttd/";
        $ttd_tamu = "ttd" . $id_file . ".png";

        //check and crete folder if not exist            
        if (!checkAndCreatePath($pathttdtamu)) {
            session()->setFlashData('danger2', ' Folder Foto Tidak Ditemukan. <br>Hubungi administrator.');
            return redirect()->to('/simpan_bukutamu_add');
        }

        $pathttdtamu = $pathttdtamu . $ttd_tamu;
        file_put_contents($pathttdtamu, $binttdtamu);

        $tgl_jam_masuk = $tanggal . " " . $jam_masuk;
        $status    = 1;

        $data = [
            'tanggal' => $tanggal,
            'nama_tamu' => $this->request->getVar('nama_tamu'),
            'alamat' => $this->request->getVar('alamat'),
            'telepon' => $this->request->getVar('telp'),
            'alamat' => $this->request->getVar('alamat'),
            'instansi_pekerjaan' => $this->request->getVar('instansi'),
            'bertemu' => $this->request->getVar('bertemu'),
            'keperluan' => $this->request->getVar('keperluan'),
            'jam_masuk' => $tgl_jam_masuk,
            'file_foto_dan_ttd' => $id_file,
            'mitrakerja_id' => $mitrakerja_id,
            'status' => $status,
            'created_by' => $created_by
        ];

        //Save to database
        $this->dbBukuTamu->save($data);

        session()->setFlashData('sweet', 'Data Tamu berhasil ditambahkan.');

        return redirect()->to('/satpam_bukutamu');
    }

    public function update()
    {
        $data_id = $this->request->getVar('data_id');

        $data = [
            'id' => $data_id,
            'nama_tamu' => $this->request->getVar('nama_tamu'),
            'alamat' => $this->request->getVar('alamat'),
            'telepon' => $this->request->getVar('telp'),
            'alamat' => $this->request->getVar('alamat'),
            'instansi_pekerjaan' => $this->request->getVar('instansi'),
            'bertemu' => $this->request->getVar('bertemu'),
            'keperluan' => $this->request->getVar('keperluan'),
            'updated_by' => $this->user_id
        ];

        //Save to database
        $this->dbBukuTamu->save($data);

        session()->setFlashData('sweet', 'Data Tamu berhasil diupdate.');

        return redirect()->to('/satpam_bukutamu');
    }

    public function updatejamkeluar()
    {
        $id_tamu = $this->request->getVar('up_id_tamu');
        $tgl_jam_keluar = $this->request->getVar('up_jam_keluar');
        $status = 2;

        $data = [
            'id' => $id_tamu,
            'jam_keluar' => $tgl_jam_keluar,
            'status' => $status,
            'updated_by' => $this->user_id
        ];

        //Save to database
        $this->dbBukuTamu->save($data);

        session()->setFlashData('sweet', 'Data Tamu berhasil diupdate.');

        return redirect()->to('/satpam_bukutamu');
    }

    public function delete($id)
    {
        $this->dbBukuTamu->delete($id);
        session()->setFlashData('sweet', 'Data Tamu berhasil dihapus.');
        return redirect()->to('/satpam_bukutamu');
    }

    /**
     * AJAX
     */
    public function ajax_get_tamu($id)
    {
        if ($this->hasLogin) {
            $dtTamu = $this->dbBukuTamu->getTamu($id);

            //output to json format
            echo json_encode($dtTamu);
        }
    }
}
