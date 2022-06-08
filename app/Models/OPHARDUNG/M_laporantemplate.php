<?php

namespace App\Models\OPHARDUNG;

use CodeIgniter\Model;

class M_laporantemplate extends Model
{
    protected $table      = 'mis__laporan_template';
    protected $returnType     = 'array';
    protected $allowedFields = ['nama', 'content', 'keterangan'];
    protected $useTimestamps = true;

    public function getTemplate($id = null)
    {
        if (!is_null($id)) {
            return $this->find($id);
        } else {
            return $this->findAll();
        }
    }
}
