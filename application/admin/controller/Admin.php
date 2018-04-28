<?php

namespace app\admin\controller;

use think\Controller;
/**
 * 管理员管理
 * @package app\admin\controller
 */
class Admin extends BaseAdmin
{
    //管理员列表
    public function index()
    {
        $data = $this->db->table('admins')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //显示添加管理员页面
    public function add()
    {
        $data = $this->db->table('admin_groups')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //添加管理员
    public function save()
    {
        $data['username'] = trim(input('post.username'));
        $data['gid'] = trim(input('post.gid'));
        $data['truename'] = trim(input('post.truename'));
        $data['status'] = trim(input('post.status'));
        $password = trim(input('post.password'));

        //验证数据
        if ($data['username'] == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'用户名不能为空')));
        }
        if ($data['gid'] == 0 )
        {
            exit(json_encode(array('code'=>1, 'message'=>'未选择角色')));
        }
        if ($password == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'密码不能为空')));
        }
        if ($data['truename'] == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'姓名不能为空')));
        }
        //验证成功，校验数据库
        $admin = $this->db->table('admins')->where(array('username'=>$data['username']))->item();
        if ($admin){
            exit(json_encode(array('code'=>1, 'message'=>'该用户名已存在')));
        }
        //验证成功，保存密码
        $data['password'] = md5($data['username'] . $password);
        //保存数据
        $rst = $this->db->table('admins')->insert($data);
        if (!$rst)
        {
            exit(json_encode(array('code'=>1, 'message'=>'管理员添加失败')));
        }
        exit(json_encode(array('code'=>0, 'message'=>'管理员添加成功')));

    }
}