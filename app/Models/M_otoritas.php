<?php

namespace App\Models;

use CodeIgniter\Model;

class M_otoritas extends Model
{
    protected $table      = 'app__user_otorisasi';
    protected $returnType     = 'array';
    protected $allowedFields = ['otorisasi'];

    public function getOtorisasi()
    {
        return $this->where('id<>', 99)->findAll();
    }
}
