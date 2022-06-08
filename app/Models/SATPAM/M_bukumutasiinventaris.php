<?php

namespace App\Models\SATPAM;

use CodeIgniter\Model;

class M_bukumutasiinventaris extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mis__buku_mutasi_inventaris';
    protected $returnType    = 'array';
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
