<?php

namespace App\Models;

use CodeIgniter\Model;

class M_shift extends Model
{
    protected $table      = 'mkp__shift';
    protected $returnType     = 'array';
    protected $allowedFields = ['nama', 'shift', 'jam_dinas', 'keterangan'];

    public function getShift($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }
}
