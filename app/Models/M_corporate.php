<?php

namespace App\Models;

use CodeIgniter\Model;

class M_corporate extends Model
{
    protected $table      = 'org__perusahaan';
    protected $returnType     = 'array';

    public function getCorporate($id)
    {
        if ($id == null) {
            return $this->findAll();
        } else {
            $this->select("id, nomor, nama, nama_panjang, uraian");
            return $this->find($id);
        }
    }
}
