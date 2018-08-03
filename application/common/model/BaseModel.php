<?php
namespace app\common\model;

use think\Model;

class BaseModel extends Model
{
    // 设置在字段中自动加时间
    protected $autoWriteTimestamp = true;

    public function add($data){
        $data['status'] = 0;
        $this->save($data);
        return $this->id;
    }

}