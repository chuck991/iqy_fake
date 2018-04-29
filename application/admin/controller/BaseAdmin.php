<?php

namespace app\admin\controller;

use Utils\data\Sysdb;
use think\Controller;

class BaseAdmin extends Controller
{
    public $db;
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
        $this->db = new Sysdb();
    }

    //获得菜单树
    public function getTree($items)
    {
        $tree = array();
        foreach ($items as $item)
        {
            if(isset($items[$item['pid']]))
            {
                //非顶级菜单
                $items[$item['pid']]['childs'][] = &$items[$item['id']];
            } else{
                //顶级菜单
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }
    //格式化菜单列表
    public function formatMenu($items,&$res = array() )
    {
        foreach($items as $item)
        {
            if(!isset($item['childs']))
            {
                $res[] = $item;
            } else{
                $tmp = $item['childs'];
                unset($item['childs']);
                $res[] = $item;
                $this->formatMenu($tmp,$res);
            }
        }
        return $res;
    }
}