<?php

namespace App\Controllers\Ketenagakerjaan;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHTableKetenagakerjaan;
use App\Models\M_jabatan;
use App\Models\M_tenagakerja;
use App\Models\M_tenagakerja_detail;

class Tenagakerja extends BaseController
{
    protected $dbHelper;
    protected $dbTenagakerja;
    protected $dbTenagakerjaDetail;
    protected $dbJabatan;


    public function __construct()
    {
        $this->dbHelper = new DbHelper();

        $this->dbTenagakerja = new M_tenagakerja();
        $this->dbTenagakerjaDetail = new M_tenagakerja_detail();

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

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('ketenagakerjaan/tenagakerja_data.js', "appjs");

        $this->dtContent['title'] = "Data Tenaga Kerja";
        $this->dtContent['page'] = "ketenagakerjaan_data_tengakerja";
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['selMitraKerja'] = $selDtAkses;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function info()
    {
        //Cek otoritas user        
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $nip_tk = $this->request->getGet("nip");

        $this->dtContent['title'] = "Informasi Tenagakerja";
        $this->dtContent['page'] = "ketenagakerjaan_info_tenagakerja";

        if (!is_null($nip_tk)) {
            $dtTenagakerja = $this->dbHelper->getDataKetenagakerjaanByNip($nip_tk);
            //dd($dtTenagakerja);
            if (is_null($dtTenagakerja)) {
                session()->setFlashData('msg_info', 'Tenaga kerja dengan NIP : ' . $nip_tk . ' tidak ditemukan.');
            } else {
                $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
            }
        }

        $this->dtContent['nip_tk'] = $nip_tk;

        $appJS =  loadJS('ketenagakerjaan/tenagakerja_info.js', "appjs");
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function add()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $getNip = $this->request->getGet("nip");

        if (!is_null($getNip)) {
            $dtTenagakerja = $this->dbHelper->getDataKetenagakerjaanByNip($getNip);
            if (!is_null($dtTenagakerja)) {
                session()->setFlashData('msg_info', 'NIP tenaga kerja sudah digunakan.');
            }
        }

        $selMitrakerja = $this->request->getVar("dtakses");
        if ($this->appID == "40") {
            $dtJabatan = $this->dbJabatan->getJabatan("All");
        } else {
            $dtJabatan = $this->dbJabatan->getJabatan($this->appID);
        }

        if (is_null($selMitrakerja)) {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);
        } else {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($selMitrakerja);
        }

        $dtWilayahKerja = $this->dbHelper->getWilayahKerja(null, ["a.kelas" => 2]);

        $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);

        $this->dtContent['title'] = "Tambah Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_add";
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtWilayahKerja'] = $dtWilayahKerja;

        $this->dtContent['nip'] = $getNip;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $selMitrakerja = $this->request->getVar("dtakses");
        if ($this->appID == "40") {
            $dtJabatan = $this->dbJabatan->getJabatan("All");
        } else {
            $dtJabatan = $this->dbJabatan->getJabatan($this->appID);
        }

        if (is_null($selMitrakerja)) {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($this->dtAksesMitra);
        } else {
            $dtMitraKerja = $this->dbHelper->getMitraKerja($selMitrakerja);
        }

        $dtWilayahKerja = $this->dbHelper->getWilayahKerja(null, ["a.kelas" => 2]);
        $dtUnitKerja = $this->dbHelper->getUnitKerja($this->dtAksesUnit);

        $nip = $this->request->getPost("nip");

        if (!is_null($nip)) {
            $dtTenagakerja = $this->dbHelper->getDataKetenagakerjaanByNip($nip);
            if (is_null($dtTenagakerja)) {
                return redirect()->to("/ketenagakerjaan_info?nip=$nip");
            }

            $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        }

        $this->dtContent['title'] = "Update Data Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_edit";
        $this->dtContent['dtJabatan'] = $dtJabatan;
        $this->dtContent['dtUnitKerja'] = $dtUnitKerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;
        $this->dtContent['dtWilayahKerja'] = $dtWilayahKerja;

        $appJS =  loadJS('ketenagakerjaan/tenagakerja_update.js', "appjs");
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $nip = $this->request->getVar('nip');
        $nama = strtoupper($this->request->getVar('nama'));
        $jabatan_id = $this->request->getVar('jabatan');
        $unitkerja_id = $this->request->getVar('unitkerja');
        $penempatan_id = $this->request->getVar('penempatan');
        $wilayahkerja_id = $this->request->getVar('wilkerja');

        $no_identitas = $this->request->getVar('no_identitas');
        $tmp_lahir = strtoupper($this->request->getVar('tmp_lahir'));
        $tgl_lahir = $this->request->getVar('tgl_lahir');
        $jns_kelamin = $this->request->getVar('jns_kel');
        $alamat = $this->request->getVar('alamat');
        $telepon = $this->request->getVar('telepon');
        $email = $this->request->getVar('email');

        $password = password_hash($nip, PASSWORD_BCRYPT);

        $data = [
            'nip' => $nip,
            'nama' => $nama,
            'jabatan_id' => $jabatan_id,
            'unitkerja_id' => $unitkerja_id,
            'penempatan_id' => $penempatan_id,
            'wilayah_id' => $wilayahkerja_id,
            'email' => $email,
            'otoritas_id' => 4, //Otoritas = PEGAWAI
            'kata_kunci' => $password,
            'status_id' => 1,
            'apps_id' => 0
        ];

