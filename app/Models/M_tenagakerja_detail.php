<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tenagakerja_detail extends Model
{
    protected $table      = 'mkp__tenagakerja_detail';
    protected $primaryKey = 'pegawai_id';
    protected $returnType     = 'array';
    protected $allowedFields = ['pegawai_id', 'no_identitas', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'telepon'];

    public function insertBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }
}
