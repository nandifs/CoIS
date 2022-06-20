<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tenagakerja_haknormatif extends Model
{
    protected $table      = 'mkp__tenagakerja_haknormatif';
    protected $primaryKey = 'haknormatif_id';
    protected $returnType     = 'array';

    public function insertBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }

    public function updateBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->updateBatch($data, 'haknormatif_id');
    }
}
