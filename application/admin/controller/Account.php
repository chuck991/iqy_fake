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
}