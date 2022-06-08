<?php

namespace App\Models\OPHARDUNG;

use CodeIgniter\Model;

class M_bukukegiatan extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mophar__buku_kegiatan';
    protected $returnType    = 'array';
    protected $allowedFields = ['tanggal', 'shift', 'jam_dinas', 'petugas', 'mitrakerja_id', 'status', 'slug', 'created_by'];
    protected $useTimestamps = true;

    public function getBukuKegiatan($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getBukuKegiatanAktif($mitra_id)
    {
        $this->where('status', 'Aktif')
            ->where('mitrakerja_id', $mitra_id);

        return $this->first();
    }

    public function getBukuKegiatanByMitraKerja($mitra_id = null)
    {
        if (!is_null($mitra_id)) {
            $this->where('mitrakerja_id', $mitra_id)
                ->orderBy('created_at', 'desc');
        }
        return $this->findAll();
    }
}
