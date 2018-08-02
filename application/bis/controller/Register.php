<?php
namespace app\bis\controller;
use think\Controller;

class Register extends Controller
{
    public function index(){
        // 获取一级城市数据
        $citys = model('City')->getNormalCitysByParentId();
        // 获取一级栏目数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys
        ]);
    }

    public function add(){
        if (!request()->isPost()){
            $this->error("请求错误");
        }
        $data = input('post.');

        $validate = validate('Bis');
        if (!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }

        // 总店相关信息校验

        // 账号相关信息校验

        // 获取经纬度
        $lnglat = \Map::getLngLat($data['address']);
        if (empty($lnglat) || $lnglat['status'] != 0 || $lnglat['result']['precise'] != 1){
            $this->error('匹配的地址不精准');
        }


    }
}
