<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tenagakerja_temporary extends Model
{
    protected $table      = 'mkp__tenagakerja_temp';
    protected $returnType     = 'array';
    protected $allowedFields = [
        'nip', 'nama', 'jabatan_id', 'unitkerja_id', 'penempatan_id', 'wilayah_id', 'email', 'foto', 'otoritas_id', 'status_id', 'apps_id',
        'no_identitas', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'telepon', 'pendidikan_terakhir', 'program_studi'
    ];

    public function insertBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }

    public function updateBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->updateBatch($data, 'id');
    }
}
