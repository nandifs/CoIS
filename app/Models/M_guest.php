<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user extends Model
{
    protected $table      = 'app__users';
    protected $returnType     = 'array';
    protected $allowedFields = ['uid', 'uname', 'email', 'kata_kunci', 'status_id'];
    protected $useTimestamps = true;

    public function getAdmin($uid = null)
    {
        if (is_null($uid)) {
            return $this->where('otoritas_id<>', 99)->findAll();
        } else {
            $this->select('uid, uname, kata_kunci, status_id')
                ->where('uid', $uid);
            return $this->first();
        }
    }

    public function getUserForSession($uid = null)
    {
        $this->setTable('app__users a')
            ->select('a.uid, a.uname, b.status, a.otoritas_id, c.otorisasi')
            ->join('app__user_status b', 'a.status_id=b.id', 'left')
            ->join('app__otorisasi c', 'a.otoritas_id=c.id', 'left')
            ->where('a.uid', $uid);
        return $this->first();
    }

    public function getUserDetail($uid = null)
    {
        $this->setTable('app__users a')
            ->select('a.*, b.status, c.otorisasi')
            ->join('app__user_status b', 'a.status_id=b.id', 'left')
            ->join('app__otorisasi c', 'a.otoritas_id=c.id', 'left')
            ->where('a.otoritas_id<>', 99);

        if (is_null($uid)) {
            return $this->findAll();
        } else {
            return $this->where("a.uid=$uid")->first();
        }
    }
}
