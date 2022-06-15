<?php

namespace App\Models\KONTRAK;

use CodeIgniter\Model;

class M_kontrak_temporary extends Model
{
    protected $table      = 'pks__kontrak_temp';
    protected $returnType     = 'array';
    protected $allowedFields = [
        'status_import', 'validasi', 'kontrak_id',
        'perusahaan_id', 'customer_id',
        'no_pks_p1', 'no_pks_p2',
        'amendemen_id', 'no_amendemen',
        'uraian_pekerjaan', 'kategori_pekerjaan_id',
        'jenis_pekerjaan_id', 'sub_jenis_pekerjaan_id',
        'tanggal_awal', 'tanggal_akhir',
        'status_id', 'sub_kontrak',
        'no_io', 'nilai_bulan_ppn', 'nilai_total_ppn', 'jumlah_tad', 'keterangan',
        'import_tanggal', 'import_oleh'
    ];

    public function getKontrakTemp($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function insertBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }
}
