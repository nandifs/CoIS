<?php

namespace App\Controllers\Satpam\Petugas;

use App\Controllers\BaseController;
use App\Database\DbHelperSatpam;
use App\Models\SATPAM\M_kendaraan;

class Kendaraan extends BaseController
{
    protected $dbHelperSatpam;
    protected $dbKendaraan;

    public function __construct()
    {
        $this->dbHelperSatpam = new DbHelperSatpam();

        $this->dbKendaraan = new M_kendaraan();
    }

    public function index()
    {
        if ($this->hasLogin) {

            //Check: Jika Akes tenagakerja tampilkan hanya presensi pegawasi tersebut
            if ($this->otoritas == "TENAGAKERJA") {

                //CSS for datatable
                $appCSS = loadCSS("https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css");
                $appCSS .= loadCSS("datatables-bs4/css/dataTables.bootstrap4.min.css", "adminlte_plugins");
                $appCSS .= loadCSS("datatables-responsive/css/responsive.bootstrap4.min.css", "adminlte_plugins");
                $appCSS .= loadCSS("datatables-buttons/css/buttons.bootstrap4.min.css", "adminlte_plugins");

                $appJSFoot =  loadJS("datatables/jquery.dataTables.min.js", "adminlte_plugins");
                $appJSFoot .=  loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
                $appJSFoot .=  loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
                $appJSFoot .=  loadJS("datatables-responsive/js/dataTables.responsive.min.js", "adminlte_plugins");
                $appJSFoot .=  loadJS("datatables-responsive/js/responsive.bootstrap4.min.js", "adminlte_plugins");

                $periode = date("Y-m-d");
                $mitrakerja_id = $this->dtAksesMitra;

                $dtKendaraan = $this->dbHelperSatpam->getKendaraan($periode, $mitrakerja_id);

                $rekapKendaraan["jmldidalam"] = 0;

                $this->dtContent['page'] = "satpam_kendaraan";
                $this->dtContent['title'] = "Kendaraan";
                $this->dtContent['appCSS'] = $appCSS;
                $this->dtContent['appJSFoot'] = $appJSFoot;

                $this->dtContent['dtKendaraan'] = $dtKendaraan;
                $this->dtContent['dtRekapKendaraan'] = $rekapKendaraan;
            }
        }
        //dd($dtKendaraan);
        return view($this->appName . '/v_app', $this->dtContent);
    }

