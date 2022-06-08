<?php

namespace App\Models\SATPAM;

use CodeIgniter\Model;

class M_kendaraan extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mis__kendaraan';
    protected $returnType    = 'array';
    //protected $allowedFields = ['no_polisi', 'pemilik', 'jns_kendaraan', 'waktu', 'foto', 'status', 'petugas_id', 'mitrakerja_id', 'created_at', 'updated_at'];
    protected $allowedFields = ['no_polisi', 'pemilik', 'jns_kendaraan', 'jam_masuk', 'jam_keluar', 'foto_masuk', 'foto_keluar', 'ket_masuk', 'ket_keluar', 'status', 'petugas_id_masuk', 'petugas_id_keluar', 'mitrakerja_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getKendaraanById($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->where("id", $id)->first();
        }
    }
}
