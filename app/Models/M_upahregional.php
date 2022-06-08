<?php

namespace App\Models;

use CodeIgniter\Model;

class M_upahregional extends Model
{
    protected $table      = 'oth__upah_regional';
    protected $returnType     = 'array';
    protected $allowedFields = ['wilayah_id', 'jenis', 'tahun', 'upah'];

    public function getUpahRegional($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getUpahRegionalByTahun($id = null)
    {
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
