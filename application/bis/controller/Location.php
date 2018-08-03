<?php
namespace app\bis\controller;

class Location extends Base
{
    //TODO 完成列表页
    public function index(){

        return $this->fetch();
    }

    public function add(){
        $citys = model('City')->getNormalCitysByParentId();
        // 获取一级栏目数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        if (request()->isPost()){
            // 校验数据
            $data = input("post.");
            $bisId = $this->getLoginUser()->bis_id;
            // 入库操作
            //  商户信息入库

            // 获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            if (empty($lnglat) || $lnglat['status'] != 0 || $lnglat['result']['precise'] != 1){
                $this->error('匹配的地址不精准');
            }

            $data['cat'] = '';
            if (!empty($data['se_category_id'])){
                $data['cat'] = implode('|',$data['se_category_id']);
            }
            // 总店相关信息入库
            $locationData = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'] . "," .$data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'] . "," .$data['se_city_id'],
                'address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content']) ? "" : $data['content'],
                'is_main' => 0, // 代表的是总店信息
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' :$lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' :$lnglat['result']['location']['lat'],
            ];
            $locationId = model('BisLocation')->add($locationData);
            if ($locationId){
                return $this->success("门店申请成功");
            }
        }else{
            return $this->fetch('',[
                'citys' => $citys,
                'categorys' => $categorys
            ]);
        }
    }
}

