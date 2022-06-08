<?php

namespace App\Models\SATPAM;

use CodeIgniter\Model;

class M_titikinspeksi extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mis__titik_kontrol';
    protected $returnType    = 'array';
    protected $allowedFields = ['grup', 'lokasi', 'mitrakerja_id'];

    public function getTitikInspeksi($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getTitikInspeksiDetail($id = null)
    {
        $builder = $this->db->table('mis__titik_kontrol a');
        $builder->select('a.*, b.mitrakerja, b.singkatan')
            ->join('org__mitrakerja b', 'a.mitrakerja_id=b.id', 'left');

        if (is_null($id)) {
            return $builder->get()->getResultArray();
        } else {
            return $builder->where('a.id', $id)->get()->getRowArray(0);
        }
    }

    public function getTitikInspeksiByMitraKerja($mitrakerja)
    {
        return $this->where('mitrakerja_id', $mitrakerja)->findAll();
    }
}
