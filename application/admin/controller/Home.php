<?php

namespace app\admin\controller;

use Utils\data\Sysdb;

/**
 * 后台管理首页
 * @package app\admin\controller*
 */
class Home extends BaseAdmin
{
    public $admin;

    //后台首页
    public function index()
    {
        $this->admin = session('admin');
        $this->assign('admin',$this->admin);
        return $this->fetch();
    }
    //后台主页欢迎界面
    public function welcome()
    {
        $this->assign('admin',$this->admin);
        return $this->fetch();
    }
}