<?php

namespace App\Models\SATPAM;

use CodeIgniter\Model;

class M_reguanggota extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mis__regu_anggota';
    protected $returnType    = 'array';
    protected $allowedFields = ['regu_id', 'petugas_id'];
    protected $useTimestamps = true;

    public function getAnggotaRegu($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function checkIfAlreadySet($id_petugas)
    {
        return $this->where('petugas_id', $id_petugas)->first();
    }

    public function getAnggotaReguDetail($id = null)
    {
        $this->setTable("mis__regu_anggota a")
            ->select('a.id, a.regu_id, a. petugas_id, b.regu, c.nama as petugas, d.singkatan as jabatan, e.singkatan as unitkerja, f.singkatan as penempatan')
            ->join('mis__regu b', 'a.regu_id=b.id', 'left')
            ->join('mkp__tenagakerja c', 'a.petugas_id=c.id', 'left')
            ->join('mkp__jabatan d', 'c.jabatan_id=d.id', 'left')
            ->join('org__unitkerja e', 'c.unitkerja_id=e.id', 'left')
            ->join('org__mitrakerja f', 'c.penempatan_id=f.id', 'left')
            ->orderBy('a.regu_id', 'asc')
            ->orderBy('d.singkatan', 'asc')
            ->orderBy('c.nama', 'asc');

        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->where("a.id=$id")->first();
        }
    }
}
