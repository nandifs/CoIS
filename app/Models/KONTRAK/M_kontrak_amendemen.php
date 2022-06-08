<?php

namespace App\Models\KONTRAK;

use CodeIgniter\Model;

class M_kontrak_amendemen extends Model
{
    protected $table      = 'pks__amendemen';
    protected $returnType     = 'array';
    protected $allowedFields = [
        'kontrak_id', 'no_amendemen',
        'uraian', 'nilai_bulan_ppn',
        'nilai_total_ppn', 'tanggal_awal',
        'tanggal_awal', 'update_oleh'
    ];
    protected $useTimestamps = true;

    public function getAmendemen($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    //Import Kontrak From Xls
    public function insertBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }

    public function updateBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->updateBatch($data, 'id');
    }
}
