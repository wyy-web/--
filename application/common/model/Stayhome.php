<?php


namespace app\common\model;


use think\Model;

class Stayhome extends Model
{
    public function edit($data,$where){
        return $this->allowField(true)->isUpdate(true)->save($data,$where);
    }
    public function queryone($where,$field='*'){
        return $this->field($field)->where($where)->find();
    }
}