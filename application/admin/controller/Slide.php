<?php

namespace app\admin\controller;

use think\Controller;
use Utils\data\Sysdb;
/**
 * 幻灯片管理
 * @package app\admin\controller
 */
class Slide extends BaseAdmin
{
    //幻灯片列表
    //首页首屏
    public function top()
    {
        $data['type'] = 0;
        $data['slides'] = $this->db->table('slides')->where(array('type'=> $data['type']))->order('sort')->cates('id');
        $this->assign('data',$data);
        return $this->fetch('index');
    }
    //今日热点
    public function hot()
    {
        $data['type'] = 1;
        $data['slides'] = $this->db->table('slides')->where(array('type'=> $data['type']))->order('sort')->cates('id');
        $this->assign('data',$data);
        return $this->fetch('index');
    }
    //综艺
    public function zongyi()
    {
        $data['type'] = 2;
        $data['slides'] = $this->db->table('slides')->where(array('type'=> $data['type']))->order('sort')->cates('id');
        $this->assign('data',$data);
        return $this->fetch('index');
    }
    public function yule()
    {
        $data['type'] = 3;
        $data['slides'] = $this->db->table('slides')->where(array('type'=> $data['type']))->order('sort')->cates('id');
        $this->assign('data',$data);
        return $this->fetch('index');
    }
    //添加首屏
    public function add()
    {
        $data['type'] = (int)input('get.type');
        $id = (int)input('get.id');
        $data['slide'] = $this->db->table('slides')->where(array('id'=>$id))->item();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //保存
    public function save()
    {
        $id = (int)input('post.id');
        $data['type'] = (int)input('post.type');
        $data['title'] = trim(input('post.title'));
        $data['desc'] = trim(input('post.desc'));
        $data['url'] = trim(input('post.url'));
        $data['img'] = trim(input('post.img'));
        $data['sort'] = trim(input('post.sort'));


        if ($data['title'] == '' ||  $data['url'] == '' || $data['img']=='')
        {
            exit(json_encode(array('code'=>1, 'message'=>'标题不能为空')));
        }
        if ($id > 0)
        {
            //更新操作
            $this->db->table('slides')->where(array('id'=>$id))->update($data);
        } else{
            //新增
            $res = $this->db->table('slides')->insert($data);
            if (!$res)
            {
                exit(json_encode(array('code'=>1, 'message'=>'创建失败')));
            }
        }
        exit(json_encode(array('code'=>0, 'message'=>'保存成功')));

    }
    //图片上传
    public function upload_img()
    {
        $file = request()->file('file');
        if ($file == null)
        {
            exit(json_encode(array('code'=>1, 'message'=>'没有文件上传')));
        }
        $info = $file->move(ROOT_PATH .DS . 'public/uploads/slide/');
        $ext = strtolower($info->getExtension());
        if (!in_array($ext ,array('jpg','jpeg','png','gif')))
        {
            exit(json_encode(array('code'=>1, 'message'=>'文件格式不支持')));
        }
        $img = '/uploads/slide/' . $info->getSaveName();
        exit(json_encode(array('code'=>0, 'message'=>$img)));
    }
    //删除
    public function del()
    {
        $id = (int)input('post.id');
        $rst = $this->db->table('slides')->where(array('id'=>$id))->delete();
        if (!$rst)
        {
            exit(json_encode(array('code'=>1, 'message'=>'删除失败')));
        }

        exit(json_encode(array('code'=>0, 'message'=>'删除成功')));
    }
}