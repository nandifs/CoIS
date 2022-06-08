<?php

namespace App\Models;

use CodeIgniter\Model;

class M_aplikasi extends Model
{
    protected $table      = 'app__aplikasi';
    protected $returnType     = 'array';

    public function getAplikasi($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            $this->select('id, nama, nama_lengkap, versi, status_id');
            $this->where('id', $id);
            return $this->first();
        }
    }
}
