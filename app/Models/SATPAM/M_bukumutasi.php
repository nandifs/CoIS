<?php

namespace App\Models\SATPAM;

use CodeIgniter\Model;

class M_bukumutasi extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mis__buku_mutasi';
    protected $returnType    = 'array';
    protected $allowedFields = ['tanggal', 'shift', 'jam_dinas', 'petugas', 'mitrakerja_id', 'status', 'slug', 'created_by'];
    protected $useTimestamps = true;

    public function getDataMutasi($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getDataMutasiAktif($mitra_id)
    {
        $this->where('status', 'Aktif')
            ->where('mitrakerja_id', $mitra_id);

        return $this->first();
    }

    public function getDataMutasiByMitraKerja($mitra_id = null)
    {
        if (!is_null($mitra_id)) {
            $this->where('mitrakerja_id', $mitra_id)
                ->orderBy('created_at', 'desc');
        }
        return $this->findAll();
    }
}
