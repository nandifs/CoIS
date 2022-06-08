<?php

namespace App\Models\SATPAM;

use CodeIgniter\Model;

class M_jadwalpiket extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mis__jadwal_piket';
    protected $returnType    = 'array';
    protected $allowedFields = ['jabatan'];
    protected $useTimestamps = true;

    public function getJadwalPiket($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }
}
