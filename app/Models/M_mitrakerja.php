<?php

namespace App\Models;

use CodeIgniter\Model;

class M_mitrakerja extends Model
{
    protected $table      = 'org__mitrakerja';
    protected $returnType = 'array';
    protected $allowedFields = ['kode', 'mitrakerja', 'singkatan', 'kelas', 'induk_id', 'unitkerja_id'];
    protected $useTimestamps = true;

    public function getMitraKerja($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getMitraKerjaByKelas($kelas_id, $mitrakerja_id = null)
    {
        $this->select('id, kode mitrakerja, singkatan, kelas, induk_id');
        if (!is_null($mitrakerja_id) && $mitrakerja_id != 9999) {
            $this->where('induk_id', $mitrakerja_id);
        }
        return $this->whereIn('kelas', $kelas_id)->findAll();
    }

    public function getMitraKerjaIdByNamaSingkat($nama_singkat)
    {
        return $this->select('id')->where('singkatan', $nama_singkat)->first();
    }

    public function checkDuplicateEntry($qSearch)
    {
        $builder = $this->builder();
        return $builder->where($qSearch)->countAllResults();
    }
}
