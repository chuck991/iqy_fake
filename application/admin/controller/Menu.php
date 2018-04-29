<?php

namespace app\admin\controller;

use think\Controller;
use Utils\data\Sysdb;
/**
 * 菜单管理
 * @package app\admin\controller
 */
class Menu extends BaseAdmin
{
    //菜单列表
  public function index()
  {
      $back_id = 0;
      $pid = (int)input('get.pid');
      if ($pid > 0){
         $item = $this->db->table('admin_menus')->where(array('id'=>$pid))->item();
         $back_id = $item['pid'];
      }
      $data['lists'] = $this->db->table('admin_menus')->where(array('pid'=>$pid))->lists();
      $this->assign('data', $data);
      $this->assign('back_id',$back_id);
      $this->assign('pid',$pid);
      return $this->fetch();
  }
  //菜单保存
    public function save()
    {
        $pid = (int)input('post.pid');
        $titles = input('post.titles/a');
        $sorts = input('post.sorts/a');
        $controllers = input('post.controllers/a');
        $actions = input('post.actions/a');
        $hiddens = input('post.hiddens/a');
        $status = input('post.status/a');

        foreach ($sorts as $key => $value)
        {
            $data['sort'] = $sorts[$key];
            $data['title'] = $titles[$key];
            $data['controller'] = $controllers[$key];
            $data['action'] = $actions[$key];
            $data['hidden'] = isset($hiddens[$key]) ? 1 : 0;
            $data['status'] = isset($status[$key]) ? 1 : 0;
            $data['pid'] = $pid;

            if ($key == 0 && $data['title'])
            {
                $rst = $this->db->table('admin_menus')->insert($data);
                if (!$rst){
                    exit(json_encode(array('code'=>1, 'message'=>'保存失败')));
                }
                break;
            }
            if ($key > 0)
            {
                //处理已存在的菜单
                if ($data['title'] == '' && $data['controller'] == '' && $data['action'] == '')
                {
                    //删除操作
                    $this->db->table('admin_menus')->where(array('id'=>$key))->delete();
                    break;
                }
                if($data['title']){
                    //更新操作
                    $this->db->table('admin_menus')->where(array('id'=>$key))->update($data);
                }
            }
        }
        exit(json_encode(array('code'=>0, 'message'=>'保存成功')));
    }
}