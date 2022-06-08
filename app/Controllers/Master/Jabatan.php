<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\M_jabatan;

class Jabatan extends BaseController
{
    protected $dbJabatan;

    public function __construct()
    {
        $this->dbJabatan = new M_jabatan();
    }

    public function index()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dt_jabatan = $this->dbJabatan->getJabatan($this->appID);

        $this->dtContent['title'] = "Jabatan";
        $this->dtContent['page'] = "jabatan";
        $this->dtContent['dt_jabatan'] = $dt_jabatan;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function add()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        if ($this->hasLogin) {
            $this->dtContent['title'] = "Tambah Jabatan";
            $this->dtContent['page'] = "jabatan_add";
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function edit($id)
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $dt_jabatan = $this->dbJabatan->getJabatan($this->appID, $id);

        $this->dtContent['title'] = "Edit Jabatan";
        $this->dtContent['page'] = "jabatan_edit";
        $this->dtContent['dt_jabatan'] = $dt_jabatan;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function save()
    {
        $data = [
            'jabatan' => $this->request->getVar('nama'),
            'singkatan' => $this->request->getVar('singkatan')
        ];

        //Save to database
        $this->dbJabatan->save($data);

        session()->setFlashData('info', 'Data Jabatan berhasil ditambahkan.');

        return redirect()->to('/jabatan');
    }

    public function update($id)
    {
        $data = [
            'id' => $id,
            'jabatan' => $this->request->getVar('nama'),
            'singkatan' => $this->request->getVar('singkatan')
        ];

        //Save to database
        $this->dbJabatan->save($data);

        session()->setFlashData('info', 'Data Jabatan berhasil diupdate.');

        return redirect()->to('/jabatan');
    }

    public function delete($id)
    {
        if ($this->oto_id == "99" || $this->oto_id == "1" || $this->oto_id == "2") {
            $this->dbJabatan->delete($id);
            session()->setFlashData('info', 'Data Jabatan berhasil dihapus.');
            return redirect()->to('/jabatan');
        } else {
            return redirect()->to("/");
        }
    }

    //--------------------------------------------------------------------

}
