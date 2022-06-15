<?php

namespace App\Models\KONTRAK;

use CodeIgniter\Model;

class M_kontrak extends Model
{
    protected $table      = 'pks__kontrak';
    protected $returnType     = 'array';
    protected $allowedFields = [
        'perusahaan_id', 'customer_id',
        'no_pks_p1', 'no_pks_p2',
        'uraian_pekerjaan', 'kategori_pekerjaan_id',
        'jenis_pekerjaan_id', 'sub_jenis_pekerjaan_id',
        'tanggal_awal', 'tanggal_akhir',
        'status_id', 'sub_kontrak',
        'no_io', 'nilai_bulan_ppn', 'nilai_total_ppn', 'jumlah_tad', 'keterangan',
        'update_oleh'
    ];
    protected $useTimestamps = true;

    public function getKontrak($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getCountKontrakAktif()
    {
        $this->where('status_id', 1);
        return $this->countAllResults();
    }

    //Import Kontrak From Xls
    public function insertBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }

    public function updateBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->updateBatch($data, 'id');
    }
}
