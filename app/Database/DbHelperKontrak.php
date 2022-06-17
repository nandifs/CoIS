<?php

namespace App\Database;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHelperKontrak
{
    protected $db;
    protected $otherdb;
    protected $table;
    protected $builder;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->dbName = $this->db->database;
    }

    /**--------------------------------------------------------------------
     * HELPER FOR KONTRAK PKS
     * --------------------------------------------------------------------
     */
    public function getKontrak($id = null, $filter = null)
    {
        $builder = $this->builder('pks__kontrak a');
        $builder->select('a.*, b.unitkerja, c.mitrakerja, d.nama as kategori, e.jenis as jenis_pekerjaan, f.sub_jenis as sub_jenis_pekerjaan, g.status as status_kontrak, h.kontrak_id as rab_normatif, i.kontrak_id as rab_material, (select count(*) from pks__amendemen j where a.id=j.kontrak_id) as jml_amendemen')
            ->join('org__unitkerja b', 'a.perusahaan_id=b.id', 'left')
            ->join('org__mitrakerja c', 'a.customer_id=c.id', 'left')
            ->join('pks__mst_pekerjaan_kategori d', 'a.kategori_pekerjaan_id=d.id', 'left')
            ->join('pks__mst_pekerjaan_jenis e', 'a.jenis_pekerjaan_id=e.id', 'left')
            ->join('pks__mst_pekerjaan_jenis_sub f', 'a.sub_jenis_pekerjaan_id=f.id', 'left')
            ->join('pks__mst_kontrak_status g', 'a.status_id=g.id', 'left')
            ->join('pks__kontrak_rab_normatif h', 'a.id=h.kontrak_id', 'left')
            ->join('pks__kontrak_rab_material i', 'a.id=i.kontrak_id', 'left')
            ->orderBy('a.status_id ASC, c.singkatan ASC');

        if (!is_null($filter)) {
            $builder->where($filter);
        } else {
            if (!is_null($id) && $id != 0) {
                $builder->where('a.id', $id);
                return $builder->get()->getFirstRow();
            }
        }
        return $builder->get()->getResultArray();
    }

    public function getKontrakTemporary($id = null, $filter = null)
    {
        $builder = $this->builder('pks__kontrak_temp a');
        $builder->select('a.*, b.unitkerja, c.mitrakerja, d.nama as kategori, e.jenis as jenis_pekerjaan, f.sub_jenis as sub_jenis_pekerjaan, g.status as status_kontrak, h.kontrak_id as rab_normatif, i.kontrak_id as rab_material')
            ->join('org__unitkerja b', 'a.perusahaan_id=b.id', 'left')
            ->join('org__mitrakerja c', 'a.customer_id=c.id', 'left')
            ->join('pks__mst_pekerjaan_kategori d', 'a.kategori_pekerjaan_id=d.id', 'left')
            ->join('pks__mst_pekerjaan_jenis e', 'a.jenis_pekerjaan_id=e.id', 'left')
            ->join('pks__mst_pekerjaan_jenis_sub f', 'a.sub_jenis_pekerjaan_id=f.id', 'left')
            ->join('pks__mst_kontrak_status g', 'a.status_id=g.id', 'left')
            ->join('pks__kontrak_rab_normatif h', 'a.id=h.kontrak_id', 'left')
            ->join('pks__kontrak_rab_material i', 'a.id=i.kontrak_id', 'left')
            ->orderBy('a.status_id ASC, c.singkatan ASC, a.no_pks_p1 ASC, a.no_amendemen ASC');

        if (!is_null($filter)) {
            $builder->where($filter);
        } else {
            if (!is_null($id) && $id != 0) {
                $builder->where('a.id', $id);
                return $builder->get()->getFirstRow();
            }
        }
        return $builder->get()->getResultArray();
    }

    public function getKontrakIdByNoP1($key)
    {
        $builder = $this->builder('pks__kontrak');
        return $builder->select('id')->getWhere(['no_pks_p1' => $key])->getFirstRow();
    }

    public function getAmendemenIdByNoAMD($key)
    {
        $builder = $this->builder('pks__amendemen');
        return $builder->select('id, kontrak_id')->getWhere(['no_amendemen' => $key])->getFirstRow();
    }

    public function getStatusKontrakIdByNama($key)
    {
        $builder = $this->builder('pks__mst_kontrak_status');
        return $builder->select('id')->getWhere(["status" => $key])->getFirstRow();
    }

    public function getUnitkerjaIdByNama($key)
    {
        $builder = $this->builder('org__unitkerja');
        return $builder->select('id')->getWhere(['unitkerja' => $key])->getFirstRow();
    }

    public function getUnitkerjaIdByNamaSingkat($key)
    {
        $builder = $this->builder('org__unitkerja');
        return $builder->select('id')->getWhere(['singkatan' => $key])->getFirstRow();
    }

    public function getCustomerIdByNama($key)
    {
        $builder = $this->builder('org__mitrakerja');
        return $builder->select('id')->getWhere(['mitrakerja' => $key])->getFirstRow();
    }

    public function getCustomerIdByNamaSingkat($key)
    {
        $builder = $this->builder('org__mitrakerja');
        return $builder->select('id')->getWhere(['singkatan' => $key])->getFirstRow();
    }

    public function getJenisPekerjaanIdByNama($key)
    {
        $builder = $this->builder('pks__mst_pekerjaan_jenis');
        return $builder->select('id, kategori_id')->getWhere(['jenis' => $key])->getFirstRow();
    }

    public function getSubJenisPekerjaanByNama($key)
    {
        $builder = $this->builder('pks__mst_pekerjaan_jenis_sub');
        return $builder->select('id')->getWhere(['sub_jenis' => $key])->getFirstRow();
    }

    //------------------------------------------------------------------
    // BUILDER
    //------------------------------------------------------------------
    protected function builder(string $table = null)
    {
        $table = empty($table) ? $this->table : $table;

        // Ensure we have a good db connection
        if (!$this->db instanceof BaseConnection) {
            $this->db = Database::connect();
        }

        $this->builder = $this->db->table($table);

        return $this->builder;
    }

    protected function builderFromOtherDb(string $groupDb = null, string $table = null)
    {
        $table = empty($table) ? $this->table : $table;

        // Ensure we have a good db connection
        if (!$this->otherdb instanceof BaseConnection) {
            $this->otherdb = Database::connect($groupDb);
        }

        $this->builder = $this->otherdb->table($table);

        return $this->builder;
    }
}
