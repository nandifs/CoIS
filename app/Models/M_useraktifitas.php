<?php

namespace App\Models;

use CodeIgniter\Model;

class M_useraktifitas extends Model
{
    protected $table      = 'app__user_aktifitas';
    protected $returnType     = 'array';
    protected $allowedFields = ['uid', 'aktifitas', 'status', 'koordinat', 'apps_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getAktifitas($id = null)
    {
        if (is_null($id)) {
            $this->select('id, uid, aktifitas, status, koordinat')
                ->where('otoritas_id<>', 99);
            return $this->findAll();
        } else {
            $this->select('id, uid, aktifitas, status, koordinat')
                ->where('id', $id)->orderBy('apps_id', 'ASC');

            return $this->first();
        }
    }

    public function getAktifitasByUid($uid = null)
    {
        if (is_null($uid)) {
            return $this->where('otoritas_id<>', 99)->findAll();
        } else {
            $this->select('id, uid, aktifitas, status, koordinat')
                ->where('uid', $uid);
            return $this->first();
        }
    }
}
