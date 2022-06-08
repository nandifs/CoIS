<?php

namespace App\Models;

use CodeIgniter\Model;

class M_wilayahkerja extends Model
{
    protected $table      = 'org__wilayahkerja';
    protected $returnType     = 'array';
    protected $allowedFields = ['kode', 'wilayah', 'singkatan', 'kelas', 'induk_id'];

    public function getWilayahKerja($id = null)
    {
        $this->orderBy('kode, wilayah');
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function checkDuplicateEntry($qSearch)
    {
        $builder = $this->builder();
        return $builder->where($qSearch)->countAllResults();
    }
}
