<?php

namespace app\common\model;

use think\Model;
//一个模型单独对应一张表
class User extends Model
{
//    protected $table='';
    //自动写一个时间戳
    protected $autoWriteTimestamp=true;
    public function add($data){
        //只允许写入数据表字段
       return $this->allowField(true)->save($data);
   }

   //查询某一个
    public function queryone($where,$field='uid,nickname,phone,collection'){
        return $this->field($field)->where($where)->find();
    }

    public function collection($where,$data){
        return $this->where($where)->update($data);
    }


}