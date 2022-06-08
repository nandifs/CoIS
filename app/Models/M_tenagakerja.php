<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tenagakerja extends Model
{
    protected $table      = 'mkp__tenagakerja';
    protected $returnType     = 'array';
    protected $allowedFields = ['nip', 'nama', 'jabatan_id', 'unitkerja_id', 'penempatan_id', 'wilayah_id', 'email', 'foto', 'otoritas_id', 'kata_kunci', 'status_id', 'apps_id'];
    protected $useTimestamps = true;

    public function getTenagakerja($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getTenagakerjaDetail($id = null, $unit_id = null)
    {
        $this->setTable("mkp__tenagakerja a")
            ->select('a.*, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->orderBy('c.singkatan, d.singkatan, b.tingkat', 'asc');

        if (!is_null($unit_id)) {
            $this->where("a.unitkerja_id", $unit_id);
        }

        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->where("a.id=$id")->first();
        }
    }

    public function getTenagakerjaDetailByNip($nip = null)
    {
        $this->setTable("mkp__tenagakerja a")
            ->select('a.*, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left');

        if (is_null($nip)) {
            return $this->findAll();
        } else {
            return $this->where("a.nip=", $nip)->first();
        }
    }

    public function getAllTenagakerjaBy($key_field, $key_id)
    {
        $this->setTable('mkp__tenagakerja a')
            ->select('a.*, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left');

        if (is_array($key_id)) {
            return $this->whereIn("a.$key_field", $key_id)->findAll();
        } else {
            return $this->where("a.$key_field=$key_id")->findAll();
        }
    }

    public function getTenagakerjaForComboBy($penempatan_id = null, $key_field = null, $key_id = null)
    {
        $this->setTable('mkp__tenagakerja a')
            ->select('a.id, a.nip, a.nama, a.jabatan_id, a.unitkerja_id, a.penempatan_id, a.status_id, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->orderBy('b.singkatan', 'asc')
            ->orderBy('a.nama', 'asc');

        if (!is_null($penempatan_id)) {
            $this->where("a.penempatan_id", $penempatan_id);
        }

        if (is_array($key_id)) {
            return $this->whereIn("a.$key_field", $key_id)->findAll();
        } else {
            return $this->where("a.$key_field=$key_id")->findAll();
        }
    }

    public function getTenagakerjaAjax($key_id)
    {
        $this->setTable('mkp__tenagakerja a')
            ->select('a.id, a.nip, a.nama, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left');

        return $this->where("a.id=$key_id")->first();
    }

    public function insertBatchDataFromXls($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }
}
