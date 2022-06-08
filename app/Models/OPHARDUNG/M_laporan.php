<?php

namespace App\Models\OPHARDUNG;

use CodeIgniter\Model;

class M_laporan extends Model
{
    protected $table      = 'mis__laporan';
    protected $returnType     = 'array';
    protected $allowedFields = ['periode', 'content', 'unitkerja_id', 'mitrakerja_id', 'created_by', 'updated_by'];
    protected $useTimestamps = true;

    public function getLaporan($id)
    {
        $this->where('id', $id);

        return $this->find();
    }

    public function getLaporanByPeriode($mitrakerja_id, $periode)
    {
        $this->where('mitrakerja_id', $mitrakerja_id);
        $this->where('periode', $periode);

        return $this->first();
    }
}
