<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user extends Model
{
    protected $table         = 'app__user';
    protected $returnType    = 'array';
    protected $allowedFields = ['uid', 'uname', 'email', 'kata_kunci', 'apps_id', 'otoritas_id', 'unitkerja_id', 'data_unit_id', 'data_akses_id', 'profile_id', 'status_id'];
    protected $useTimestamps = true;

    public function getUser($id = null)
    {
        if (is_null($id)) {
            $this->select('id, uid, uname, email, apps_id, unitkerja_id, data_unit_id, data_akses_id, otoritas_id, profile_id, status_id')
                ->where('otoritas_id<>', 99);
            return $this->findAll();
        } else {
            $this->select('id, uid, uname, email, apps_id, unitkerja_id, data_unit_id, data_akses_id, otoritas_id, profile_id, status_id')
                ->where('id', $id)->orderBy('apps_id', 'ASC');

            return $this->first();
        }
    }

    public function getUserByUid($uid = null)
    {
        if (is_null($uid)) {
            return $this->where('otoritas_id<>', 99)->findAll();
        } else {
            $this->select('uid, uname, kata_kunci, apps_id, data_akses_id, otoritas_id')
                ->where('uid', $uid);
            return $this->first();
        }
    }
}