    //--------------------------------------------------------------------
    public function kendaraan_in()
    {
        if ($this->hasLogin) {
            $appCSS = loadCSS("webcam-easy/css/webcam-app.css", "appplugins");
            $appCSS .= loadCSS("webcam.css", "appcss");

            $appJSFoot = loadJS("webcam-easy/js/webcam-easy.min.js", "appplugins");
            $appJSFoot .= loadJS("webcam-easy.app.js", "appjs");
            $appJSFoot .= loadJS("satpam/kendaraan_form.js?v=1.0", "appjs");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
            $this->dtContent['page'] = "satpam_kendaraan_masuk";
            $this->dtContent['title'] = "Kendaraan Masuk";
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function kendaraan_out($id = null)
    {
        if ($this->hasLogin) {
            $pathFotoKendaraan = $this->pathUploadImgApp . "/kendaraan/";
            if (!is_null($id)) {
                $dtKendaraan = $this->dbKendaraan->getKendaraanById($id);
                $this->dtContent['dtKendaraan'] = $dtKendaraan;
                //dd($dtKendaraan);
            }

            $appCSS = loadCSS("webcam-easy/css/webcam-app.css", "appplugins");
            $appCSS .= loadCSS("webcam.css", "appcss");

            $appJSFoot = loadJS("webcam-easy/js/webcam-easy.min.js", "appplugins");
            $appJSFoot .= loadJS("webcam-easy.app.js", "appjs");
            $appJSFoot .= loadJS("satpam/kendaraan_form.js?v=1.0", "appjs");

            $this->dtContent['page'] = "satpam_kendaraan_keluar";
            $this->dtContent['title'] = "Kendaraan Keluar";

            $this->dtContent['pathFotoKendaraan'] = $pathFotoKendaraan;

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }


    public function edit($id)
    {
        if ($this->hasLogin) {
            $dt_jabatan = $this->dbKendaraan->getPresensi($id);

            $this->dtContent['page'] = "presensi_edit";
            $this->dtContent['title'] = "Kehadiran Tenagakerja";
            $this->dtContent['dt_jabatan'] = $dt_jabatan;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $tenagakerja_id = $this->user_id;
        $mitrakerja_id = $this->dtAksesMitra;
        $no_polisi = strtoupper($this->request->getVar('no_polisi'));
        $pemilik = strtoupper($this->request->getVar('pemilik'));
        $jenis = $this->request->getVar('jenis');
        $jam_masuk = $this->request->getVar('jam_masuk');
        $ket_masuk = $this->request->getVar('ket_masuk');

        $id_file = str_replace('-', '', url_title($jam_masuk));
        $id_file = str_replace(':', '', url_title($id_file));
        $id_file = $tenagakerja_id . str_replace(' ', '', url_title($id_file));

        $status = 1; // 1=Masuk 2=Keluar
        $foto_id1 = "";

        $encfoto1 = $this->request->getVar('urifoto1');

        if ($encfoto1 != "") {
            $binfoto1 = base64_decode($encfoto1);

            $foto_id1 = "fm" . $id_file . ".jpg";
            $pathfotoid1 = $this->pathUploadImgApp . "/kendaraan/";

            //check and crete folder if not exist            
            if (!checkAndCreatePath($pathfotoid1)) {
                session()->setFlashData('danger2', ' Folder Foto Tidak Ditemukan. <br>Hubungi administrator.');
                return redirect()->to('/satpam_kendaraan_masuk');
            }

            //simpan foto

            $pathfotoid1 = $pathfotoid1 . $foto_id1;

            file_put_contents($pathfotoid1, $binfoto1);

            if (!file_exists($pathfotoid1)) {
                session()->setFlashData('danger2', ' Data Foto Tidak Berhasil Diupload. Proses simpan dibatalkan.');
                return redirect()->to('/presensi_add');
            }

            $image = \Config\Services::image();
            $image->withFile($pathfotoid1)
                ->resize(600, 400, true, "height")
                ->save($pathfotoid1);
        } else {
            //cek jika jenis presensi bukan "Izin Tidak Hadir", maka harus mengambil foto presensi(Foto Selfie, Foto keterangan sakit atau Foto surat izin cuti).            
            session()->setFlashData('warning', ' Anda belum mengambil foto kendaraan. Proses simpan dibatalkan.');
            return redirect()->to('/presensi_add');
        }

        $data = [
            'no_polisi' => $no_polisi,
            'pemilik' => $pemilik,
            'jns_kendaraan' => $jenis,
            'jam_masuk' => $jam_masuk,
            'foto_masuk' => $foto_id1,
            'ket_masuk' => $ket_masuk,
            'status' => $status,
            'petugas_id_masuk' => $tenagakerja_id,
            'mitrakerja_id' => $mitrakerja_id

        ];
        //dd($data);
        //Save to database
        $this->dbKendaraan->save($data);

        session()->setFlashData('sweet', 'Data Presensi berhasil disimpan.');

        return redirect()->to('/satpam_kendaraan');
    }

    public function save_out()
    {
        $id = $this->request->getVar('data_id');

        $tenagakerja_id = $this->user_id;
        $mitrakerja_id = $this->dtAksesMitra;

        $jam_keluar = $this->request->getVar('jam_keluar');
        $ket_keluar = $this->request->getVar('ket_keluar');

        $id_file = str_replace('-', '', url_title($jam_keluar));
        $id_file = str_replace(':', '', url_title($id_file));
        $id_file = $tenagakerja_id . str_replace(' ', '', url_title($id_file));

        $jam_keluar = date('Y-m-d H:i:s');

        $foto_id2 = "";

        $encfoto2 = $this->request->getVar('urifoto2');
        if ($encfoto2 != "") {
            $binfoto2 = base64_decode($encfoto2);

            $foto_id2 = "fk" . $id_file . ".jpg";
            $pathfotoid2 = $this->pathUploadImgApp . "/kendaraan/";

            if (!checkAndCreatePath($pathfotoid2)) {
                session()->setFlashData('danger2', ' Folder Foto 2 Tidak Ditemukan. <br>Hubungi administrator.');
                return redirect()->to("/satpam_kendaraan_keluar/$id");
            }

            $pathfotoid2 = $pathfotoid2 . $foto_id2;

            file_put_contents($pathfotoid2, $binfoto2);

            //resize image
            $image = \Config\Services::image();
            $image->withFile($pathfotoid2)
                ->resize(600, 400, true, "height")
                ->save($pathfotoid2);
        } else {
            session()->setFlashData('warning', ' Anda belum mengambil foto kendaraan. Proses simpan dibatalkan.');
            return redirect()->to("/presensi_out/$id");
        }
        $status = 2; // 1=Masuk 2=Keluar
        $data = [
            'id' => $id,
            'jam_keluar' => $jam_keluar,
            'foto_keluar' => $foto_id2,
            'ket_keluar' => $ket_keluar,
            'petugas_id_keluar' => $tenagakerja_id,
            'mitrakerja_id' => $mitrakerja_id,
            'status' => $status
        ];

        //Save to database
        $this->dbKendaraan->save($data);

        session()->setFlashData('sweet', 'Presensi Pulang berhasil disimpan.');

        return redirect()->to('/satpam_kendaraan');
    }

    public function delete($id)
    {
        $this->dbKendaraan->delete($id);
        session()->setFlashData('sweet', 'Data Kendaraan berhasil dihapus.');
        return redirect()->to('/satpam_kendaraan');
    }

    public function detail($id)
    {
        $pathFotoPresensi = $this->pathUploadImgApp . "/kendaraan/";

        $appJSFoot = loadJS("satpan/kendaraan.js?v=1.0", "appjs");
        $appCSS = loadCSS("webcam.css", "appcss");

        $dtKendaraan = $this->dbKendaraan->getKendaraanById($id);

        $this->dtContent['title'] = "Kehadiran Tenagakerja";
        $this->dtContent['page'] = "presensi_detail";

        $this->dtContent['dtKendaraan'] = $dtKendaraan;

        $this->dtContent['pathFotoPresensi'] = $pathFotoPresensi;

        $this->dtContent['appCSS'] = $appCSS;
        $this->dtContent['appJSFoot'] = $appJSFoot;


        return view($this->appName . '/v_app', $this->dtContent);
    }

    /**
     * AJAX
     */
    public function ajax_get_kendaraan_by_nopol()
    {
        if ($this->hasLogin) {
            $nopol = $this->request->getVar("data_key");
            $dtKendaraan = $this->dbHelperSatpam->getKendaraanByNopol($nopol);

            //output to json format
            echo json_encode($dtKendaraan);
        }
    }
}
