<?php

namespace App\Database;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHelperAmkp
{
    protected $db;
    protected $otherdb;
    protected $dbName;
    protected $otherDbName;
    protected $table;
    protected $builder;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->dbName = $this->db->database;
    }

    //------------------------------------------------------------------
    // KEGIATAN
    //------------------------------------------------------------------

    public function getRekapKegiatanUnitkerja($unitkerja, $periode)
    {
        $periodeData = explode("-", $periode);

        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mip__kegiatan a');
        $builder->select('c.kode,a.petugas_id, DATE(a.tanggal) as tgl_kegiatan, count(a.tanggal) as jml_kegiatan, b.nama as petugas, c.singkatan as unitkerja')
            ->join($this->dbName . '.mkp__pegawai b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName . '.org__unitkerja c', 'b.unitkerja_id=c.id', 'left')
            ->where('MONTH(a.tanggal)', $periodeData[1])
            ->where('YEAR(a.tanggal)', $periodeData[0])
            ->groupBy(["c.kode", "b.unitkerja_id", "a.petugas_id", "DATE(a.tanggal)"])
            ->orderBy("c.kode", "asc");

        if ($unitkerja['kelas_id'] == 1) {
            $kode_induk = substr($unitkerja['kode'], 0, 3);
            $builder->where('LEFT(c.kode,3)', $kode_induk);
        } else if ($unitkerja['kelas_id'] == 2) {
            $kode_induk = substr($unitkerja['kode'], 0, 6);
            $builder->where('LEFT(c.kode,6)', $kode_induk);
        } else {
            $builder->where('a.unitkerja_id', $unitkerja['id']);
        }

        return $builder->get();
    }

    public function getRekapTglKegiatanUnitkerja($unitkerja, $periode)
    {
        $periodeData = explode("-", $periode);

        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mip__kegiatan a');
        $builder->select('c.kode, DATE(a.tanggal) as tgl_kegiatan, c.singkatan as unitkerja')
            ->join($this->dbName . '.mkp__pegawai b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName . '.org__unitkerja c', 'b.unitkerja_id=c.id', 'left')
            ->where('MONTH(a.tanggal)', $periodeData[1])
            ->where('YEAR(a.tanggal)', $periodeData[0])
            ->groupBy(["c.kode", "b.unitkerja_id", "DATE(a.tanggal)"])
            ->orderBy("c.kode", "asc");

        if ($unitkerja['kelas_id'] == 1) {
            $kode_induk = substr($unitkerja['kode'], 0, 3);
            $builder->where('LEFT(c.kode,3)', $kode_induk);
        } else if ($unitkerja['kelas_id'] == 2) {
            $kode_induk = substr($unitkerja['kode'], 0, 6);
            $builder->where('LEFT(c.kode,6)', $kode_induk);
        } else {
            $builder->where('a.unitkerja_id', $unitkerja['id']);
        }

        return $builder->get();
    }

    public function getKegiatanPetugasPerTanggal($petugas_id, $tanggal)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mip__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as unitkerja')
            ->join($this->dbName  .  '.mkp__pegawai b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__unitkerja c', 'b.unitkerja_id=c.id', 'left')
            ->where("a.petugas_id", $petugas_id)
            ->where("DATE(a.tanggal)", $tanggal)
            ->orderBy('a.tanggal', 'asc');

        return $builder->get()->getResultArray();
    }

    public function getKegiatanPetugasPerTanggalPerUnitkerja($unitkerja_id, $tanggal)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mip__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as unitkerja')
            ->join($this->dbName  .  '.mkp__pegawai b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__unitkerja c', 'b.unitkerja_id=c.id', 'left')
            ->where("b.unitkerja_id", $unitkerja_id)
            ->where("DATE(a.tanggal)", $tanggal)
            ->orderBy('b.nama ASC, a.tanggal ASC');

        return $builder->get()->getResultArray();
    }

    public function getKegiatanPetugas($petugas_id = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mip__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as unitkerja')
            ->join($this->dbName  .  '.mkp__pegawai b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__unitkerja c', 'b.unitkerja_id=c.id', 'left')
            ->orderBy('a.tanggal', 'asc');

        if (is_null($petugas_id)) {
            return $builder->get()->getResultArray();
        } else {
            return $builder->where("a.petugas_id", $petugas_id)->get()->getResultArray();
        }
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

        $this->otherDbName = $this->otherdb->database;

        $this->builder = $this->otherdb->table($table);

        return $this->builder;
    }
}
