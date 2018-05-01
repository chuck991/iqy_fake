<?php

namespace Utils\data;

use think\Db;

class Sysdb
{
    //表名
    public function table($table)
    {
        //清空属性
        $this->where = array();
        $this->field = '*';
        $this->order = '';
        $this->table = $table;
        return $this;
    }
    //指定字段
    public function field($field = '*')
    {
        $this->field = $field;
        return $this;
    }
    //where条件
    public function where($where = array())
    {
        $this->where = $where;
        return $this;
    }
    //order排序
    public function order($order)
    {
        $this->order = $order;
        return $this;
    }
    //查询单条记录
    public function item()
    {
        $item = Db::name($this->table)->field($this->field)->where($this->where)->find();
        return $item ? $item : false;
    }
    //查询多条记录
    public function lists()
    {
        $query = Db::name($this->table)->field($this->field)->where($this->where);
        $this->order && $query = $query->order($this->order);
        $lists = $query->select();
        return $lists ? $lists : false;
    }
    //索引列表
    public function cates($index)
    {
        $query = Db::name($this->table)->field($this->field)->where($this->where);
        $this->order && $query = $query->order($this->order);
        $lists = $query->select();
        $array = array();
        foreach ($lists as $key => $value)
        {
            $array[$value[$index]] = $value;
        }
        return $array ? $array : false;
    }
    //分页
    public function pages($pageSize = 10)
    {
        $total = Db::name($this->table)->where($this->where)->count();
        $query = Db::name($this->table)->field($this->field)->where($this->where);
        $this->order && $query = $query->order($this->order);

        $data = $query->paginate($pageSize, $total);
        return array('total'=>$total, 'lists'=>$data->items(), 'pages'=>$data->render());
    }
    //添加数据
    public function insert($data)
    {
        $rst = Db::name($this->table)->insert($data);
        return $rst ?  $rst : false;
    }
    //更新数据
    public function update($data)
    {
        $rst = Db::name($this->table)->where($this->where)->update($data);
        return $rst ?  $rst : false;
    }
    //删除数据
    public function delete()
    {
        $rst = Db::name($this->table)->where($this->where)->delete();
        return $rst;
    }
}
