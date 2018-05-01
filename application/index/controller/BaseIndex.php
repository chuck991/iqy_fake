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
        $site = $this->db->table('sites')->where(array('names'=>'site'))->item();
        $site && $site['values'] = json_decode($site['values']);
        $this->assign('site',$site);
    }
}