<?php

namespace App\Models;

use CodeIgniter\Model;

class M_tenagakerja_mutasi extends Model
{
    protected $table      = 'mkp__tenagakerja_mutasi';
    protected $primaryKey = 'pegawai_id';
    protected $returnType     = 'array';
    protected $allowedFields = ['pegawai_id', 'jenis', 'sifat', 'jabatan_lama_id', 'jabatan_baru_id', 'unitkerja_lama_id', 'unitkerja_baru_id', 'penempatan_lama_id', 'penempatan_baru_id', 'wilayahkerja_lama_id', 'wilayahkerja_baru_id', 'keterangan_mutasi', 'tanggal_berlaku', 'berkas'];
}
