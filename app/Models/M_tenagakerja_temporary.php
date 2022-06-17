<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tenagakerja_temporary extends Model
{
    protected $table      = 'mkp__tenagakerja_temp';
    protected $returnType     = 'array';
    protected $allowedFields = [
        'status_import', 'validasi',

        'kontrak_pks_id', 'tenagakerja_id', 'nip', 'nama', 'no_identitas', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'telepon', 'email',
        'no_pkwt', 'tanggal_awal', 'tanggal_akhir', 'jabatan_id', 'unitkerja_id', 'mitrakerja_id', 'penempatan_id', 'wilayah_id',
        'no_npwp', 'no_kartu_keluarga', 'no_bpjs_kt', 'no_bpjs_ks', 'no_rek_payroll', 'bank_rek_payroll', 'bank_rek_payroll_id', 'no_rek_dplk', 'bank_rek_dplk', 'bank_rek_dplk_id',
        'pendidikan_id', 'program_studi',
        'nama_ibu', 'nama_pasangan_hidup', 'nama_anak_1', 'nama_anak_2', 'nama_anak_3',
        'no_skk_1', 'no_skk_2', 'keterangan',

        'import_tanggal', 'import_oleh'
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
