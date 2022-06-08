<?php

namespace App\Models\SATPAM;

use CodeIgniter\Model;

class M_regu extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mis__regu';
    protected $returnType    = 'array';
    protected $allowedFields = ['regu'];
    protected $useTimestamps = true;

    public function getRegu($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }
}
