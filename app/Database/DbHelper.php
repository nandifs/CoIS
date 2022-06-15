<?php

namespace App\Database;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHelper
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
     * HELPER FOR DATA MASTER
     * --------------------------------------------------------------------
     */

    public function getUpahRegional($filter = null)
    {
        $builder = $this->builder('oth__upah_regional a');
        $builder->select('a.*, b.wilayah')
            ->join('org__wilayahkerja b', 'a.wilayah_id=b.id', 'left')
            ->orderBy('a.id', 'asc');

        if (!is_null($filter)) {
            $builder->where($filter);
        }

        return $builder->get()->getResultArray();
    }


    /**--------------------------------------------------------------------
     * HELPER FOR WILAYAH KERJA
     * --------------------------------------------------------------------
     */
    public function getWilayahKerja($wilayahid = null, $filter = null)
    {
        $builder = $this->builder('org__wilayahkerja a');
        $builder->select('a.id, a.kode, a.wilayah, a.singkatan, a.induk_id, b.wilayah as wilayah_induk, a.kelas')
            ->join('org__wilayahkerja b', 'a.induk_id=b.id', 'left')
            ->orderBy('a.kode', 'asc');

        if (!is_null($filter)) {
            $builder->where($filter);
        } else {
            if (!is_null($wilayahid) && $wilayahid != 0) {
                $builder->where('a.id', $wilayahid);
                $builder->orWhere('a.induk_id', $wilayahid);
            }
        }

        return $builder->get()->getResultArray();
    }

    public function getWilayahKerjaDetail($id = null)
    {
        $builder = $this->builder('org__wilayahkerja a');
        return $builder->select('a.*, b.wilayah as namainduk, b.singkatan as namainduksingkat')
            ->join('org__wilayahkerja b', 'a.induk_id=b.id', 'left')
            ->orderBy("a.induk_id, a.id", "asc");

        if (is_null($id)) {
            return $builder->getWhere(['a.id' => $id])->getRow();
        } else {
            return $builder->get()->getFirstRow();
        }
    }

    public function getLastKodeWilayahKerja($induk_id, $kelas)
    {
        $builder = $this->builder('org__wilayahkerja');
        $gKode = 'MID(kode,' . ((($kelas - 1) * 3) + (($kelas == 1) ? 0 : 1)) . ',3)';

        $builder->select('MAX(CAST(' . $gKode . ' AS UNSIGNED)) AS max_kode')
            ->where('kelas', $kelas)
            ->where('induk_id', $induk_id)
            ->orderBy('kode', 'asc');
        return $builder->get()->getRow();
    }

    public function getWilayahKerjaIdBySingkatan($singkatan)
    {
        $builder = $this->builder('org__wilayahkerja');
        $builder->select('id')
            ->where('singkatan', $singkatan);

        return $builder->get()->getResult();
    }

    /**--------------------------------------------------------------------
     * HELPER FOR UNIT KERJA
     * --------------------------------------------------------------------
     */
    public function getUnitKerja($unitkerjaid = null)
    {
        $builder = $this->builder('org__unitkerja a');
        $builder->select('a.id, a.kode, a.unitkerja, a.singkatan, a.kelas_id, a.induk_id, b.singkatan as unit_induk')
            ->join('org__unitkerja b', 'a.induk_id=b.id', 'left')
            ->orderBy('a.kode', 'asc');

        if (!is_null($unitkerjaid)) {
            if ($unitkerjaid != 9999) {
                $builder->where('a.id', $unitkerjaid);
                $builder->orWhere('a.induk_id', $unitkerjaid);
            }
        }

        return $builder->get()->getResultArray();
    }

    public function getLastKodeUnitkerja($induk_id, $kelas)
    {
        $builder = $this->builder('org__unitkerja');
        if ($kelas == 1) {
            $gKode = 'MID(kode, 1, 3)';
            $builder->select('MAX(CAST(' . $gKode . ' AS UNSIGNED)) AS max_kode');
        } else {
            $gKode = 'MID(kode,' . ((($kelas - 1) * 3) + (($kelas == 1) ? 0 : 1)) . ',3)';

            $builder->select('MAX(CAST(' . $gKode . ' AS UNSIGNED)) AS max_kode')
                ->where('kelas_id', $kelas)
                ->where('induk_id', $induk_id)
                ->orderBy('kode', 'asc');
        }

        return $builder->get()->getRow();
    }

    public function getDivisi($divisi_id = null)
    {
        $builder = $this->builder('org__divisi a');
        $builder->select('a.id, a.divisi, a.singkatan, a.kelas, a.induk_id, b.singkatan as unit_induk')
            ->join('org__divisi b', 'a.induk_id=b.id', 'left')
            ->orderBy('a.induk_id, a.kode', 'asc');

        if (!is_null($divisi_id)) {
            $builder->where('a.id', $divisi_id);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * --------------------------------------------------------------------
     * HELPER FOR MITRA KERJA
     * --------------------------------------------------------------------
     **/
    public function getMitraKerja($mitrakerjaid = null, $filter = null)
    {
        $builder = $this->builder('org__mitrakerja a');
        $builder->select('a.id, a.kode, a.mitrakerja, a.singkatan, a.induk_id, b.singkatan as mitra_induk, a.kelas, a.unitkerja_id, c.singkatan as unitkerja, LEFT(a.kode,3) as kode_induk, LEFT(a.kode,6) as kode_sub_induk')
            ->join('org__mitrakerja b', 'a.induk_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->orderBy('a.kode', 'asc');

        if (!is_null($filter)) {
            $builder->where($filter);
        } else {
            if (!is_null($mitrakerjaid) && $mitrakerjaid != 9999) {
                $builder->where('a.id', $mitrakerjaid);
                $builder->orWhere('a.induk_id', $mitrakerjaid);
            }
        }

        return $builder->get()->getResultArray();
    }

    public function getMitraKerjaForCombo($mitrakerja)
    {
        $builder = $this->builder('org__mitrakerja a');
        $builder->select('a.id, a.kode, a.mitrakerja, a.singkatan, a.induk_id, b.singkatan as mitra_induk, a.kelas, a.unitkerja_id, c.singkatan as unitkerja, LEFT(a.kode,3) as kode_induk, LEFT(a.kode,6) as kode_sub_induk')
            ->join('org__mitrakerja b', 'a.induk_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->orderBy('a.kode', 'asc');

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            $builder->where('LEFT(b.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(b.kode,6)', $kode_induk);
        } else {
            $builder->where('a.kode', $mitrakerja['kode']);
        }

        return $builder->get()->getResultArray();
    }

    public function getMitraKerjaDetail($id = null)
    {
        $builder = $this->builder('org__mitrakerja a');
        return $builder->select('a.*, b.mitrakerja as namainduk, b.singkatan as namainduksingkat')
            ->join('org__mitrakerja b', 'a.induk_id=b.id', 'left')
            ->orderBy("a.induk_id, a.id", "asc");

        if (is_null($id)) {
            return $builder->getWhere(['a.id' => $id])->getRow();
        } else {
            return $builder->get()->getFirstRow();
        }
    }

    public function getLastKodeMitra($induk_id, $kelas)
    {
        $builder = $this->builder('org__mitrakerja');
        if ($kelas == 1) {
            $gKode = 'MID(kode, 1, 3)';
            $builder->select('MAX(CAST(' . $gKode . ' AS UNSIGNED)) AS max_kode');
        } else {
            $gKode = 'MID(kode,' . ((($kelas - 1) * 3) + (($kelas == 1) ? 0 : 1)) . ',3)';

            $builder->select('MAX(CAST(' . $gKode . ' AS UNSIGNED)) AS max_kode')
                ->where('kelas', $kelas)
                ->where('induk_id', $induk_id)
                ->orderBy('kode', 'asc');
        }

        return $builder->get()->getRow();
    }

    /**--------------------------------------------------------------------
     * HELPER FOR DATA PEGAWAI
     * --------------------------------------------------------------------
     */
    public function getPegawaiByUnitkerja($unitkerja_id = null)
    {
        $builder = $this->builder('mkp__pegawai a');
        $builder->select('a.*, b.singkatan as jabatan, c.singkatan as unitkerja, d.divisi')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__divisi d', 'a.penempatan_id=d.id', 'left')
            ->orderBy('c.singkatan, b.tingkat', 'asc');

        if (!is_null($unitkerja_id) && $unitkerja_id != 0) {
            $builder->where("a.unitkerja_id", $unitkerja_id);
        }

        return $builder->get()->getResultArray();
    }

    public function getJmlPegawaiByUnitkerja($unitkerja_id)
    {
        $builder = $this->builder('mkp__pegawai a');
        $builder->select('COUNT(a.nip) as jml');

        $builder->where('a.unitkerja_id', $unitkerja_id['id']);

        $retData = $builder->get()->getRow()->jml;

        return $retData;
    }

    /**--------------------------------------------------------------------
     * HELPER FOR DATA TENAGAKERJA
     * --------------------------------------------------------------------
     */

    public function getTenagakerjaDetail()
    {
        $builder = $this->builder('mkp__tenagakerja a');
        $builder->select('a.*, g.status, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan, e.singkatan as wilayahkerja, f.*')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->join('org__wilayahkerja e', 'a.wilayah_id=e.id', 'left')
            ->join('mkp__tenagakerja_detail f', 'a.id=f.pegawai_id', 'left')
            ->join('mkp__tenagakerja_status g', 'a.status_id=g.id', 'left')
            ->orderBy('c.singkatan, d.singkatan, b.tingkat', 'asc');

        $dt_tenagakerja = $builder->get()->getResultArray();

        return $dt_tenagakerja;
    }

    public function getTenagakerjaDetailByNip($nip)
    {
        $builder = $this->builder('mkp__tenagakerja a');
        $builder->select('a.*, g.status, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan, e.singkatan as wilayahkerja, f.*')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->join('org__wilayahkerja e', 'a.wilayah_id=e.id', 'left')
            ->join('mkp__tenagakerja_detail f', 'a.id=f.pegawai_id', 'left')
            ->join('mkp__tenagakerja_status g', 'a.status_id=g.id', 'left')
            ->orderBy('c.singkatan, d.singkatan, b.tingkat', 'asc');

        $dt_tenagakerja = $builder->where('a.nip', $nip)->get()->getFirstRow();

        unset($dt_tenagakerja->pegawai_id);
        unset($dt_tenagakerja->kata_kunci);

        return $dt_tenagakerja;
    }

    public function getTenagakerjaPenempatan($appId, $mitrakerja_id = null)
    {
        $builder = $this->builder('mkp__tenagakerja a');
        $builder->select('a.*, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->orderBy('c.singkatan, d.singkatan, b.tingkat', 'asc');

        if (!is_null($mitrakerja_id) && $mitrakerja_id != 0) {
            $builder->where("a.penempatan_id", $mitrakerja_id);
        }

        $builder->where("a.apps_id", $appId);

        return $builder->get()->getResultArray();
    }

    public function getTenagakerjaDetailPenempatan($mitrakerja_id = null)
    {
        $builder = $this->builder('mkp__tenagakerja a');
        $builder->select('a.*, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->orderBy('c.singkatan, d.singkatan, b.tingkat', 'asc');

        if (!is_null($mitrakerja_id) && $mitrakerja_id != 0) {
            $builder->where("a.penempatan_id", $mitrakerja_id);
        }

        return $builder->get()->getResultArray();
    }

    public function getJmlTenagakerjaByMitrakerja($appId, $mitrakerja)
    {
        $builder = $this->builder('mkp__tenagakerja a');
        $builder->select('COUNT(a.nip) as jml')
            ->join('org__mitrakerja b', 'a.penempatan_id=b.id', 'left');

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            $builder->where('LEFT(b.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(b.kode,6)', $kode_induk);
        } else {
            $builder->where('a.penempatan_id', $mitrakerja['id']);
        }

        $builder->where("a.apps_id", $appId);

        $retData = $builder->get()->getRow()->jml;

        return $retData;
    }

    /**
     * --------------------------------------------------------------------
     * HELPER FOR PRESENSI
     * --------------------------------------------------------------------
     */
    //PEGAWAI
    public function getPresensiPegawai($periode, $pekerja_id = null, $unit_id = null)
    {
        $blnkehadiran = explode("-", $periode);

        $builder = $this->builder('mkp__kehadiran a');

        $builder->select('a.*, b.jenis as presensi, c.nama as petugas')
            ->join('mkp__kehadiran_jenis b', 'a.jenis=b.id', 'left')
            ->join('mkp__tenagakerja c', 'a.pekerja_id=c.id', 'left')
            ->where('MONTH(a.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(a.tanggal_1)', $blnkehadiran[0]);

        if (!is_null($unit_id)) {
            $builder->where('c.penempatan_id', $unit_id);
        }

        if (is_null($pekerja_id)) {
            $builder->orderBy('c.nama ASC, a.tanggal_1 ASC');
            return $builder->get()->getResultArray();
        } else {
            $builder->orderBy('a.tanggal_1 ASC');
            return $builder->where("a.pekerja_id", $pekerja_id)->get()->getResultArray();
        }
    }

    public function getPresensiPegawaiByUnitkerja($periode, $unitkerja)
    {
        $blnkehadiran = explode("-", $periode);

        $builder = $this->builder('mkp__kehadiran a');

        $builder->select('a.*, b.jenis as presensi, c.nip, c.nama as petugas, d.unitkerja, e.singkatan as penempatan, LEFT(e.kode,3) as kode_induk, LEFT(e.kode,6) as kode_sub_induk')
            ->join('mkp__kehadiran_jenis b', 'a.jenis=b.id', 'left')
            ->join('mkp__pegawai c', 'a.pekerja_id=c.id', 'left')
            ->join('org__unitkerja d', 'c.unitkerja_id=d.id', 'left')
            ->join('org__divisi e', 'c.penempatan_id=e.id', 'left')
            ->where('MONTH(a.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(a.tanggal_1)', $blnkehadiran[0])
            ->orderBy('a.tanggal_1', 'desc');

        if ($unitkerja['kelas_id'] == 1) {
            $kode_induk = substr($unitkerja['kode'], 0, 3);
            $builder->where('LEFT(e.kode,3)', $kode_induk);
        } else if ($unitkerja['kelas_id'] == 2) {
            $kode_induk = substr($unitkerja['kode'], 0, 6);
            $builder->where('LEFT(e.kode,6)', $kode_induk);
        } else {
            $builder->where('c.unitkerja_id', $unitkerja['id']);
        }

        return $builder->get()->getResultArray();
    }

    public function getRekapPresensiPegawaiByUnitkerja($periode, $unitkerja)
    {
        $blnkehadiran = explode("-", $periode);

        $builder = $this->builder('mkp__pegawai a');

        $builder->select('a.id, a.nip, a.nama as petugas, c.singkatan as unitkerja, d.singkatan as penempatan, SUM(IF(b.jenis=1,1,0)) as jml_kehadiran, SUM(IF(b.jenis=2,1,0)) AS jml_sakit, SUM(IF(b.jenis=3,1,0)) AS jml_cuti, SUM(IF(b.jenis=4,1,0)) AS jml_ijin')
            ->join('mkp__kehadiran b', 'a.id=b.pekerja_id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__divisi d', 'a.penempatan_id=d.id', 'left')
            ->join('mkp__kehadiran_jenis e', 'b.jenis=e.id', 'left')
            ->where('MONTH(b.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(b.tanggal_1)', $blnkehadiran[0])
            ->groupBy('a.unitkerja_id, a.penempatan_id, a.nama, a.id, a.nip')
            ->orderBy("a.nama");

        if ($unitkerja['kelas_id'] == 1) {
            $kode_induk = substr($unitkerja['kode'], 0, 3);
            $builder->where('LEFT(d.kode,3)', $kode_induk);
        } else if ($unitkerja['kelas_id'] == 2) {
            $kode_induk = substr($unitkerja['kode'], 0, 6);
            $builder->where('LEFT(d.kode,6)', $kode_induk);
        } else {
            $builder->where('a.unitkerja_id', $unitkerja['id']);
        }

        return $builder->get()->getResultArray();
    }

    public function countKehadiranPegawaiByUnitkerja($jenis, $bulan, $unitkerja)
    {
        $blnkehadiran = explode("-", $bulan);

        $builder = $this->builder('mkp__kehadiran a');

        $builder->select('a.id')
            ->join('mkp__tenagakerja b', 'a.pekerja_id=b.id', 'left')
            ->join('org__unitkerja c', 'b.unitkerja_id=c.id', 'left')
            ->where('a.jenis', $jenis)
            ->where('MONTH(a.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(a.tanggal_1)', $blnkehadiran[0]);


        if ($unitkerja['kelas_id'] == 1) {
            $kode_induk = substr($unitkerja['kode'], 0, 3);
            $builder->where('LEFT(c.kode,3)', $kode_induk);
        } else if ($unitkerja['kelas_id'] == 2) {
            $kode_induk = substr($unitkerja['kode'], 0, 6);
            $builder->where('LEFT(c.kode,6)', $kode_induk);
        } else {
            $builder->where('b.unitkerja_id', $unitkerja['id']);
        }

        return $builder->countAllResults();
    }

    //TENAGAKERJA
    public function getPresensiTenagakerja($periode, $pekerja_id = null, $unit_id = null)
    {
        $blnkehadiran = explode("-", $periode);

        $builder = $this->builder('mkp__kehadiran a');

        $builder->select('a.*, b.jenis as presensi, c.nama as petugas')
            ->join('mkp__kehadiran_jenis b', 'a.jenis=b.id', 'left')
            ->join('mkp__tenagakerja c', 'a.pekerja_id=c.id', 'left')
            ->where('MONTH(a.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(a.tanggal_1)', $blnkehadiran[0]);

        if (!is_null($unit_id)) {
            $builder->where('c.penempatan_id', $unit_id);
        }

        if (is_null($pekerja_id)) {
            $builder->orderBy('c.nama ASC, a.tanggal_1 ASC');
            return $builder->get()->getResultArray();
        } else {
            $builder->orderBy('a.tanggal_1 ASC');
            return $builder->where("a.pekerja_id", $pekerja_id)->get()->getResultArray();
        }
    }

    public function countKehadiranTenagakerja($jenis, $bulan, $mitrakerja_id = null)
    {
        $blnkehadiran = explode("-", $bulan);

        $builder = $this->builder('mkp__kehadiran a');

        $builder->select('a.id, b.penempatan_id')
            ->join('mkp__tenagakerja b', 'a.pekerja_id=b.id', 'left')
            ->where('a.jenis', $jenis)
            ->where('MONTH(a.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(a.tanggal_1)', $blnkehadiran[0]);

        if (!is_null($mitrakerja_id)) {
            $builder->where('b.penempatan_id', $mitrakerja_id);
        }

        return $builder->countAllResults();
    }

    public function countKehadiranTkByMitrakerja($appId, $jenis, $bulan, $mitrakerja)
    {
        $blnkehadiran = explode("-", $bulan);

        $builder = $this->builder('mkp__kehadiran a');

        $builder->select('a.id, b.penempatan_id')
            ->join('mkp__tenagakerja b', 'a.pekerja_id=b.id', 'left')
            ->join('org__mitrakerja c', 'b.penempatan_id=c.id', 'left')
            ->where('b.apps_id', $appId)
            ->where('a.jenis', $jenis)
            ->where('MONTH(a.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(a.tanggal_1)', $blnkehadiran[0]);


        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            $builder->where('LEFT(c.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(c.kode,6)', $kode_induk);
        } else {
            $builder->where('b.penempatan_id', $mitrakerja['id']);
        }

        return $builder->countAllResults();
    }

    public function countBertugasSaatIni($mitrakerja_id = null)
    {
        $builder = $this->builder('mkp__kehadiran a');
        $builder->select('a.id, b.penempatan_id')
            ->join('mkp__tenagakerja b', 'a.pekerja_id=b.id', 'left')
            ->where('a.status', "AKTIF");

        if (!is_null($mitrakerja_id)) {
            $builder->where('b.penempatan_id', $mitrakerja_id);
        }

        return $builder->countAllResults();
    }

    public function getPresensiTenagakerjaByMitraKerja($appId, $periode, $mitrakerja)
    {
        $blnkehadiran = explode("-", $periode);

        $builder = $this->builder('mkp__kehadiran a');

        $builder->select('a.*, b.jenis as presensi, c.nip, c.nama as petugas, d.unitkerja, e.mitrakerja as penempatan, LEFT(e.kode,3) as kode_induk, LEFT(e.kode,6) as kode_sub_induk')
            ->join('mkp__kehadiran_jenis b', 'a.jenis=b.id', 'left')
            ->join('mkp__tenagakerja c', 'a.pekerja_id=c.id', 'left')
            ->join('org__unitkerja d', 'c.unitkerja_id=d.id', 'left')
            ->join('org__mitrakerja e', 'c.penempatan_id=e.id', 'left')
            ->where('c.apps_id', $appId)
            ->where('MONTH(a.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(a.tanggal_1)', $blnkehadiran[0])
            ->orderBy('a.tanggal_1', 'desc');

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            $builder->where('LEFT(e.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(e.kode,6)', $kode_induk);
        } else {
            $builder->where('c.penempatan_id', $mitrakerja['id']);
        }

        return $builder->get()->getResultArray();
    }

    public function getRekapPresensiTenagakerjaByMitraKerja($appId, $periode, $mitrakerja)
    {
        $blnkehadiran = explode("-", $periode);

        $builder = $this->builder('mkp__tenagakerja a');

        $builder->select('a.id, a.nip, a.nama as petugas, c.singkatan as unitkerja, d.singkatan as penempatan, SUM(IF(b.jenis=1,1,0)) as jml_kehadiran, SUM(IF(b.jenis=2,1,0)) AS jml_sakit, SUM(IF(b.jenis=3,1,0)) AS jml_cuti, SUM(IF(b.jenis=4,1,0)) AS jml_ijin')
            ->join('mkp__kehadiran b', 'a.id=b.pekerja_id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->join('mkp__kehadiran_jenis e', 'b.jenis=e.id', 'left')
            ->where('a.apps_id', $appId)
            ->where('MONTH(b.tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(b.tanggal_1)', $blnkehadiran[0])
            ->groupBy('a.unitkerja_id, a.penempatan_id, a.nama, a.id, a.nip')
            ->orderBy("a.nama");

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            $builder->where('LEFT(d.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $builder->where('LEFT(d.kode,6)', $kode_induk);
        } else {
            $builder->where('a.penempatan_id', $mitrakerja['id']);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * --------------------------------------------------------------------
     * HELPER Get Data By Query
     * --------------------------------------------------------------------
     */
    public function getDataByQuery($tabelName, $kolomName, $filter = null)
    {

        $tabelName = str_replace(";", "", $tabelName);
        $kolomName = str_replace(";", "", $kolomName);
        $filter = str_replace(";", "", $filter);

        // Ensure we have a good db connection
        if (!$this->db instanceof BaseConnection) {
            $this->db = Database::connect();
        }
        if ($tabelName == "app__user") return "Protected Table!!!";

        if (!is_null($filter)) {
            $filter = " WHERE " . $filter;
        } else {
            $filter = "";
        }

        $yourQuery = "SELECT $kolomName FROM $tabelName $filter;";

        $result = $this->db->query($yourQuery);
        return $result;
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
