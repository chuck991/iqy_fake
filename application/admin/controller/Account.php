<?php

namespace app\admin\controller;

use Utils\data\Sysdb;
use think\Controller;

class Account extends Controller
{
    //登陆页面
    public function login()
    {
        return $this->fetch();
    }
    //管理员登录验证
    public function doLogin()
    {
        $username = trim(input('post.username'));
        $password = trim(input('post.password'));
        $verifyCode = trim(input('post.verifyCode'));
        if ($username == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'用户名不能为空')));
        }
        if ($password == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'密码不能为空')));
        }
        if ($verifyCode == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'验证码不能为空')));
        }

        //验证验证码
        if (!captcha_check($verifyCode))
        {
            exit(json_encode(array('code'=>1, 'message'=>'验证码有误')));
        }
        $sysdb = new Sysdb();
//        $password = md5($username . $password);
        $admin = $sysdb->table('admins')->where(array('username'=>$username,'password'=>$password))->item();
        if (!$admin)
        {
            exit(json_encode(array('code'=>2, 'message'=>'用户名或密码有误')));
        }
        //验证用户是否被禁用
        if ($admin['status'] == 1)
        {
            exit(json_encode(array('code'=>1, 'message'=>'该用户已被禁用')));
        }
        //验证成功
        //TODO 管理员信息更新

        session('admin',$admin);
        exit(json_encode(array('code'=>0, 'message'=>'登录成功')));
    }
}