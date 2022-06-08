<?php

namespace App\Models;

use CodeIgniter\Model;

class M_presensi extends Model
{
    protected $table      = 'mkp__kehadiran';
    protected $returnType     = 'array';
    protected $allowedFields = [
        'pekerja_id',
        'jenis',
        'tanggal_1',
        'tanggal_2',
        'foto_1',
        'foto_2',
        'keterangan_1',
        'keterangan_2',
        'koordinat_1',
        'koordinat_2',
        'status'
    ];

    protected $useTimestamps = true;

    public function getPresensi($id = null)
    {
        if (is_null($id)) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function getPresensiAktif($pekerja_id)
    {
        $this->select("id, pekerja_id, status")
            ->where("status", "AKTIF")
            ->where("pekerja_id", $pekerja_id);
        return $this->first();
    }

    public function countKehadiranPegawai($jenis, $bulan, $pekerja_id = null)
    {
        $blnkehadiran = explode("-", $bulan);

        $this->where('jenis', $jenis)
            ->where('MONTH(tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(tanggal_1)', $blnkehadiran[0]);

        if (!is_null($pekerja_id)) {
            $this->where('pekerja_id', $pekerja_id);
        }

        return $this->countAllResults();
    }

    public function countKehadiranTenagakerja($jenis, $bulan, $pekerja_id = null)
    {
        $blnkehadiran = explode("-", $bulan);

        $this->where('jenis', $jenis)
            ->where('MONTH(tanggal_1)', $blnkehadiran[1])
            ->where('YEAR(tanggal_1)', $blnkehadiran[0]);

        if (!is_null($pekerja_id)) {
            $this->where('pekerja_id', $pekerja_id);
        }

        return $this->countAllResults();
    }
}
