<?php

namespace App\Models\OPHARDUNG;

use CodeIgniter\Model;

class M_bukukegiataninventaris extends Model
{
    protected $table      = 'mophar__buku_kegiatan_inventaris';
    protected $returnType     = 'array';
    protected $allowedFields = ['buku_mutasi_id', 'barang', 'jumlah', 'kondisi', 'keterangan'];

    public function getDataMutasiInventaris($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }
}
