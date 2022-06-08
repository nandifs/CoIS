<?php

namespace App\Database;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHelperPegawai
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

    private $column_order = array(null, 'a.nip', 'a.nama', 'b.singkatan', 'c.singkatan', 'd.singkatan'); //set column field database for datatable orderable
    private $column_search = array('a.nip', 'a.nama', 'b.singkatan', 'c.singkatan', 'd.singkatan'); //set column field database for datatable searchable 
    private $order = array('c.singkatan' => 'asc'); // default order 

    private function tabel_pegawai($unitkerja_id)
    {
        $this->builder('mkp__pegawai a');
        $this->builder->select('a.id, a.nip, a.nama, a.jabatan_id, a.unitkerja_id, a.penempatan_id, b.singkatan as jabatan, c.singkatan as unitkerja, d.singkatan as penempatan')
            ->join('mkp__jabatan b', 'a.jabatan_id=b.id', 'left')
            ->join('org__unitkerja c', 'a.unitkerja_id=c.id', 'left')
            ->join('org__divisi d', 'a.penempatan_id=d.id', 'left')
            ->orderBy('c.singkatan, d.singkatan, b.tingkat', 'asc');

        if (!is_null($unitkerja_id) && $unitkerja_id != 0) {
            $this->builder->where("a.unitkerja_id", $unitkerja_id);
        }
        //dd($this->builder->get()->getResult());
    }

    private function _get_query($unitkerja_id)
    {
        $this->tabel_pegawai($unitkerja_id);

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

    public function getForTabelPegawai($unitkerja_id)
    {
        $this->_get_query($unitkerja_id);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);

        $query = $this->builder->get();

        return $query->getResult();
    }

    public function count_filtered($unitkerja_id)
    {
        $this->_get_query($unitkerja_id);
        $query = $this->builder->countAllResults();
        return $query;
    }

    public function count_all($unitkerja_id)
    {
        $this->tabel_pegawai($unitkerja_id);
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
