<?php

namespace App\Controllers;

use App\Models\M_useraktifitas;

class Home extends BaseController
{
    public function index()
    {
        if ($this->hasLogin) {
            if (strtoupper($this->dtContent['page']) == "DASHBOARD") {
                $cAppName = ucfirst(strtolower($this->appName));
                if ($this->otoritas == "TENAGAKERJA") {
                    return redirect()->to(base_url("/$cAppName/petugas/dashboard"));
                } else {
                    return redirect()->to(base_url("/$cAppName/dashboard"));
                }
            } else {
                return view($this->appName . '/v_app', $this->dtContent);
            }
        } else {
            return view('v_app', $this->dtContent);
        }
    }

    public function update_geolocation()
    {
        $koordinat = $this->request->getVar('koordinat');

        $dtUserAktifitas = new M_useraktifitas();

        $aktifitasUser = $dtUserAktifitas->getAktifitasByUid($this->user_uid);

        $data = [
            'apps_id' => $this->appID,
            'uid' => $this->user_uid,
            'koordinat' => $koordinat,
            'online' => 1
        ];

        if (!is_null($aktifitasUser)) {
            $data['id'] = $aktifitasUser['id'];
        }

        $simpan = $dtUserAktifitas->save($data);

        $status = array("status" => $simpan, "data" => $data);
        //output to json format
        echo json_encode($status);
    }
}
