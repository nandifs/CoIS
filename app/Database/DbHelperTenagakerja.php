<?php

namespace App\Database;

use App\Models\M_mitrakerja;
use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHelperTenagakerja
{
    protected $db;
    protected $table;
    protected $builder;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /*
	| ----------------------SERVER SIDE DATA PERTANYAAN----------------------------------
	*/

    private $column_order = array(null, 'a.nip', 'a.nama', 'b.singkatan', 'c.singkatan', 'd.singkatan', 'e.singkatan', 'f.status'); //set column field database for datatable orderable
    private $column_search = array('a.nip', 'a.nama', 'b.singkatan', 'c.singkatan', 'd.singkatan', 'e.singkatan', 'f.status'); //set column field database for datatable searchable 
    private $order = array('c.singkatan' => 'asc'); // default order 

    private function tabel_tenagakerja($appId, $mitrakerja_id)
    {
        $dbMitrakerja = new M_mitrakerja();
        $mitrakerja = $dbMitrakerja->getMitraKerja($mitrakerja_id);

        $this->builder('mkp__tenagakerja a');
        $this->builder->select('a.id, a.nip, a.nama, a.jabatan_id, a.unitkerja_id, a.penempatan_id, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan, e.singkatan as wilayahkerja, f.status as status_tenagakerja')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__mitrakerja d', 'a.penempatan_id=d.id', 'left')
            ->join('org__wilayahkerja e', 'a.wilayah_id=e.id', 'left')
            ->join('mkp__tenagakerja_status f', 'a.status_id=f.id', 'left')
            ->orderBy('c.singkatan, d.singkatan, b.tingkat', 'asc');

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            $this->builder->where('LEFT(d.kode,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $this->builder->where('LEFT(d.kode,6)', $kode_induk);
        } else {
            if (!is_null($mitrakerja_id) && $mitrakerja_id != 0) {
                $this->builder->where("a.penempatan_id", $mitrakerja_id);
            }
        }
        if ($appId != "40") {
            $this->builder->where("a.apps_id", $appId);
        }
    }

    private function _get_query($appId, $mitrakerja_id)
    {
        $this->tabel_tenagakerja($appId, $mitrakerja_id);

        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->builder->groupStart(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->builder->like($item, $_POST['search']['value']);
                } else {
                    $this->builder->orLike($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->builder->groupEnd(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->builder->orderBy($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getForTabelTenagakerja($appId, $mitrakerja_id)
    {
        $this->_get_query($appId, $mitrakerja_id);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);

        $query = $this->builder->get();

        return $query->getResult();
    }

    public function count_filtered($appId, $mitrakerja_id)
    {
        $this->_get_query($appId, $mitrakerja_id);
        $query = $this->builder->countAllResults();
        return $query;
    }

    public function count_all($appId, $mitrakerja_id)
    {
        $this->tabel_tenagakerja($appId, $mitrakerja_id);
        return $this->builder->countAllResults();
    }

    /*
	| -------------------------------------------------------------------
	*/

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
