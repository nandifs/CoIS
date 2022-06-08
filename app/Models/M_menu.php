<?php

namespace App\Models;

use CodeIgniter\Model;

class M_menu extends Model
{
    protected $table      = 'app__menu';
    protected $returnType = 'array';

    public function getMenus($apps = null, $otoritas = null)
    {
        return $this->where('app_id', $apps)->like('tag_otoritas_id', $otoritas)->orderBy('id', 'asc')->findAll();
    }

    public function getMenu($id)
    {
        return $this->find($id);
    }
}
