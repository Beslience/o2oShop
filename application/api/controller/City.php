<?php
namespace app\api\controller;

use think\Controller;

class City extends Controller
{
    private $obj ;

    public function _initialize(){
        $this->obj = model('City');
    }

    public function getCityByParentId()
    {
        $id = input("post.id");
        if (!$id){
            $this->error("id 不合法");
        }
        $citys = $this->obj->getNormalCitysByParentId($id);
        if (!$citys){
            return show(0, 'err', $citys);
        }else{
            return show(1, 'success', $citys);
        }

    }

}