        //Save to database
        $simpan = $this->dbTenagakerja->save($data);
        if ($simpan) {
            $pegawai_id = $this->dbTenagakerja->getInsertID();
            $data_detail = [
                'pegawai_id' => $pegawai_id,
                'no_identitas' => $no_identitas,
                'tempat_lahir' => $tmp_lahir,
                'tanggal_lahir' => $tgl_lahir,
                'jenis_kelamin' => $jns_kelamin,
                'alamat' => $alamat,
                'telepon' => $telepon
            ];
            //Simpan data detail TK
            $this->dbTenagakerjaDetail->insert($data_detail);
            session()->setFlashData('success', 'Data Tenagakerja berhasil ditambahkan.');
        } else {
            session()->setFlashData('danger', 'Data Tenagakerja Gagal Ditambahkan.');
        }

        $this->session->set('smk', $penempatan_id);

        return redirect()->to('/tenagakerja_info_detail');
    }

    public function update()
    {
        $pegawai_id = $this->request->getVar('pegawai_id');

        $nip = $this->request->getVar('nip');
        $nama = strtoupper($this->request->getVar('nama'));
        $jabatan_id = $this->request->getVar('jabatan');
        $unitkerja_id = $this->request->getVar('unitkerja');
        $penempatan_id = $this->request->getVar('penempatan');
        $wilayahkerja_id = $this->request->getVar('wilkerja');

        $no_identitas = $this->request->getVar('no_identitas');
        $tmp_lahir = strtoupper($this->request->getVar('tmp_lahir'));
        $tgl_lahir = $this->request->getVar('tgl_lahir');
        $jns_kelamin = $this->request->getVar('jns_kel');
        $alamat = $this->request->getVar('alamat');
        $telepon = $this->request->getVar('telepon');
        $email = $this->request->getVar('email');

        $password = password_hash($nip, PASSWORD_BCRYPT);

        $file_foto = $this->request->getFile('foto_pegawai');

        if (is_null($file_foto)) {
            $nm_foto = "";
        } else {
            $nm_foto = $nip . "." . $file_foto->getExtension();
            $path_foto = "uploads/user/foto";
            $file_foto->move($path_foto, $nm_foto, true);

            //resize image
            $img_file = ($path_foto . "/" . $nm_foto);
            if (file_exists($img_file)) {
                $image = \Config\Services::image();
                $image->withFile($img_file)
                    ->resize(225, 225, false, "height")
                    ->save($img_file);
            }
        }

        $data = [
            'id' => $pegawai_id,
            'nip' => $nip,
            'nama' => $nama,
            'jabatan_id' => $jabatan_id,
            'unitkerja_id' => $unitkerja_id,
            'penempatan_id' => $penempatan_id,
            'wilayah_id' => $wilayahkerja_id,
            'email' => $email,
            'otoritas_id' => 4, //Otoritas = PEGAWAI
            'kata_kunci' => $password,
            'foto' => $nm_foto,
            'status_id' => 1,
            'apps_id' => 0
        ];

        //Save to database
        $simpan = $this->dbTenagakerja->save($data);
        if ($simpan) {
            $data_detail = [
                'pegawai_id' => $pegawai_id,
                'no_identitas' => $no_identitas,
                'tempat_lahir' => $tmp_lahir,
                'tanggal_lahir' => $tgl_lahir,
                'jenis_kelamin' => $jns_kelamin,
                'alamat' => $alamat,
                'telepon' => $telepon
            ];

            $simpan_detail = $this->dbTenagakerjaDetail->save($data_detail);
            if ($simpan_detail) {
                session()->setFlashData('success', 'Data Tenagakerja berhasil di perbarui.');
            } else {
                session()->setFlashData('danger', 'Data Detail Tenagakerja Gagal Di Perbarui.');
            }
        } else {
            session()->setFlashData('danger', 'Data Tenagakerja Gagal Diperbarui.');
        }

        $this->session->set('smk', $penempatan_id);

        return redirect()->to('/tenagakerja_info_detail');
    }

    public function delete()
    {
        $nip_tk = $this->request->getGet("nip");
        $dtTenagakerja = $this->dbHelper->getDataKetenagakerjaanByNip($nip_tk);
        if (is_null($dtTenagakerja)) {
            return redirect()->to("/ketenagakerjaan_info?nip=$nip_tk");
        }
        if ($this->dbTenagakerja->delete($nip_tk)) {
            session()->setFlashData('success', 'Data Tenagakerja berhasil di hapus');
        } else {
            session()->setFlashData('success', 'Data Tenagakerja GAGAL di hapus');
        }
    }

    public function laporan()
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

        //get tenagakerja by selected mitrakerja
        if ($this->session->has('smk')) {
            $selDtAkses = $this->session->smk;
            $dtTenagakerja = $this->dbHelper->getTenagakerjaByPenempatan("all", $selDtAkses);
        } else {
            $dtTenagakerja = $this->dbHelper->getTenagakerjaByPenempatan("all", $selComboDtAkses);
        }

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('ketenagakerjaan/data_tenagakerja.js', "appjs");

        $this->dtContent['title'] = "Data Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_daftar";

        $this->dtContent['dtTenagakerja'] = $dtTenagakerja;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        $this->dtContent['selMitraKerja'] = $selDtAkses;

        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    /**
     * AJAX FOR DATA TENAGAKERJA
     */

    public function delete_by_ajax($id)
    {
        if ($this->dbTenagakerja->delete($id)) {
            $status = array('status' => 'success');
        } else {
            $status = array('status' => 'failed');
        }
        echo json_encode($status);
    }
}
