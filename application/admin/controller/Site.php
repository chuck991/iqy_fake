<?php

namespace app\admin\controller;

use think\Controller;
use Utils\data\Sysdb;
/**
 * 网站设置
 * @package app\admin\controller
 */
class Site extends BaseAdmin
{
    //视图
    public function index()
    {
        $site = $this->db->table('sites')->where(array('names'=>'site'))->item();
        if ($site)
        {
            $site && $site['values'] = json_decode($site['values']);
            $this->assign('site', $site);
        }
        return $this->fetch();
    }
    //保存
    public function save()
    {
        $title = trim(input('post.title'));
        $site = $this->db->table('sites')->where(array('names'=>'site'))->item();
        $res = true;
        if (!$site)
        {
            $res =$this->db->table('sites')->insert(array(
                    'names'=>'site',
                    'values'=>json_encode($title)));
        } else {
            $this->db->table('sites')->where(array('names'=>'site'))->update(array('values'=>json_encode($title)));
        }
        if (!$res)
        {
            exit(json_encode(array('code'=>1,'message'=>'提交失败')));
        }
        exit(json_encode(array('code'=>0,'message'=>'保存成功')));
    }
}