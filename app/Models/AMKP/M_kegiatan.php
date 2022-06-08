<?php

namespace App\Models\AMKP;

use CodeIgniter\Model;

class M_kegiatan extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mip__kegiatan';
    protected $returnType    = 'array';
    protected $allowedFields = ['jenis', 'tanggal', 'lokasi', 'kondisi', 'keterangan', 'foto', 'petugas_id'];
    protected $useTimestamps = true;

    public function getKegiatan($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function countKegiatan($mitrakerjaid, $status, $tglkegiatan = null)
    {
        if ($mitrakerjaid == 0) {
            $this->where('kondisi', $status);
        } else {
            $this->where('unitkerja_id', $mitrakerjaid)
                ->where('kondisi', $status);
            if (!is_null($tglkegiatan)) {
                $this->where('tanggal', $tglkegiatan);
            }
        }
        return $this->countAllResults();
    }
}
