<?php
namespace app\common\model;
class BisLocation extends BaseModel
{

    public function getNormalLocationBybBisId($bisId){
        $data = [
            'status' => 1,
            'bis_id' => $bisId,
        ];
        return $this->where($data)
            ->order('id', 'desc')
            ->select();
    }


}