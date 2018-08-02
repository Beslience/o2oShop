<?php
namespace app\common\model;

use think\Model;

class Featured extends Model
{
    // 设置在字段中自动加时间
    protected $autoWriteTimestamp = true;

    public function add($data){
        $data['status'] = 1;
        // $data['create_time'] = time();
        $result = $this->save($data);
        return $result;
    }

    public function getNormalFirstCategory(){
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];
        $order = [
            'id' => 'asc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }

    public function getFirstCategorys($parentId = 0){
        $data = [
            'parent_id' => $parentId,
            'status' => ['neq', -1],
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->paginate();
    }

    public function getNormalCategorysByParentId($parentId=0){
        $data = [
            'status' => 1,
            'parent_id' => $parentId,
        ];
        $order = [
            'id' => 'asc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
}