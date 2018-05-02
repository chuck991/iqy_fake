<?php
namespace app\index\controller;

class Index extends BaseIndex
{
    public function index()
    {
        //首页幻灯片
        $slides = $this->db->table('slides')->order('sort')->cates('id');
        foreach ($slides as $key => $slide)
        {
            switch ($slide['type'])
            {
                case 0:
                    //首屏
                    $data['tops'][$key] = $slide;
                    break;
                case 1:
                    //今日热点
                    $data['hots'][$key] = $slide;
                    break;
                case 2:
                    //综艺
                    $data['zongyis'][$key] = $slide;
                    break;
                case 3:
                    //综艺
                    $data['yules'][$key] = $slide;
                    break;
            }
        }
        //导航
        $data['labels'] = $this->db->table('labels')->where(array('flag'=>'channel'))->order('sort')->lists();
        //娱乐
        $res = $this->db->table('videos')->where(array('channel_id'=>4,'status'=>1))->pages(10);
        $data['today_hots'] = $res['lists'];
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function cate()
    {
        //页面显示，获得标签
        $labels = $this->db->table('labels')->cates('id');
        foreach ($labels as $key => $label)
        {
            switch ($label['flag'])
            {
                case 'channel':
                    $data['channels'][$key] = $label;
                    break;
                case 'charge':
                    $data['charges'][$key] = $label;
                    break;
                case 'area':
                    $data['areas'][$key] = $label;
                    break;
                case 'type':
                    $data['types'][$key] = $label;
                    break;
                case 'size':
                    $data['sizes'][$key] = $label;
                    break;
            }
        }
        //逻辑处理
        //从地址中获取标签
        $videos['channel_id'] = (int)input('get.channel_id');
        $videos['charge_id'] = (int)input('get.charge_id');
        $videos['area_id'] = (int)input('get.area_id');
        $videos['type_id'] = (int)input('get.type_id');
        $videos['size_id'] = (int)input('get.size_id');
        //拼接查询条件
        $where = array();
            $videos['channel_id'] > 0 && $where = array_merge($where, array('channel_id'=>$videos['channel_id']));
            $videos['charge_id'] > 0 && $where = array_merge($where, array('charge_id'=>$videos['charge_id']));
            $videos['area_id'] > 0 && $where = array_merge($where, array('area_id'=>$videos['area_id']));
            $videos['type_id'] > 0 && $where = array_merge($where, array('type_id'=>$videos['type_id']));
            $videos['size_id'] > 0 && $where = array_merge($where, array('size_id'=>$videos['size_id']));
            $where = array_merge($where, array('status'=>1));
        //分页
        $data['pageSize'] = 6;
        $data['videos'] = $this->db->table('videos')->where($where)->order('id desc')->pages($data['pageSize']);
        $data['page'] = (int)max(1, input('get.page'));
        //传入页面数据
        $this->assign('data',$data);
        $this->assign('videos',$videos);
        return $this->fetch();
    }
    //视频播放页面
    public function video()
    {
        $video_id = (int)input('get.vid');
        $video_id && $data['video'] = $this->db->table('videos')->where(array('id'=>$video_id))->item();
        $data['channel'] = $this->db->table('labels')->field('title')->where(array('id'=>$data['video']['channel_id']))->item();
        if ($data['video'] == false)
        {
            //未找到相应视频，返回首页
            return $this->redirect('/index/index/cate');
        }
        $this->assign('data',$data);
        return $this->fetch();
    }
}
