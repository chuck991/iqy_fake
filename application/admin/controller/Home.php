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
        $menus =$this->db->table('admin_menus')->where(array('hidden'=>0, 'pid'=>0))->cates('id');
        foreach($menus as $key => &$value)
        {
            $childs = $this->db->table('admin_menus')->where(array('hidden'=>0, 'pid'=>$key))->lists();
            $value['childs'] = $childs;
        }
        $this->assign('menus', $menus);
        $this->assign('admin',session('admin'));
        return $this->fetch();
    }
    //后台主页欢迎界面
    public function welcome()
    {
        $this->assign('admin',session('admin'));
        return $this->fetch();
    }
}