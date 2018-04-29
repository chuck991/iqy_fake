<?php

namespace app\admin\controller;

use think\Db;
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
        $res = array();
        //获取角色,获得角色所对应的菜单
        $role = $this->db->table('admin_groups')->where(array('id'=>$this->_admin['gid']))->item();
        if ($role)
        {
            $role['rights'] = (isset($role['rights']) && $role['rights']) ? json_decode($role['rights']) : [];
        }
        if($role['rights'])
        {
            //过滤被隐藏和禁用的菜单项
            $where = "id in(" . implode(',', $role['rights']) . ") and hidden=0 and status=0";
            $res = $this->db->table('admin_menus')->where($where)->cates('id');
            $res && $res = $this->getTree($res);

        }
        $menus = array();
        //将菜单封装成二级菜单，顶级菜单为1级，其余均为二级
        foreach($res as $tree)
        {
            $tree['childs'] = isset($tree['childs']) ? $this->formatMenu($tree['childs']) : false;
            $menus[] = $tree;
        }
        $this->assign('menus', $menus);
        $this->assign('role', $role);

        return $this->fetch();
    }
    //后台主页欢迎界面
    public function welcome()
    {
        return $this->fetch();
    }

}