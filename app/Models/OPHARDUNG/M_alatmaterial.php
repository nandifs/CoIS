<?php

namespace App\Models\OPHARDUNG;

use CodeIgniter\Model;

class M_alatmaterial extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mophar__alat_material';
    protected $returnType    = 'array';

    public function getAlatMaterial($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->where("d", $id)->first();
        }
    }
}
