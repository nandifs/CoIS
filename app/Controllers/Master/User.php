<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

use App\Database\DbHelperUser;
use App\Models\M_aplikasi;
use App\Models\M_unitkerja;
use App\Models\M_mitrakerja;
use App\Models\M_otoritas;
use App\Models\M_user;

class User extends BaseController
{
    protected $dbH_User;

    protected $dbUser;
    protected $dbUnitKerja;
    protected $dbMitraKerja;
    protected $dbOtoritas;
    protected $dbAplikasi;


    public function __construct()
    {
        $this->dbH_User = new DbHelperUser();

        $this->dbUser = new M_user();
        $this->dbUnitKerja = new M_unitkerja();
        $this->dbMitraKerja = new M_mitrakerja();
        $this->dbOtoritas = new M_otoritas();
        $this->dbAplikasi = new M_aplikasi();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1") {
            return redirect()->to("/");
        }

        if ($this->appID == 1) {
            $dtUser = $this->dbH_User->getUserDetail();
        } else {
            $dtUser = $this->dbH_User->getUserDetailByApplicationId($this->appID);
        }

        $dtMitraKerja = $this->dbMitraKerja->getMitraKerja();

        $this->dtContent['page'] = "user";
        $this->dtContent['title'] = "Pengguna Aplikasi";
        $this->dtContent['dtUser'] = $dtUser;
        $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    //--------------------------------------------------------------------
    public function add()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1") {
            return redirect()->to("/");
        }

        if ($this->appID == 1) {
            $dtAplikasi = $this->dbAplikasi->getAplikasi();
        } else {
            $dtAplikasi[] = $this->dbAplikasi->getAplikasi($this->appID);
        }

        $dtOtoritas = $this->dbOtoritas->getOtorisasi();
        $dtUnitKerja = $this->dbUnitKerja->getUnitKerja();
        $dtMitraKerja = $this->dbMitraKerja->getMitraKerja();

        $this->dtContent['page'] = "user_add";
        $this->dtContent['title'] = "Tambah User";
        $this->dtContent['dtAplikasi'] = $dtAplikasi;
        $this->dtContent['dtOtoritas'] = $dtOtoritas;
        $this->dtContent['dtUnitkerja'] = $dtUnitKerja;
        $this->dtContent['dtMitrakerja'] = $dtMitraKerja;
        $this->dtContent['validation'] = \Config\Services::validation();

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1") {
            return redirect()->to("/");
        }

        if ($this->appID == 1) {
            $dtAplikasi = $this->dbAplikasi->getAplikasi();
        } else {
            $dtAplikasi[] = $this->dbAplikasi->getAplikasi($this->appID);
        }

        $dtUser = $this->dbUser->getUser($id);
        $dtOtoritas = $this->dbOtoritas->getOtorisasi();
        $dtUnitKerja = $this->dbUnitKerja->getUnitKerja();
        $dtMitraKerja = $this->dbMitraKerja->getMitraKerja();

        $this->dtContent['page'] = "user_edit";
        $this->dtContent['title'] = "Update User";
        $this->dtContent['dtUser'] = $dtUser;
        $this->dtContent['dtAplikasi'] = $dtAplikasi;
        $this->dtContent['dtOtoritas'] = $dtOtoritas;
        $this->dtContent['dtUnitkerja'] = $dtUnitKerja;
        $this->dtContent['dtMitrakerja'] = $dtMitraKerja;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1") {
            return redirect()->to("/");
        }

        //Validation
        if (!$this->validate([
            'uid' => [
                'rules' => 'required|is_unique[app__user.uid]',
                'errors' => [
                    'required' => 'Id User tidak boleh kosong.',
                    'is_unique' => 'User Id sudah terdaftar.'
                ]
            ],
            'uname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama User tidak boleh kosong.'
                ]
            ]

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('user_add')->withInput()->withInput('validation', $validation);
        }

        $uid = $this->request->getVar('uid');
        $password = password_hash($uid, PASSWORD_BCRYPT);

        $data = [
            'uid' => $uid,
            'uname' => $this->request->getVar('uname'),
            'email' => $this->request->getVar('uemail'),
            'apps_id' => $this->request->getVar('aplikasi'),
            'unitkerja_id' => $this->request->getVar('unitkerja'),
            'data_unit_id' => $this->request->getVar('dtaksesunit'),
            'data_akses_id' => $this->request->getVar('dtaksesmitrakerja'),
            'otoritas_id' => $this->request->getVar('otoritas'),
            'kata_kunci' => $password,
            'status_id' => 1
        ];

        //dd($data);
        //Save to database
        $simpan = $this->dbUser->save($data);
        if ($simpan) {
            session()->setFlashData('sweet', 'Data Pengguna berhasil ditambahkan.');
        } else {
            session()->setFlashData('warning', 'Data Pengguna Tidak Berhasil Ditambahkan!!!');
        }

        return redirect()->to('user_aplikasi');
    }

    public function update($id)
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1") {
            return redirect()->to("/");
        }

        $uid = $this->request->getVar('uid');
        $password = $this->request->getVar('upassword');

        $data = [
            'id' => $id,
            'uid' => $uid,
            'uname' => $this->request->getVar('uname'),
            'email' => $this->request->getVar('uemail'),
            'apps_id' => $this->request->getVar('aplikasi'),
            'unitkerja_id' => $this->request->getVar('unitkerja'),
            'data_unit_id' => $this->request->getVar('dtaksesunit'),
            'data_akses_id' => $this->request->getVar('dtaksesmitrakerja'),
            'otoritas_id' => $this->request->getVar('otoritas'),
            'status_id' => $this->request->getVar('status')
        ];

        if ($password == "#reset") {
            $newpassword = password_hash($uid, PASSWORD_BCRYPT);
            $data['kata_kunci'] = $newpassword;
        }

        //Save to database
        $simpan = $this->dbUser->save($data);
        if ($simpan) {
            session()->setFlashData('sweet', 'Data Pengguna berhasil diupdate.');
        } else {
            session()->setFlashData('warning', 'Data Pengguna Tidak Berhasil Diperbarui!!!');
        }

        return redirect()->to('/user_aplikasi');
    }

    public function delete($id)
    {
        if ($this->oto_id == "99" || $this->oto_id == "1") {
            $this->dbUser->delete($id);
            session()->setFlashData('sweet', 'Data Pengguna berhasil dihapus.');

            return redirect()->to('/user_aplikasi');
        } else {
            return redirect()->to("/");
        }
    }

    //--------------------------------------------------------------------

}
