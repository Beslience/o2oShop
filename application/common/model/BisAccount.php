<?php
namespace app\common\model;

class BisAccount extends BaseModel
{
    public function updateById($data, $id){
        return $this->allowField(true)->save($this->data,["id" => $id]);
    }
}