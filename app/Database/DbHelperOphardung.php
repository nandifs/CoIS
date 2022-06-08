<?php

namespace App\Database;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHelperOphardung
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

    public function getRekapKegiatanMitrakerja($mitrakerja, $periode)
    {
        $periodeData = explode("-", $periode);

        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mophar__kegiatan a');
        $builder->select('c.kode,a.petugas_id, a.mitrakerja_id, DATE(a.tanggal) as tgl_kegiatan, count(a.tanggal) as jml_kegiatan, b.nama as petugas, c.singkatan as mitrakerja')
            ->join($this->dbName . '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName . '.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->where('MONTH(a.tanggal)', $periodeData[1])
            ->where('YEAR(a.tanggal)', $periodeData[0])
            ->groupBy(["c.kode", "a.mitrakerja_id", "a.petugas_id", "DATE(a.tanggal)"])
            ->orderBy("c.kode", "asc");

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            //dd($kode_induk);
            $builder->where('LEFT(c.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(c.kode,6)', $kode_induk);
        } else {
            $builder->where('a.mitrakerja_id', $mitrakerja['id']);
        }

        return $builder->get();
    }

    public function getRekapTglKegiatanMitrakerja($mitrakerja, $periode)
    {
        $periodeData = explode("-", $periode);

        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mophar__kegiatan a');
        $builder->select('DATE(a.tanggal) as tgl_kegiatan')
            ->join($this->dbName . '.org__mitrakerja b', 'a.mitrakerja_id=b.id', 'left')
            ->where('MONTH(a.tanggal)', $periodeData[1])
            ->where('YEAR(a.tanggal)', $periodeData[0])
            ->groupBy("DATE(a.tanggal)");

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            $builder->where('LEFT(b.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(b.kode,6)', $kode_induk);
        } else {
            $builder->where('a.mitrakerja_id', $mitrakerja['id']);
        }

        return $builder->get();
    }

    public function getKegiatanPetugasPerTanggal($petugas_id, $tanggal)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mophar__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as mitrakerja')
            ->join($this->dbName  .  '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->where("a.petugas_id", $petugas_id)
            ->where("DATE(a.tanggal)", $tanggal)
            ->orderBy('a.tanggal', 'asc');

        return $builder->get()->getResultArray();
    }

    public function getKegiatanPetugasPerTanggalPerMitrakerja($mitrakerja, $tanggal)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mophar__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as mitrakerja')
            ->join($this->dbName  .  '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->where("DATE(a.tanggal)", $tanggal)
            ->orderBy('b.nama ASC, a.tanggal ASC');

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            //dd($kode_induk);
            $builder->where('LEFT(c.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(c.kode,6)', $kode_induk);
        } else {
            $builder->where('a.mitrakerja_id', $mitrakerja['id']);
        }

        return $builder->get()->getResultArray();
    }

    public function getKegiatanPetugas($petugas_id = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mophar__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as mitrakerja')
            ->join($this->dbName  .  '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->orderBy('a.tanggal', 'asc');

        if (is_null($petugas_id)) {
            return $builder->get()->getResultArray();
        } else {
            return $builder->where("a.petugas_id", $petugas_id)->get()->getFirstRow();
        }
    }

    //------------------------------------------------------------------
    // INVENTORI
    //------------------------------------------------------------------

    public function getRekapInventoriByMitrakerja($mitrakerja_id = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mophar__inventori a');
        $builder->select('a.mitrakerja_id, count(a.produk_id) as jml_item, b.singkatan as mitrakerja')
            ->join($this->dbName  .  '.org__mitrakerja b', 'a.mitrakerja_id=b.id', 'left')
            ->where('a.mitrakerja_id', $mitrakerja_id)
            ->groupBy(["a.mitrakerja_id"]);

        return $builder->get()->getResultArray();
    }

    public function getInventoriByMitrakerja($mitrakerja)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mophar__inventori a');

        $builder->select('a.*, b.nama as petugas, c.singkatan as mitrakerja, d.produk')
            ->join($this->dbName . '.mkp__tenagakerja b', 'a.updated_by=b.id', 'left')
            ->join($this->dbName . '.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->join($this->otherDbName . '.mophar__alat_material d', 'a.produk_id=d.id', 'left')
            ->orderBy('a.mitrakerja_id ASC, d.produk ASC');

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            //dd($kode_induk);
            $builder->where('LEFT(c.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(c.kode,6)', $kode_induk);
        } else {
            $builder->where('a.mitrakerja_id', $mitrakerja['id']);
        }

        return $builder->get()->getResultArray();
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
