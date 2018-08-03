<?php
namespace app\bis\controller;

class Deal extends Base
{
    // TODO
    public function index(){

        return $this->fetch();
    }

    public function add(){
        $citys = model('City')->getNormalCitysByParentId();
        // 获取一级栏目数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        $bisId = $this->getLoginUser()->bis_id;

        if (request()->isPost()){
            // 校验数据
            $data = input("post.");
            $location = model('BisLocation')->get($data['location_ids'][0]);
            $deals = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' =>  $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',',$data['se_category_id']),
                'city_id' => $data['city_id'],
                'location_ids' => empty($data['location_ids']) ? '' : implode(',',$data['location_ids']),
                'stat_time' => strtotime($data['stat_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => $data['coupons_begin_time'],
                'coupons_end_time' => $data['coupons_end_time'],
                'notes' => $data['notes'],
                'description' => $data['description'],
                'bis_account_id' => $this->getLoginUser()->id,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,
            ];

            $dealId = model('Deal')->add($deals);
            if ($dealId){
                $this->success("添加成功", url("deal/index"));
            }else{
                $this->error("添加失败");
            }
        }else{
            return $this->fetch('',[
                'citys' => $citys,
                'categorys' => $categorys,
                'bisLocations' => model('BisLocation')->getNormalLocationBybBisId($bisId),
            ]);
        }
    }
}

