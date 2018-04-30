<?php

namespace app\admin\controller;

use think\Controller;
use Utils\data\Sysdb;
/**
 * 标签管理
 * @package app\admin\controller
 */
class Label extends BaseAdmin
{
    //频道
    public function channel()
    {
        $flag = 'channel';
        $data['lists'] = $this->db->table('labels')->where(array('flag'=>$flag))->lists();
        $this->assign('data',$data);
        $this->assign('flag',$flag);
        $this->assign('cname','频道');
        return $this->fetch('index');
    }
    //资费
    public function charge()
    {
        $flag = 'charge';
        $data['lists'] = $this->db->table('labels')->where(array('flag'=>$flag))->lists();
        $this->assign('data',$data);
        $this->assign('flag',$flag);
        $this->assign('cname','资费');
        return $this->fetch('index');
    }
    //地区
    public function area()
    {
        $flag = 'area';
        $data['lists'] = $this->db->table('labels')->where(array('flag'=>$flag))->lists();
        $this->assign('data',$data);
        $this->assign('flag',$flag);
        $this->assign('cname','地区');
        return $this->fetch('index');
    }
    //保存
    public function save()
    {
        $flag = trim(input('post.flag'));
        $titles = input('post.titles/a');
        $sorts = input('post.sorts/a');
        $status = input('post.status/a');

        foreach ($sorts as $key => $value)
        {
            $data['sort'] = $sorts[$key];
            $data['title'] = $titles[$key];
            $data['status'] = isset($status[$key]) ? 1 : 0;
            $data['flag'] = $flag;

            if ($key == 0 && $data['title'])
            {
                $rst = $this->db->table('labels')->insert($data);
                if (!$rst){
                    exit(json_encode(array('code'=>1, 'message'=>'保存失败')));
                }
                break;
            }
            if ($key > 0)
            {
                //处理已存在的菜单
                if ($data['title'] == '')
                {
                    //删除操作
                    $this->db->table('labels')->where(array('id'=>$key))->delete();
                    break;
                }
                if($data['title']){
                    //更新操作
                    $this->db->table('labels')->where(array('id'=>$key))->update($data);
                }
            }
        }
        exit(json_encode(array('code'=>0, 'message'=>'保存成功')));
    }
}