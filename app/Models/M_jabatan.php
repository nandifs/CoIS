<?php

namespace App\Models;

use CodeIgniter\Model;

class M_jabatan extends Model
{
    protected $table      = 'mkp__jabatan';
    protected $returnType     = 'array';
    protected $allowedFields = ['jabatan', 'singkatan', 'tingkat', 'induk_id', 'grup'];
    protected $useTimestamps = true;

    public function getJabatan($appId, $id = null)
    {
        if (is_null($id)) {
            if ($appId == "All") {
                return $this->findAll();
            } else {
                $this->where("grup", $appId);
                return $this->findAll();
            }
        } else {
            return $this->find($id);
        }
    }

    public function getJabatanIdBySingkatan($jabatan = null)
    {
        return $this->select('id')->where('singkatan', $jabatan)->first();
    }
}
