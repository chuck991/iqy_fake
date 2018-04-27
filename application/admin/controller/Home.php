<?php

namespace app\admin\controller;

use Utils\data\Sysdb;

class Home extends BaseAdmin
{
    //后台首页
    public function index()
    {
        $this->assign('admin',session('admin'));
        return $this->fetch();
    }
}