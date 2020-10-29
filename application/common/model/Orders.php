<?php


namespace app\common\model;


use think\Model;

class Orders extends Model
{
    protected $autoWriteTimestamp=true;
    protected $table='orders';

    public function add($data){
        return $this->allowField(true)->isUpdate(false)->save($data);
    }
    public function payorder($where,$data){
        return $this->where($where)->update($data);
    }


}