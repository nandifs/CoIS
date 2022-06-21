<?php

namespace App\Database;

use App\Models\M_mitrakerja;
use CodeIgniter\Database\BaseConnection;
use Config\Database;

class DbHTableKetenagakerjaan
{
    protected $db;
    protected $table;
    protected $builder;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /*
	| ----------------------SERVER SIDE DATA TENAGAKERJA----------------------------------
	*/

    //set column field database for datatable orderable
    private $column_order = array();

    //set column field database for datatable searchable 
    private $column_search = array();

    // default order 
    private $order = array('unitkerja' => 'asc');

    private $selField = "";

    private function tabel_tenagakerja($mitrakerja_id)
    {
        $dbMitrakerja = new M_mitrakerja();
        $mitrakerja = $dbMitrakerja->getMitraKerja($mitrakerja_id);

        $this->builder($this->table);
        $this->builder->select("$this->selField");

        if ($mitrakerja['kelas'] == 1) {
            $kode_induk = substr($mitrakerja['kode'], 0, 3);
            $this->builder->where('LEFT(kode_penempatan,3)', $kode_induk);
        } else if ($mitrakerja['kelas'] == 2) {
            $kode_induk = substr($mitrakerja['kode'], 0, 6);
            $this->builder->where('LEFT(kode_penempatan,6)', $kode_induk);
        } else {
            if (!is_null($mitrakerja_id) && $mitrakerja_id != 0) {
                $this->builder->where("penempatan_id", $mitrakerja_id);
            }
        }
    }

    private function _get_query($mitrakerja_id)
    {
        $this->tabel_tenagakerja($mitrakerja_id);

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

    public function getForTabelTenagakerja($mitrakerja_id, $tableName, $selectedField, $tableCols)
    {
        $this->table = $tableName;
        $this->selField = "id," . $selectedField;

        $temp1 = array(null,);
        $temp2 = explode(",", $tableCols);
        $temp3 = array_merge($temp1, $temp2);

        $this->column_order = $temp3;
        $this->column_search = $temp2;

        $this->_get_query($mitrakerja_id);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);

        $query = $this->builder->get();

        return $query->getResult();
    }

    public function count_filtered($mitrakerja_id)
    {
        $this->_get_query($mitrakerja_id);
        $query = $this->builder->countAllResults();
        return $query;
    }

    public function count_all($mitrakerja_id)
    {
        $this->tabel_tenagakerja($mitrakerja_id);
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
