<?php

namespace App\Database;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHelperUser
{
    protected $db;
    protected $table;
    protected $builder;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    //--------------------------------------------------------------------
    // HELPER FOR USER SESSION/LOGIN
    //--------------------------------------------------------------------
    public function getUserForLogin($uid = null)
    {
        $builder = $this->builder('app__user');
        return $builder->select('uid, uname, kata_kunci, status_id')->where('uid',  $uid)->get()->getRow();
    }

    public function getUserForSession($uid = null)
    {
        $builder = $this->builder('app__user a');
        return $builder->select('a.id, a.uid, a.uname, a.kata_kunci, a.apps_id, b.nama as nama_aplikasi, b.logo, b.brand, a.otoritas_id, c.otorisasi, d.foto, a.unitkerja_id, a.data_unit_id, a.data_akses_id, e.singkatan as data_akses_mitra, f.singkatan as unitkerja, a.status_id')
            ->join('app__aplikasi b', 'a.apps_id=b.id', 'left')
            ->join('app__user_otorisasi c', 'a.otoritas_id=c.id', 'left')
            ->join('app__user_profile d', 'a.apps_id=d.id', 'left')
            ->join('org__mitrakerja e', 'a.data_akses_id=e.id', 'left')
            ->join('org__unitkerja f', 'a.data_akses_id=f.id', 'left')
            ->getWhere(['a.uid' => $uid])->getRow();
    }

    public function getUserForSession_1($uid = null)
    {
        $builder = $this->builder('app__user a');
        return $builder->select('a.id, a.uid, a.uname, a.apps_id, h.name as aplikasi, a.otoritas_id, a.data_akses_id, a.status_id, b.unitkerja_id, b.penempatan_id, c.otorisasi, d.unitkerja, e.mitrakerja as penempatan, f.status, g.singkatan as data_akses_mitra')
            ->join('mkp__tenagakerja b', 'a.profile_id=b.id', 'left')
            ->join('app__user_otorisasi c', 'a.otoritas_id=c.id', 'left')
            ->join('org__unitkerja d', 'b.unitkerja_id=d.id', 'left')
            ->join('org__mitrakerja e', 'b.penempatan_id=e.id', 'left')
            ->join('app__user_status f', 'a.status_id=f.id', 'left')
            ->join('org__mitrakerja g', 'a.data_akses_id=g.id', 'left')
            ->join('app__aplikasi h', 'a.apps_id=h.id', 'left')
            ->getWhere(['a.uid' => $uid])->getRow();
    }

    public function getPegawaiForLogin($uid = null)
    {
        $builder = $this->builder('mkp__pegawai');
        return $builder->select('nip as uid, kata_kunci, status_id')->where('nip', $uid)->get()->getRow();
    }

    public function getPegawaiForSession($uid = null)
    {
        $builder = $this->builder('mkp__pegawai a');
        return $builder->select('a.id, a.nip as uid, a.nama as uname, a.foto, a.otoritas_id, a.status_id, a.unitkerja_id, a.penempatan_id, b.otorisasi, c.unitkerja as unitkerja_lengkap, c.singkatan as unitkerja, d.mitrakerja as penempatan, e.status, a.penempatan_id as data_akses_id, f.singkatan as data_akses_mitra, a.apps_id, g.nama as nama_aplikasi, g.logo, g.brand, a.unitkerja_id as data_unit_id')
            ->join('app__user_otorisasi b', 'a.otoritas_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->join('app__user_status e', 'a.status_id=e.id', 'left')
            ->join('org__mitrakerja f', 'a.penempatan_id=f.id', 'left')
            ->join('app__aplikasi g', 'a.apps_id=g.id', 'left')
            ->getWhere(['a.nip' => $uid])->getRow();
    }

    public function getTenagakerjaForLogin($uid = null)
    {
        $builder = $this->builder('mkp__tenagakerja');
        return $builder->select('nip as uid, kata_kunci, status_id')->where('nip', $uid)->get()->getRow();
    }

    public function getTenagakerjaForSession($uid = null)
    {
        $builder = $this->builder('mkp__tenagakerja a');
        return $builder->select('a.id, a.nip as uid, a.nama as uname, a.foto, a.otoritas_id, a.status_id, a.unitkerja_id, a.penempatan_id, b.otorisasi, c.unitkerja as unitkerja_lengkap, c.singkatan as unitkerja, d.mitrakerja as penempatan, e.status, a.penempatan_id as data_akses_id, f.singkatan as data_akses_mitra, a.apps_id, g.nama as nama_aplikasi, g.logo, g.brand, a.unitkerja_id as data_unit_id')
            ->join('app__user_otorisasi b', 'a.otoritas_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->join('app__user_status e', 'a.status_id=e.id', 'left')
            ->join('org__mitrakerja f', 'a.penempatan_id=f.id', 'left')
            ->join('app__aplikasi g', 'a.apps_id=g.id', 'left')
            ->getWhere(['a.nip' => $uid])->getRow();
    }

    //--------------------------------------------------------------------
    // HELPER FOR MANAJEMEN USER
    //--------------------------------------------------------------------
    public function getUserDetail($uid = null)
    {
        $builder = $this->builder('app__user a');
        $builder->select('a.*, f.nama as aplikasi, b.otorisasi, c.unitkerja, d.mitrakerja as data_akses, e.status')
            ->join('app__user_otorisasi b', 'a.otoritas_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.data_akses_id=d.id', 'left')
            ->join('app__user_status e', 'a.status_id=e.id', 'left')
            ->join('app__aplikasi f', 'a.apps_id=f.id', 'left')
            ->where('a.otoritas_id<>', 99)
            ->orderBy('a.apps_id', 'ASC')
            ->orderBy('a.unitkerja_id', 'ASC')
            ->orderBy('a.otoritas_id', 'ASC');

        if (is_null($uid)) {
            return $builder->get()->getResultArray();
        } else {
            return $builder->where('a.uid', $uid)->get()->getFirstRow();
        }
    }

    public function getUserDetailByApplicationId($appID)
    {
        $builder = $this->builder('app__user a');
        $builder->select('a.*, f.nama as aplikasi, b.otorisasi, c.unitkerja, d.mitrakerja as data_akses, e.status')
            ->join('app__user_otorisasi b', 'a.otoritas_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.data_akses_id=d.id', 'left')
            ->join('app__user_status e', 'a.status_id=e.id', 'left')
            ->join('app__aplikasi f', 'a.apps_id=f.id', 'left')
            ->where('a.otoritas_id<>', 99)
            ->where('a.apps_id', $appID)
            ->orderBy('a.apps_id', 'ASC')
            ->orderBy('a.unitkerja_id', 'ASC')
            ->orderBy('a.otoritas_id', 'ASC');

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
}
