<?php

namespace app\index\controller;

use Utils\data\Sysdb;
use think\Controller;

class BaseIndex extends Controller
{
    public $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Sysdb();
        $sites = $this->db->table('sites')->cates('names');
        $this->assign('sites',$sites);
    }
}