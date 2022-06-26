<?php

namespace App\Controllers\Ketenagakerjaan;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Models\M_jabatan;
use App\Models\M_tenagakerja_mutasi;

class Tenagakerjamutasi extends BaseController
{
    protected $dbHelper;
    protected $dbMutasiTK;
    protected $dbJabatan;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbMutasiTK = new M_tenagakerja_mutasi();

        $this->dbJabatan = new M_jabatan();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $selDtAkses = $this->dtAksesMitra;
        $selComboDtAkses = $this->request->getVar("dtakses");

        $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

        if (is_null($selComboDtAkses)) {
            $selComboDtAkses = $dtMitraKerja[0]['id'];
        }

        $dtMutasiTK = $this->dbHelper->getDataMutasiByMitrakerja();

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('ketenagakerjaan/mutasi/tenagakerja_mutasi_data.js', "appjs");

        $this->dtContent['title'] = "Data Mutasi Tenaga Kerja";
        $this->dtContent['page'] = "ketenagakerjaan_mutasi_data";
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['selMitraKerja'] = $selDtAkses;

        $this->dtContent['dtMutasiTK'] = $dtMutasiTK;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function mutasi()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $nip_tk = $this->request->getVar("nip");
        if (!is_null($nip_tk)) {
            $dtTenagakerja = $this->dbHelper->getTenagakerjaByNIP($nip_tk);
            if (is_null($dtTenagakerja)) {
                session()->setFlashData('msg_info', 'Data Tidak Ditemukan!!!');
                redirect()->to("/ketenagakerjaan_mutasi")->withInput();
            }
            unset($dtTenagakerja['kata_kunci']);
            $pegawai_id = $dtTenagakerja['id'];
            $dtMutasiTK = $this->dbHelper->getDataMutasi($pegawai_id);
        } else {
            $dtTenagakerja = "";
        }

        $dtAksesUnitkerja = $this->dtAksesUnit;
        $dtAksesMitrakerja = $this->dtAksesMitra;

        $dtUnitKerja = $this->dbHelper->getUnitKerja($dtAksesUnitkerja);
        $dtMitraKerja = $this->dbHelper->getMitraKerja($dtAksesMitrakerja);
        $dtWilayahKerja = $this->dbHelper->getWilayahKerja(null, ["a.kelas" => 2]);

        if ($this->appID == "40") {
            $dtJabatan = $this->dbJabatan->getJabatan("All");
        } else {
            $dtJabatan = $this->dbJabatan->getJabatan($this->appID);
        }

        $dtJenisMutasi = $this->dbHelper->getJenisMutasi();
        $dtSifatMutasi = $this->dbHelper->getSifatMutasi();

        //plugins for datetimepicker in moment.js and tenpusdominus.js
        $appCSS =  loadCSS('tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css', 'adminlte_plugins');

        $appJSBefore =  loadJS('moment/moment.min.js', 'adminlte_plugins');
        $appJSBefore .=  loadJS('tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js', 'adminlte_plugins');
        $appJSBefore .=  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');

        $appJSAfter =  loadJS('ketenagakerjaan/mutasi/tenagakerja_mutasi.js', "appjs");

        $this->dtContent['title'] = "Ketenagakerjaan - Mutasi & Rotasi";
        $this->dtContent['page'] = "ketenagakerjaan_mutasi";

        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtWilayahKerja'] = $dtWilayahKerja;

        $this->dtContent['dtJenisMutasi'] = $dtJenisMutasi;
        $this->dtContent['dtSifatMutasi'] = $dtSifatMutasi;

        if (isset($dtMutasiTK)) {
            $this->dtContent['dtMutasiTK'] = $dtMutasiTK;
        }

        $this->dtContent['appCSS'] = $appCSS;
        $this->dtContent['appJSFootBefore'] = $appJSBefore;
        $this->dtContent['appJSFoot'] = $appJSAfter;


        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $redirectPath = "/ketenagakerjaan_mutasi";

        $pegawai_id = $this->request->getVar('pegawai_id');

        $jabatan_id = $this->request->getVar('jabatan_id');
        $unitkerja_id = $this->request->getVar('unitkerja_id');
        $penempatan_id = $this->request->getVar('penempatan_id');
        $wilayahkerja_id = $this->request->getVar('wilayahkerja_id');

        $jabatan_baru_id = $this->request->getVar('jabatan_baru');
        $unitkerja_baru_id = $this->request->getVar('unitkerja_baru');
        $penempatan_baru_id = $this->request->getVar('penempatan_baru');
        $wilayahkerja_baru_id = $this->request->getVar('wilkerja_baru');

        $jenis_mutasi = $this->request->getVar('jenis_mutasi');
        $sifat_mutasi = $this->request->getVar('sifat_mutasi');
        $ket_mutasi = $this->request->getVar('ket_mutasi');
        $tgl_berlaku = $this->request->getVar('tgl_berlaku');
        $tgl_berlaku = str_replace("-", "/", $tgl_berlaku);
        $tgl_berlaku = ubah_tgl_itm($tgl_berlaku);

        $file_berkas = $this->request->getFile('file_berkas');
        $file_berkas_name = $file_berkas->getName();
        if ($file_berkas->getError() != 4) {
            $datafile = array('file_berkas' => $file_berkas);

            $validation = \Config\Services::validation();
            if ($validation->run($datafile, 'import_berkas') == FALSE) {
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->to($redirectPath)->withInput();
            } else {
                $file_berkas_ext = $file_berkas->getExtension();
                $file_berkas_name = "fl_mts_$pegawai_id" . date('YMdHis') . "." . $file_berkas_ext;
                $file_berkas->move('uploads/KETENAGAKERJAAN/doc_mutasi', $file_berkas_name);
            }
        }

        $data = [
            'jenis_id' => $jenis_mutasi,
            'sifat_id' => $sifat_mutasi,

            'pegawai_id' => $pegawai_id,
            'jabatan_lama_id' => $jabatan_id,
            'unitkerja_lama_id' => $unitkerja_id,
            'penempatan_lama_id' => $penempatan_id,
            'wilayahkerja_lama_id' => $wilayahkerja_id,

            'jabatan_baru_id' => $jabatan_baru_id,
            'unitkerja_baru_id' => $unitkerja_baru_id,
            'penempatan_baru_id' => $penempatan_baru_id,
            'wilayahkerja_baru_id' => $wilayahkerja_baru_id,

            'keterangan_mutasi' => $ket_mutasi,
            'tanggal_berlaku' => $tgl_berlaku,
            'berkas' => $file_berkas_name
        ];

        $simpan = $this->dbMutasiTK->save($data);
        if ($simpan) {
            session()->setFlashData('sweet', 'Data berhasil ditambahkan!!!');
        } else {
            session()->setFlashData('msg_error', 'Data tidak berhasil ditambahkan!!!');
        }
        return redirect()->to($redirectPath);
    }
}
