<?php

namespace App\Controllers;

use App\Database\DbHelperUser;

class Login extends BaseController
{
    public function user_login()
    {

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        //Cek Login Pengguna
        $dbH_User = new DbHelperUser;

        $jnsuser = "user";
        $cekuser = $dbH_User->getUserForLogin($username);

        if (is_null($cekuser)) {
            $cekuser = $dbH_User->getPegawaiForLogin($username);
            $jnsuser = "pegawai";
            if (is_null($cekuser)) {
                $cekuser = $dbH_User->getTenagakerjaForLogin($username);
                $jnsuser = "tenagakerja";
            }
        }

        if ($cekuser) {
            if ($cekuser->status_id != 1) {
                session()->setFlashdata('danger', 'User anda tidak aktif. <br> Silahkan hubungi administrator.');
            }

            $hash = $cekuser->kata_kunci;
            if (password_verify($password, $hash)) {
                $userdata = [
                    'uid' => $cekuser->uid,
                    'ujs' => $jnsuser
                ];

                session()->set('userdata', $userdata);
                session()->set('welcomepages', true);
            } else {
                session()->setFlashdata('danger', 'User atau Password yang anda masukan salah...');
            }
        } else {
            session()->setFlashdata('danger', 'User atau Password yang anda masukan salah...');
        }

        return redirect()->to('/');
    }

    public function user_logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    //--------------------------------------------------------------------

}
