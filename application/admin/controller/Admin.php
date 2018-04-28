<?php

namespace app\admin\controller;

use think\Controller;
use Utils\data\Sysdb;
/**
 * 管理员管理
 * @package app\admin\controller
 */
class Admin extends BaseAdmin
{
    //管理员列表
    public function index()
    {
        $data['admins'] = $this->db->table('admins')->lists();
        $data['groups'] = $this->db->table('admin_groups')->cates('id');
        $this->assign('data',$data);
        return $this->fetch();
    }
    //显示添加管理员页面
    public function add()
    {
        $id = input('get.id');
        $data['admin'] = $this->db->table('admins')->where(array('id'=>$id))->item();
        $data["groups"] = $this->db->table('admin_groups')->cates('id');
        $this->assign('data',$data);
        return $this->fetch();
    }
    //添加和修改管理员
    public function save()
    {
        $id = (int)input('post.id');
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
        //针对添加操作
        if ($id == 0 && $password == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'密码不能为空')));
        }
        if ($data['truename'] == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'姓名不能为空')));
        }
        //针对添加操作，编辑操作时如果用户未修改密码，则默认不改变密码
        if($password){
            $data['password'] = md5($data['username'] . $password);
        }
        $rst = true;//默认编辑时为true,tp5编辑时未有任何修改，点保存也会报错
        if($id == 0)
        {
            //验证成功，校验数据库
            $admin = $this->db->table('admins')->where(array('username'=>$data['username']))->item();
            if ($admin){
                exit(json_encode(array('code'=>1, 'message'=>'该用户名已存在')));
            }
            //验证成功，保存密码等字段

            $data['create_at'] = time();
            //保存数据
            $rst = $this->db->table('admins')->insert($data);
        }else{
            $this->db->table('admins')->where(array('id'=>$id))->update($data);
        }
        if (!$rst)
        {
            exit(json_encode(array('code'=>1, 'message'=>'保存失败')));
        }
        exit(json_encode(array('code'=>0, 'message'=>'保存成功')));

    }
    //删除
    public function del()
    {
        $id = (int)input('post.id');
        $rst = $this->db->table('admins')->where(array('id'=>$id))->delete();
        if(!$rst)
        {
            exit(json_encode(array('code'=>1, 'message'=>'删除失败')));
        }
        exit(json_encode(array('code'=>0, 'message'=>"删除成功")));
    }
}