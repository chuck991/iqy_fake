<?php

namespace app\admin\controller;

use Utils\data\Sysdb;

/**
 * 后台管理首页
 * @package app\admin\controller*
 */
class Home extends BaseAdmin
{
    //后台首页
    public function index()
    {
        $this->assign('admin',session('admin'));
        return $this->fetch();
    }
    //后台主页欢迎界面
    public function welcome()
    {
        return $this->fetch();
    }
}