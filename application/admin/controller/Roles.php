<?php

namespace app\admin\controller;

use think\Controller;
use Utils\data\Sysdb;
/**
 * 角色管理
 * @package app\admin\controller
 */
class Roles extends BaseAdmin
{
    //角色列表
    public function index()
    {
       $data['roles'] = $this->db->table('admin_groups')->lists();
       $this->assign('data', $data);
        return $this->fetch();
    }
    //添加
    public function add()
    {
        $id = input('get.id');
        //菜单列项
        $menus = $this->db->table('admin_menus')->where(array('status'=>0))->cates('id');
        $menuTrees = $this->getTree($menus);
        $results = array();
        foreach ($menuTrees as $menuTree)
        {
            $menuTree['childs'] = isset($menuTree['childs']) ? $this->formatMenu($menuTree['childs']) : false;
            $results[] = $menuTree;
        }

        //编辑操作
        $role = $this->db->table('admin_groups')->where(array('id'=>$id))->item();
        $role['rights'] = isset($role['rights'])? json_decode($role['rights']) : array();

        $this->assign('role', $role);
        $this->assign('menus',$results);
        return $this->fetch();
    }
    //保存
    public function save()
    {
        $id = (int)input('post.id');
        $data['group_name'] = trim(input('post.group_name'));
        $data['rights'] = input('post.rights/a') ? input('post.rights/a') : array();
        $data['rights'] = json_encode($data['rights']);
        if ( $data['group_name'] == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'未填写角色名称')));
        }
        $res = true;
        if (!$id){
            //新建
            $res = $this->db->table('admin_groups')->insert($data);
        } else{
            //更新
            $this->db->table('admin_groups')->where(array('id'=>$id))->update($data);
        }
        if (!$res)
        {
            exit(json_encode(array('code'=>1, 'message'=>'保存失败')));
        }
        exit(json_encode(array('code'=>0, 'message'=>'保存成功')));
    }
    //删除
    public function del()
    {
        $id = (int)input('post.id');
        $res = $this->db->table('admin_groups')->where(array('id'=>$id))->delete();
        if (!$res)
        {
            exit(json_encode(array('code'=>1, 'message'=>'删除失败')));
        }
        exit(json_encode(array('code'=>0, 'message'=>'删除成功')));
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