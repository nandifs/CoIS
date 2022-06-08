<?php

namespace App\Controllers\Ampk\Petugas;

use App\Controllers\BaseController;
use App\Database\DbHelper;

class Dashboard extends BaseController
{
    protected $dbHelper;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
    }

    public function index()
    {
        return view($this->appName . '/v_app', $this->dtContent);
    }
}
