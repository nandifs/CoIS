<?php

namespace App\Database;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHelperSatpam
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

    /**
     * --------------------------------------------------------------------
     * HELPER FOR TITIK INPEKSI
     * --------------------------------------------------------------------
     */
    public function getGrupTitikInspeksiByMitraKerja($mitrakerjaid)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__titik_kontrol');
        $builder->select('grup')
            ->groupBy('grup, mitrakerja_id');
        if (!is_null($mitrakerjaid) && $mitrakerjaid != 0) {
            $this->builder->where('mitrakerja_id', $mitrakerjaid);
        }
        //nilai return harus object jangan dirubah ke Array karena digunan untuk ajax
        return $this->builder->get();
    }

    public function getTitikInspeksiByMitraKerja($mitrakerjaid, $gruplokasi = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__titik_kontrol a');
        $builder->select('a.id, a.grup, a.lokasi, a.mitrakerja_id, b.mitrakerja, b.singkatan')
            ->join($this->dbName . '.org__mitrakerja b', 'a.mitrakerja_id=b.id', 'left');
        if (!is_null($mitrakerjaid) && $mitrakerjaid != 0) {
            $this->builder->where('a.mitrakerja_id', $mitrakerjaid);
        }
        if (!is_null($gruplokasi) || $gruplokasi != "") {
            $this->builder->where('a.grup', $gruplokasi);
        }
        //nilai return harus object jangan dirubah ke Array karena digunan untuk ajax
        return $this->builder->get();
    }

    /**--------------------------------------------------------------------
     * HELPER FOR ANGGOTA REGU
     * --------------------------------------------------------------------
     */

    public function getReguByPenempatan($penempatan_id = null, $id = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__regu_anggota a');

        $builder->select('b.id, b.regu, d.singkatan as penempatan')
            ->join('mis__regu b', 'a.regu_id=b.id', 'left')
            ->join($this->dbName . '.mkp__tenagakerja c', 'a.petugas_id=c.id', 'left')
            ->join($this->dbName . '.org__mitrakerja d', 'c.penempatan_id=d.id', 'left')
            ->groupBy('a.regu_id, b.regu, d.singkatan')
            ->orderBy('a.regu_id');

        if (!is_null($penempatan_id)) {
            $builder->where("c.penempatan_id=", $penempatan_id);
        }

        if (is_null($id)) {
            return $builder->get()->getResultArray();
        } else {
            return $builder->where("a.id=$id")->get()->getFirstRow();
        }
    }

    public function getAnggotaReguDetail($penempatan_id = null, $id = null)
    {
        //dd($penempatan_id);
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__regu_anggota a');

        $builder->select('a.id, a.regu_id, a. petugas_id, b.regu, c.nama as petugas, d.singkatan as jabatan, e.singkatan as unitkerja, f.singkatan as penempatan')
            ->join('mis__regu b', 'a.regu_id=b.id', 'left')
            ->join($this->dbName . '.mkp__tenagakerja c', 'a.petugas_id=c.id', 'left')
            ->join($this->dbName . '.mkp__jabatan d', 'c.jabatan_id=d.id', 'left')
            ->join($this->dbName . '.org__unitkerja e', 'c.unitkerja_id=e.id', 'left')
            ->join($this->dbName . '.org__mitrakerja f', 'c.penempatan_id=f.id', 'left')
            ->orderBy('a.regu_id', 'asc')
            ->orderBy('d.singkatan', 'asc')
            ->orderBy('c.nama', 'asc');

        if (!is_null($penempatan_id)) {
            $builder->where("c.penempatan_id=", $penempatan_id);
        }

        if (is_null($id)) {
            return $builder->get()->getResultArray();
        } else {
            return $builder->where("a.id=$id")->get()->getFirstRow();
        }
    }

    /**--------------------------------------------------------------------
     * HELPER FOR BUKU MUTASI
     * --------------------------------------------------------------------
     */
    public function getBukuMutasi($id = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__buku_mutasi a');

        $builder->select('a.*, b.singkatan as mitrakerja')
            ->join($this->dbName . '.org__mitrakerja b', 'a.mitrakerja_id=b.id', 'left');

        if (!is_null($id)) {
            $builder->where("a.id", $id);
            return $builder->get()->getRowArray();
        } else {
            return $builder->get()->getResultArray();
        }
    }

    public function getBukuMutasiByMitraKerja($mitrakerja, $periode, $sort_by = null)
    {
        $periodeData = explode("-", $periode);

        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__buku_mutasi a');
        $builder->select('a.id, a.tanggal, a.shift, a.jam_dinas, a.petugas, a.status, b.singkatan as mitrakerja')
            ->join($this->dbName . '.org__mitrakerja b', 'a.mitrakerja_id=b.id', 'left')
            ->where('MONTH(a.tanggal)', $periodeData[1])
            ->where('YEAR(a.tanggal)', $periodeData[0])
            ->orderBy('a.mitrakerja_id', 'ASC');

        if (is_null($sort_by)) {
            $builder->orderBy('a.created_at', 'desc');
        } else {
            $builder->orderBy('a.created_at', $sort_by);
        }

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

    public function getPetugasBukuMutasi($id, $id_petugas = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__buku_mutasi_petugas a');

        $builder->select('b.id, b.nama, c.singkatan as jabatan, a.keterangan')
            ->join($this->dbName . '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName . '.mkp__jabatan c', 'b.jabatan_id=c.id', 'left')
            ->where("a.buku_mutasi_id", $id);

        if (!is_null($id_petugas)) {
            $builder->where("b.id", $id_petugas);
        }

        return $builder->get()->getResultArray();
    }

    public function getInventarisBukuMutasi($id)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__buku_mutasi_inventaris');

        $builder->select('*')
            ->where("buku_mutasi_id", $id);

        return $builder->get()->getResultArray();
    }

    public function getDataMutasiPetugasByMutasiId($buku_mutasi_id)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__buku_mutasi_petugas a');
        $builder->select('a.*, b.nama as petugas')
            ->join($this->dbName . '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->where('a.buku_mutasi_id', $buku_mutasi_id);

        return $builder->get()->getResultArray();
    }

    /**--------------------------------------------------------------------
     * HELPER FOR BUKU MUTASI
     * --------------------------------------------------------------------
     */
    public function getKegiatan($id = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as mitrakerja')
            ->join($this->dbName  .  '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->orderBy('a.tanggal', 'asc');

        if (is_null($id)) {
            return $builder->get()->getResultArray();
        } else {
            return $builder->where("a.id", $id)->get()->getFirstRow();
        }
    }

    public function getKegiatanByJenis($jenis, $mitrakerja_id = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as mitrakerja')
            ->join($this->dbName  .  '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->orderBy('a.tanggal', 'asc');

        if (!is_null($mitrakerja_id)) {
            $builder->where('a.mitrakerja_id', $mitrakerja_id);
        }

        return $builder->where("a.jenis", $jenis)->get()->getResultArray();
    }

    public function getKegiatanBukuMutasi($buku_mutasi_id = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__kegiatan a');
        $builder->select('a.*, b.nama as petugas, c.singkatan as mitrakerja')
            ->join($this->dbName  .  '.mkp__tenagakerja b', 'a.petugas_id=b.id', 'left')
            ->join($this->dbName  .  '.org__mitrakerja c', 'a.mitrakerja_id=c.id', 'left')
            ->orderBy('a.tanggal', 'asc');

        if (!is_null($buku_mutasi_id)) {

            $builder->where('a.buku_mutasi_id', $buku_mutasi_id);
        }

        return $builder->get()->getResultArray();
    }

    /**--------------------------------------------------------------------
     * HELPER FOR BUKU TAMU
     * --------------------------------------------------------------------
     */
    public function getTamuDetail($uid = null, $mitrakerjaid = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__buku_tamu a');
        $builder->select('a.*')
            ->join($this->dbName . '.org__mitrakerja b', 'a.mitrakerja_id=b.id', 'left');

        if (is_null($mitrakerjaid)) {
            $builder->where('a.mitrakerja_id', $mitrakerjaid);
        }

        if (is_null($uid)) {
            return $builder->get()->getResultArray();
        } else {
            return $builder->where('a.uid', $uid)->get()->getFirstRow();
        }
    }

    public function getTamuPerUnit($periode = null, $mitrakerjaid = null)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__buku_tamu a');
        $builder->select('a.*')
            ->join($this->dbName . '.org__mitrakerja b', 'a.mitrakerja_id=b.id', 'left');

        if (!is_null($periode)) {
            $tglHariIni = date("Y-m-d");
            if (strtoupper($periode) == "HARI INI") {
                $builder->where('a.tanggal', $tglHariIni);
            } else if (strtoupper($periode) == "BULAN INI") {
                //Bulan Ini
                $periodeData = explode("-", $tglHariIni);
                $builder->where('MONTH(a.tanggal)', $periodeData[1])
                    ->where('YEAR(a.tanggal)', $periodeData[0]);
            } else if (strtoupper($periode) == "BULAN LALU") {
                //Bulan Sebelumnya 
                $monthBefore = ambil_bulan_sebelumnya();
                $periodeData = explode("-", $monthBefore);
                $builder->where('MONTH(a.tanggal)', $periodeData[1])
                    ->where('YEAR(a.tanggal)', $periodeData[0]);
            } else {
                //Nanti isi untuk menampilkan sesuai tanggal yang dipilih user
                //$builder->where('a.tanggal', $tglHariIni);
            }
        }

        if (!is_null($mitrakerjaid)) {
            $builder->where('a.mitrakerja_id', $mitrakerjaid);
        }

        $builder->orderBy('a.tanggal', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * Hitung status tamu
     * 
     * param idmitrakerja, status kunjungan, dan tanggal/periode berkunjug
     * @param string $mitrakerjaid
     * @param string $status
     * @param string $tglberkunjung
     *
     * @return allresult
     */
    public function countStatusTamu($mitrakerjaid = null, $status = null, $tglberkunjung = null)
    {

        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__buku_tamu a');

        $builder->where('a.status', $status);
        if (!is_null($tglberkunjung)) {
            $tglHariIni = date('Y-m-d');
            if (strtoupper($tglberkunjung) == "HARI INI") {
                $builder->where('a.tanggal', $tglHariIni);
            } else if (strtoupper($tglberkunjung) == "BULAN INI") {
                $periodeData = explode("-", $tglHariIni);
                $builder->where('MONTH(a.tanggal)', $periodeData[1])
                    ->where('YEAR(a.tanggal)', $periodeData[0]);
            } else {
                $builder->where('a.tanggal', $tglHariIni);
            }
        }

        if (!is_null($mitrakerjaid) && $mitrakerjaid != 0) {
            $builder->where('a.mitrakerja_id', $mitrakerjaid);
        }
        return $builder->countAllResults();
    }

    /**--------------------------------------------------------------------
     * HELPER FOR BUKU KENDARAAN / KELUAR MASUK KENDARAAN
     * --------------------------------------------------------------------
     */

    public function getKendaraan($periode, $mitrakerja_id = null)
    {
        $tglmasuk = explode("-", $periode);

        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__kendaraan a');
        $builder->select('a.*, b.nama as petugas_masuk, c.nama as petugas_keluar, d.singkatan as mitrakerja')
            ->join($this->dbName  .  '.mkp__tenagakerja b', 'a.petugas_id_masuk=b.id', 'left')
            ->join($this->dbName  .  '.mkp__tenagakerja c', 'a.petugas_id_keluar=c.id', 'left')
            ->join($this->dbName  .  '.org__mitrakerja d', 'a.mitrakerja_id=d.id', 'left')
            ->where('MONTH(a.jam_masuk)', $tglmasuk[1])
            ->where('YEAR(a.jam_masuk)', $tglmasuk[0])
            ->orderBy('a.jam_masuk', 'asc');

        if (!is_null($mitrakerja_id)) {
            $builder->where('a.mitrakerja_id', $mitrakerja_id);
        }

        return $builder->get()->getResultArray();
    }

    public function getKendaraanByNopol($nopol)
    {
        $builder = $this->builderFromOtherDb('pekerjaanDb', 'mis__kendaraan a');
        $builder->select('a.*, b.nama as petugas_masuk, c.nama as petugas_keluar, d.singkatan as mitrakerja')
            ->join($this->dbName  .  '.mkp__tenagakerja b', 'a.petugas_id_masuk=b.id', 'left')
            ->join($this->dbName  .  '.mkp__tenagakerja c', 'a.petugas_id_keluar=c.id', 'left')
            ->join($this->dbName  .  '.org__mitrakerja d', 'a.mitrakerja_id=d.id', 'left')
            ->orderBy('a.jam_masuk', 'asc');

        return $builder->where("a.no_polisi", $nopol)->get()->getFirstRow();
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
