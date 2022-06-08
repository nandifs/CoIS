<?php

namespace App\Controllers\Satpam;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperSatpam;
use App\Models\M_mitrakerja;
use App\Models\SATPAM\M_bukutamu;

class Bukutamu extends BaseController
{
    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperSatpam = new DbHelperSatpam();

        $this->dbBukuTamu = new M_bukutamu();
    }

    public function index()
    {
        if ($this->hasLogin) {
            $appCSS = loadCSS('bukutamu.css', 'appcss');

            $appJSFoot =  loadJS('satpam/bukutamu.js', "appjs");

            $selPeriode = "Hari Ini";

            $selDtAkses = $this->dtAksesMitra;

            if ($this->otoritas != "TENAGAKERJA") {
                $selDtAkses = $this->dtAksesMitra;

                $dbMitrakerja = new M_mitrakerja();
                if ($selDtAkses == "9999") {
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

                if (!empty($dtMitraKerja)) {
                    $selDtAkses = $this->request->getVar("dtakses");
                    $selPeriode = $this->request->getVar("sel_periode");
                    if (is_null($selDtAkses)) {
                        $selDtAkses = $dtMitraKerja[0]['id'];
                    }
                    if (is_null($selPeriode)) {
                        $selPeriode = "Hari Ini";
                    }
                }
                //dd($selPeriode);
                $this->dtContent['selDtAkses'] = $selDtAkses;
                $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
            }

            $dtTamu = $this->dbHelperSatpam->getTamuPerUnit($selPeriode, $selDtAkses);

            $jmlTamuHariIni = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 1, "Hari Ini");
            $jmlTamuKeluar = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 2, "Hari Ini");
            $jmlTamuDidalam = $this->dbHelperSatpam->countStatusTamu($selDtAkses, 1, "Bulan Ini");

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;

            $this->dtContent['page'] = "bukutamu";
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

            $pathCSS = "\t" . '<link rel="stylesheet" href="' . base_url() . '/app';
            $pathJS = "\t" . '<script src="' . base_url() . '/app';

            $appCSS = $pathCSS . '/plugins/webcam-easy/css/webcam-app.css">' . PHP_EOL;
            $appCSS = $appCSS . $pathCSS . '/plugins/signature-pad/jquery.signaturepad.css">' . PHP_EOL;
            $appCSS = $appCSS . $pathCSS . '/css/bukutamu.css">';

            $appJSFoot =  $pathJS . '/plugins/webcam-easy/js/webcam-easy.min.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/plugins/webcam-easy/js/html2canvas.min.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/plugins/signature-pad/bezier.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/plugins/signature-pad/numeric-1.2.6.min.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/plugins/signature-pad/jquery.signaturepad.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/js/webcam-easy.app.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/js/bukutamuupdate.js"></script>';

            $this->dtContent['page'] = "bukutamu_add";
            $this->dtContent['title'] = "Buku Tamu";
            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        if ($this->hasLogin) {
            $pathCSS = "\t" . '<link rel="stylesheet" href="' . base_url() . '/app';
            $appCSS = $pathCSS . '/css/bukutamu.css">';

            $dtTamu = $this->dbBukuTamu->getTamu($id);

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['page'] = "bukutamu_edit";
            $this->dtContent['title'] = "Buku Tamu";
            $this->dtContent['dtTamu'] = $dtTamu;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $created_by = $this->dtUser['id'];
        //$unitkerja_id = 3; //Ini sementara, nanti ambil dari database
        $mitrakerja_id = $this->dtAksesMitra;
        $tanggal = $this->request->getVar('tanggal');
        $jam_masuk = $this->request->getVar('jam_masuk');

        //Create File Id
        $id_file =  str_replace("-", "", $tanggal) . str_replace(":", "", $jam_masuk) . mt_rand(100, 999);

        //Get Foto Id
        $encfoto1 =  $this->request->getVar('urifoto1');
        $binfoto1 = base64_decode($encfoto1);

        $pathfotoid = './uploads/tamu/id/';
        $foto_id = "fid" . $id_file . ".jpg";
        file_put_contents($pathfotoid . $foto_id, $binfoto1);

        //Get Foto Tamu
        $encfoto2 = $this->request->getVar('urifoto2');
        $binfoto2 = base64_decode($encfoto2);

        $pathfototamu = './uploads/tamu/foto/';
        $foto_tamu = "ftm" . $id_file . ".jpg";
        file_put_contents($pathfototamu . $foto_tamu, $binfoto2);

        //Get Ttd Tamu
        $encttdtamu = $this->request->getVar('urittd');
        $binttdtamu = base64_decode($encttdtamu);

        $pathttdtamu = './uploads/tamu/ttd/';
        $ttd_tamu = "ttd" . $id_file . ".png";
        file_put_contents($pathttdtamu . $ttd_tamu, $binttdtamu);
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

        return redirect()->to('/bukutamu');
    }

    public function update($id)
    {
        $update_by = $this->dtUser['id'];
        $tanggal = $this->request->getVar('tanggal');
        $jam_keluar = $this->request->getVar('jam_keluar');
        $tgl_jam_keluar = $tanggal . " " . $jam_keluar;
        $status = 2;
        $data = [
            'nama_tamu' => $this->request->getVar('nama_tamu'),
            'alamat' => $this->request->getVar('alamat'),
            'telepon' => $this->request->getVar('telp'),
            'alamat' => $this->request->getVar('alamat'),
            'instansi_pekerjaan' => $this->request->getVar('instansi'),
            'bertemu' => $this->request->getVar('bertemu'),
            'keperluan' => $this->request->getVar('keperluan'),
            'jam_keluar' => $tgl_jam_keluar,
            'status' => $status,
            'updated_by' => $update_by
        ];

        //Save to database
        $this->dbBukuTamu->save($data);

        session()->setFlashData('sweet', 'Data Tamu berhasil diupdate.');

        return redirect()->to('/bukutamu');
    }

    public function updatejamkeluar()
    {
        $update_by = $this->dtUser['id'];

        $id_tamu = $this->request->getVar('up_id_tamu');
        $tgl_jam_keluar = $this->request->getVar('up_jam_keluar');
        $status = 2;

        $data = [
            'id' => $id_tamu,
            'jam_keluar' => $tgl_jam_keluar,
            'status' => $status,
            'updated_by' => $update_by
        ];

        //Save to database
        $this->dbBukuTamu->save($data);

        session()->setFlashData('sweet', 'Data Tamu berhasil diupdate.');

        return redirect()->to('/bukutamu');
    }

    public function delete($id)
    {
        $this->dbBukuTamu->delete($id);
        session()->setFlashData('sweet', 'Data Tamu berhasil dihapus.');
        return redirect()->to('/bukutamu');
    }

    /**
     * AJAX
     */
    public function ajax_get_tamu($id)
    {
        $dtTamu = $this->dbBukuTamu->getTamu($id);

        //output to json format
        echo json_encode($dtTamu);
    }
}
