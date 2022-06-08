<?php

namespace App\Models;

use CodeIgniter\Model;

class M_unitkerja extends Model
{
    protected $table      = 'org__unitkerja';
    protected $returnType     = 'array';
    protected $allowedFields = ['kode', 'unitkerja', 'singkatan', 'kelas_id', 'induk_id', 'wilayah_id'];
    protected $useTimestamps = true;

    public function getUnitKerja($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getUnitKerjaByKelas($kelas)
    {
        return $this->select('id, kode, unitkerja, singkatan, kelas_id, induk_id, wilayah_id')->whereIn('kelas_id', $kelas)->findAll();
    }

    public function getUnitKerjaIdByNamaSingkat($nama_singkat)
    {
        return $this->select('id')->where('singkatan', $nama_singkat)->first();
    }

    public function checkDuplicateEntry($qSearch)
    {
        $builder = $this->builder();
        return $builder->where($qSearch)->countAllResults();
    }
}
