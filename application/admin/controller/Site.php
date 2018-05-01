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
        $sites = $this->db->table('sites')->cates('names');
        $this->assign('sites', $sites);
        return $this->fetch();
    }
    //保存
    public function save()
    {
        $data['title']['values'] = trim(input('post.title'));
        $data['title']['names'] = 'title';
        $data['desc']['values'] = trim(input('post.desc'));
        $data['desc']['names'] = 'desc';
        $site_name = $this->db->table('sites')->where(array('names'=>'title'))->item();
        $site_desc = $this->db->table('sites')->where(array('names'=>'desc'))->item();
        //网站名称
        $site_name ? $this->db->table('sites')->where(array('names'=>'title'))->update($data['title']) : $this->db->table('sites')->insert($data['title']);
        //网站描述
        $site_desc ? $this->db->table('sites')->where(array('names'=>'desc'))->update($data['desc']) : $this->db->table('sites')->insert($data['desc']);
        exit(json_encode(array('code'=>0,'message'=>'保存成功')));
    }
}