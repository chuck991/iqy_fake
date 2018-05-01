<?php

namespace app\admin\controller;

use think\Controller;
use Utils\data\Sysdb;
/**
 * 影片管理
 * @package app\admin\controller
 */
class Video extends BaseAdmin
{
    //影片列表
    public function index()
    {
        $data['wd'] = trim(input('get.wd'));
        $data['pageSize'] = 10;
        $data['page'] = max(1,(int)input('get.page'));
        $where = array();
        $data['wd'] && $where = 'title like "%' . $data['wd'] . '%"';
        //获取分页数据
        $videos = $this->db->table('videos')->where($where)->pages($data['pageSize']);
        //辅助数据
        $label_ids = [];
        foreach ($videos['lists'] as $video)
        {
            !in_array($video['channel_id'],$label_ids) && $label_ids[] = $video['channel_id'];
            !in_array($video['charge_id'],$label_ids) && $label_ids[] = $video['charge_id'];
            !in_array($video['area_id'],$label_ids) && $label_ids[] = $video['area_id'];
        }
        $sql = 'id in (' . implode(',', $label_ids) . ')';
        $label_ids && $data['labels']= $this->db->table('labels')->where($sql)->cates('id');

        $this->assign('videos',$videos);
        $this->assign('data',$data);
        return $this->fetch();
    }
    //添加保存视图
    public function add()
    {
        $id = (int)input('get.id');
        $data['video'] = $this->db->table('videos')->where(array('id'=>$id))->item();

        $labels = $this->db->table('labels')->lists();
        foreach ($labels as $key => $value)
        {
            switch ($value['flag']){
                case 'channel':
                    $data['channels'][] = $value;
                    break;
                case 'charge':
                    $data['charges'][] = $value;
                    break;
                case 'area':
                    $data['areas'][] = $value;
                    break;
                case 'type':
                    $data['types'][] = $value;
                    break;
                case 'size':
                    $data['sizes'][] = $value;
                    break;
                case 'my_time':
                    $data['my_times'][] = $value;
                    break;
            }
        }
        $this->assign('data',$data);
        return $this->fetch();
    }
    //图片上传
    public function upload_img()
    {
        $file = request()->file('file');
        if ($file == null)
        {
            exit(json_encode(array('code'=>1, 'message'=>'没有文件上传')));
        }
        $info = $file->move(ROOT_PATH .DS . 'public/uploads');
        $ext = strtolower($info->getExtension());
        if (!in_array($ext ,array('jpg','jpeg','png','gif')))
        {
            exit(json_encode(array('code'=>1, 'message'=>'文件格式不支持')));
        }
        $img = '/uploads/' . $info->getSaveName();
        exit(json_encode(array('code'=>0, 'message'=>$img)));
    }
    //影片保存
    public function save()
    {
        $id = (int)input('post.id');
        $data['title'] = trim(input('post.title'));
        $data['channel_id'] = input('post.channel_id');
        $data['charge_id'] = input('post.charge_id');
        $data['area_id'] = input('post.area_id');
        $data['type_id'] = input('post.type_id');
        $data['size_id'] = input('post.size_id');
        $data['url'] = trim(input('post.url'));
        $data['keywords'] = trim(input('post.keywords'));
        $data['desc'] = trim(input('post.desc'));
        $data['status'] = trim(input('post.status'));
        $data['img'] = trim(input('post.img'));

        if ($data['title'] == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'影片名称不能为空')));
        }
        if ($data['url'] == '')
        {
            exit(json_encode(array('code'=>1, 'message'=>'影片地址不能为空')));
        }

        if ($id > 0){
            //更新
            $data['update_at'] = time();
            $this->db->table('videos')->where(array('id'=>$id))->update($data);
        } else{
            //新增
            $data['create_at'] = time();
            $res = $this->db->table('videos')->insert($data);
            if (!$res)
            {
                exit(json_encode(array('code'=>1, 'message'=>'保存失败')));
            }
        }
        exit(json_encode(array('code'=>0, 'message'=>'保存成功')));

    }
    //影片删除
    public function del()
    {
        $id = (int)input('post.id');
        $rst = $this->db->table('videos')->where(array('id'=>$id))->delete();
        if (!$rst)
        {
            exit(json_encode(array('code'=>1, 'message'=>'删除失败')));
        }
        exit(json_encode(array('code'=>0, 'message'=>'删除成功')));
    }

}