<?php

namespace App\Models\OPHARDUNG;

use CodeIgniter\Model;

class M_inventori extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mophar__inventori';
    protected $returnType    = 'array';
    protected $allowedFields = ['mitrakerja_id', 'produk_id', 'jumlah', 'kondisi', 'keterangan', 'updated_by'];
    protected $useTimestamps = true;

    public function getInventori($id = null)
    {
        $this->setTable("mophar__inventori a")
            ->select('a.*, b.nama as petugas, c.singkatan as mitrakerja')
            ->join('r3l_tad.mkp__tenagakerja b', 'a.updated_by=b.id', 'left')
            ->join('r3l_tad.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->orderBy('a.tanggal', 'asc');

        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->where("a.id", $id)->first();
        }
    }

    public function cekInventori($mitrakerjaId, $produkId)
    {
        $this->select('id')
            ->where("mitrakerja_id", $mitrakerjaId)
            ->where("produk_id", $produkId);

        return $this->first();
    }
}
