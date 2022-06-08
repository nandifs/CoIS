<?php

namespace App\Models\OPHARDUNG;

use CodeIgniter\Model;

class M_bukumutasipetugas extends Model
{
    protected $table      = 'mis__buku_mutasi_petugas';
    protected $returnType     = 'array';
    protected $allowedFields = ['buku_mutasi_id', 'petugas_id', 'keterangan'];

    public function getDataMutasiTenagakerja($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }
}
