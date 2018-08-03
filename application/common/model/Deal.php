<?php
namespace app\common\model;

class Deal extends BaseModel
{
    public function getNormalDeals($data = []){
        $data['status'] = 1;
        $order = ['id', 'desc'];
        return $this->where($data)
            ->order($order)
            ->paginate();
    }
}