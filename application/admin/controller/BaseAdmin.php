<?php

namespace app\admin\controller;

use Utils\data\Sysdb;
use think\Controller;

class BaseAdmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_admin = session('admin');
        //登录拦截
        if(!$this->_admin)
        {
            header('Location: /admin/account/login');
            exit;
        }
    }
}