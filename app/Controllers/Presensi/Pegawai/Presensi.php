<?php

namespace App\Controllers\Presensi\Pegawai;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_pegawai;
use App\Models\M_presensi;

use DateTime;

class Presensi extends BaseController
{
    protected $dbHelper;
    protected $dbHelperSatpam;
    protected $dbPresensi;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();

        $this->dbPresensi = new M_presensi();
        $this->dbPegawai = new M_pegawai();
    }

    public function index()
    {
        //dd($this->dtUser);
        if ($this->hasLogin) {
            $periode = date("Y-m-d");

            $startDate = new DateTime('first day of this month');
            $nowDate = new DateTime('NOW');

            //Get jml hari kerja tanpa sabtu dan minggu
            $jmlHariKerja = (int) getWeekdayDifference($startDate, $nowDate);

            //Check: Jika Akes tenagakerja tampilkan hanya presensi pegawasi tersebut           
            if ($this->otoritas == "PEGAWAI") {
                //Level User Pegawai
                $tenagakerjaNip = $this->user_uid;
                $dtPegawai = $this->dbPegawai->getPegawaiDetailByNip($tenagakerjaNip);

                $pegawaiId = $dtPegawai['id'];

                $dtPresensi = $this->dbHelper->getPresensiPegawai($periode, $pegawaiId);

                $dtKehadiran['jmlHadir'] = $this->dbPresensi->countKehadiranPegawai(1, $periode, $pegawaiId);
                $dtKehadiran['jmlSakit'] = $this->dbPresensi->countKehadiranPegawai(2, $periode, $pegawaiId);
                $dtKehadiran['jmlCuti'] = $this->dbPresensi->countKehadiranPegawai(3, $periode, $pegawaiId);
                $dtKehadiran['jmlIzinDgnKeterangan'] = $this->dbPresensi->countKehadiranPegawai(4, $periode, $pegawaiId);
                $dtKehadiran['jmlTidakHadir'] = $dtKehadiran['jmlSakit'] + $dtKehadiran['jmlCuti'] + $dtKehadiran['jmlIzinDgnKeterangan'];

                //Hitung tanpa keterangan
                $jmlAbsensi = $dtKehadiran['jmlHadir'] + $dtKehadiran['jmlTidakHadir'];
                $jmlTmpKeterangan = $jmlHariKerja - $jmlAbsensi;
                $dtKehadiran['jmlTanpaKeterangan'] = $jmlTmpKeterangan;


                $dtKehadiran['persentaseKehadiran'] = number_format((($dtKehadiran['jmlHadir'] / $jmlHariKerja) * 100));

                $this->dtContent['dtPegawai'] = $dtPegawai;
                $this->dtContent['dtKehadiran'] = $dtKehadiran;
            }

            // CSS for datatable
            $appCSS = loadCSS("datatables-bs4/css/dataTables.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("datatables-responsive/css/responsive.bootstrap4.min.css", "adminlte_plugins");
            $appCSS .= loadCSS("datatables-buttons/css/buttons.bootstrap4.min.css", "adminlte_plugins");

            // JS for datatable
            $appJSFoot = loadJS("datatables/jquery.dataTables.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("datatables-bs4/js/dataTables.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("datatables-responsive/js/dataTables.responsive.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("datatables-responsive/js/responsive.bootstrap4.min.js", "adminlte_plugins");
            $appJSFoot .= loadJS("presensi/presensi_pegawai_data.js", "appjs");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;

            $this->dtContent['page'] = "presensi";
            $this->dtContent['title'] = "Kehadiran Pegawai";


            $this->dtContent['dtPresensi'] = $dtPresensi;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    //--------------------------------------------------------------------
    public function presensi_add()
    {
        if ($this->hasLogin) {
            $appCSS = loadCSS("webcam-easy/css/webcam-app.css", "appplugins");
            $appCSS .= loadCSS("signature-pad/jquery.signaturepad.css", "appplugins");
            $appCSS .= loadCSS("presensi.css", "appcss");

            $appJSFoot = loadJS("webcam-easy/js/webcam-easy.min.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/bezier.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/numeric-1.2.6.min.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/jquery.signaturepad.js", "appplugins");
            $appJSFoot .= loadJS("webcam-easy.app.js", "appjs");
            $appJSFoot .= loadJS("geolocation.js?v=1.0", "appjs");
            $appJSFoot .= loadJS("presensi/presensi.js?v=1.0", "appjs");

            $pegawaiId = $this->user_uid;

            $dtPegawai = $this->dbPegawai->getPegawaiDetailByNip($pegawaiId);

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
            $this->dtContent['page'] = "presensi_add";
            $this->dtContent['title'] = "Kehadiran Pegawai";
            $this->dtContent['dtPegawai'] = $dtPegawai;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function presensi_out($id)
    {
        if ($this->hasLogin) {
            $pathFotoPresensiF1 = $this->pathUploadImgApp . "/presensi/f1/";

            $appCSS = loadCSS("webcam-easy/css/webcam-app.css", "appplugins");
            $appCSS .= loadCSS("signature-pad/jquery.signaturepad.css", "appplugins");
            $appCSS .= loadCSS("presensi.css", "appcss");

            $appJSFoot = loadJS("webcam-easy/js/webcam-easy.min.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/bezier.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/numeric-1.2.6.min.js", "appplugins");
            $appJSFoot .= loadJS("signature-pad/jquery.signaturepad.js", "appplugins");
            $appJSFoot .= loadJS("webcam-easy.app.js", "appjs");
            $appJSFoot .= loadJS("geolocation.js?v=1.0", "appjs");
            $appJSFoot .= loadJS("presensi/presensi.js?v=1.0", "appjs");

            $pegawaiId = $this->user_uid;
            $dtPegawai = $this->dbPegawai->getPegawaiDetailByNip($pegawaiId);
            $dtPresensi = $this->dbPresensi->getPresensi($id);

            $this->dtContent['page'] = "presensi_out";
            $this->dtContent['title'] = "Kehadiran Pegawai";

            $this->dtContent['dtPegawai'] = $dtPegawai;
            $this->dtContent['dtPresensi'] = $dtPresensi;

            $this->dtContent['pathFotoPresensiF1'] = $pathFotoPresensiF1;

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function approval($id)
    {
        if ($this->hasLogin) {

            $pathCSS = "\t" . '<link rel="stylesheet" href="' . base_url() . '/app';
            $pathJS = "\t" . '<script src="' . base_url() . '/app';

            $appCSS = $pathCSS . '/plugins/webcam-easy/css/webcam-app.css">' . PHP_EOL;
            $appCSS = $appCSS . $pathCSS . '/css/presensi.css">';

            $appJSFoot =  $pathJS . '/plugins/webcam-easy/js/webcam-easy.min.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/plugins/webcam-easy/js/html2canvas.min.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/js/webcam-easy.app.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/plugins/signature-pad/jquery.signaturepad.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/js/presensi.js"></script>';

            $dtPresensi = $this->dbPresensi->getPresensi($id);

            $pegawaiId = $dtPresensi['pekerja_id'];
            $dtPegawai = $this->dbPegawai->getPegawaiDetail($pegawaiId);

            $approvalBy = $this->dtUser['uid'];

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
            $this->dtContent['page'] = "presensi_approval";
            $this->dtContent['title'] = "Approval Presensi";
            $this->dtContent['dtPegawai'] = $dtPegawai;
            $this->dtContent['dtPresensi'] = $dtPresensi;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        if ($this->hasLogin) {
            $dt_jabatan = $this->dbPresensi->getPresensi($id);

            $this->dtContent['page'] = "presensi_edit";
            $this->dtContent['title'] = "Kehadiran Pegawai";
            $this->dtContent['dt_jabatan'] = $dt_jabatan;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $presensi = $this->request->getVar('jenis');
        $pekerja_id = $this->request->getVar('pekerja_id');
        $tanggal_1 = $this->request->getVar('tanggal_1');
        $id_file = str_replace('-', '', url_title($tanggal_1));
        $id_file = str_replace(':', '', url_title($id_file));
        $id_file = $pekerja_id . str_replace(' ', '', url_title($id_file));

        $status = "TA";
        $foto_id1 = "";
        $foto_id2 = "";

        $encfoto1 = $this->request->getVar('urifoto1');

        if ($encfoto1 != "") {
            $binfoto1 = base64_decode($encfoto1);

            $foto_id1 = "f1" . $id_file . ".jpg";
            $pathfotoid1 = $this->pathUploadImgApp . "/presensi/f1/";

            //check and crete folder if not exist            
            if (!checkAndCreatePath($pathfotoid1)) {
                session()->setFlashData('danger2', ' Folder Foto Tidak Ditemukan. <br>Hubungi administrator.');
                return redirect()->to('/presensi_add');
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
            if ($presensi != 4) {
                session()->setFlashData('warning', ' Anda belum mengambil foto presensi. Proses simpan dibatalkan.');
                return redirect()->to('/presensi_add');
            } else {
                $tanggal_1 = date('Y-m-d H:i:s');
            }
        }

        $encfoto2 = $this->request->getVar('urifoto2');
        if ($encfoto2 != "") {
            $pathfotoid2 = $this->pathUploadImgApp . "/presensi/f2/";

            if (!checkAndCreatePath($pathfotoid2)) {
                session()->setFlashData('danger2', ' Folder Foto 2 Tidak Ditemukan. <br>Hubungi administrator.');
                return redirect()->to('/presensi_add');
            }

            $binfoto2 = base64_decode($encfoto2);

            $foto_id2 = "f2" . $id_file . ".jpg";
            $pathfotoid2 = $pathfotoid2 . $foto_id2;


            file_put_contents($pathfotoid2, $binfoto2);
        }

        if ($presensi == 1) $status = "AKTIF";

        $data = [
            'pekerja_id' => $pekerja_id,
            'jenis' => $this->request->getVar('jenis'),
            'tanggal_1' => $tanggal_1,
            'tanggal_2' => $this->request->getVar('tanggal_2'),
            'foto_1' => $foto_id1,
            'foto_2' => $foto_id2,
            'keterangan_1' => $this->request->getVar('keterangan_1'),
            'keterangan_2' => $this->request->getVar('keterangan_2'),
            'koordinat_1' => $this->request->getVar('koordinat'),
            'status' => $status
        ];
        //dd($data);
        //Save to database
        $this->dbPresensi->save($data);

        session()->setFlashData('sweet', 'Data Presensi berhasil disimpan.');

        return redirect()->to('/');
    }

    public function save_out()
    {
        $id = $this->request->getVar('data_id');
        $pekerja_id = $this->request->getVar('pekerja_id');
        $tanggal_1 = $this->request->getVar('tanggal_1');
        $id_file = str_replace('-', '', url_title($tanggal_1));
        $id_file = str_replace(':', '', url_title($id_file));
        $id_file = $pekerja_id . str_replace(' ', '', url_title($id_file));

        $tanggal_2 = date('Y-m-d H:i:s');

        $foto_id2 = "";

        $encfoto2 = $this->request->getVar('urifoto2');
        if ($encfoto2 != "") {
            $binfoto2 = base64_decode($encfoto2);

            $foto_id2 = "f2" . $id_file . ".jpg";

            $pathfotoid2 = $this->pathUploadImgApp . "/presensi/f2/";

            if (!checkAndCreatePath($pathfotoid2)) {
                session()->setFlashData('danger2', ' Folder Foto 2 Tidak Ditemukan. <br>Hubungi administrator.');
                return redirect()->to("/presensi_out/$id");
            }

            $pathfotoid2 = $pathfotoid2 . $foto_id2;

            file_put_contents($pathfotoid2, $binfoto2);

            //resize image
            $image = \Config\Services::image();
            $image->withFile($pathfotoid2)
                ->resize(600, 400, true, "height")
                ->save($pathfotoid2);
        } else {
            session()->setFlashData('warning', ' Anda belum mengambil foto selfie. Proses simpan dibatalkan.');
            return redirect()->to("/presensi_out/$id");
        }

        $data = [
            'id' => $id,
            'tanggal_2' => $tanggal_2,
            'foto_2' => $foto_id2,
            'keterangan_2' => $this->request->getVar('keterangan_2'),
            'koordinat_2' => $this->request->getVar('koordinat'),
            'status' => "TA"
        ];

        //Save to database
        $this->dbPresensi->save($data);

        session()->setFlashData('sweet', 'Presensi Pulang berhasil disimpan.');

        return redirect()->to('/');
    }

    public function update($id)
    {
        $data = [
            'id' => $id,
            'nama' => $this->request->getVar('nama')
        ];

        //Save to database
        $this->dbPresensi->save($data);

        session()->setFlashData('sweet', 'Data Presensi berhasil diupdate.');

        return redirect()->to('/presensi');
    }


    public function delete($id)
    {
        $this->dbPresensi->delete($id);
        session()->setFlashData('sweet', 'Data Presensi berhasil dihapus.');
        return redirect()->to('/presensi');
    }

    public function detail($id)
    {
        $pathFotoPresensi = $this->pathUploadImgApp . "/presensi/";

        $appJSFoot = loadJS("presensi/presensi.js?v=1.0", "appjs");
        $appCSS = loadCSS("presensi.css", "appcss");

        $dtPresensi = $this->dbPresensi->getPresensi($id);

        $pegawaiId = $dtPresensi['pekerja_id'];
        $dtPegawai = $this->dbPegawai->getPegawaiDetail($pegawaiId);

        $this->dtContent['title'] = "Kehadiran Pegawai";
        $this->dtContent['page'] = "presensi_detail";

        $this->dtContent['dtPegawai'] = $dtPegawai;
        $this->dtContent['dtPresensi'] = $dtPresensi;

        $this->dtContent['pathFotoPresensi'] = $pathFotoPresensi;

        $this->dtContent['appCSS'] = $appCSS;
        $this->dtContent['appJSFoot'] = $appJSFoot;


        return view($this->appName . '/v_app', $this->dtContent);
    }
}
