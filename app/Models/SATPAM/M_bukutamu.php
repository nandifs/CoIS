<?php

namespace App\Models\SATPAM;

use CodeIgniter\Model;

class M_bukutamu extends Model
{
    protected $DBGroup       = 'pekerjaanDb';
    protected $table         = 'mis__buku_tamu';
    protected $returnType    = 'array';
    protected $allowedFields = ['tanggal', 'nama_tamu', 'alamat', 'telepon', 'instansi_pekerjaan', 'bertemu', 'keperluan', 'jam_masuk', 'jam_keluar', 'file_foto_dan_ttd', 'mitrakerja_id', 'status', 'created_by', 'updated_by'];
    protected $useTimestamps = true;

    public function getTamu($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }
}
