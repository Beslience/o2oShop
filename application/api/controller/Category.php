<?php
namespace app\api\controller;

use think\Controller;

class Category extends Controller
{
    private $obj ;

    public function _initialize(){
        $this->obj = model('Category');
    }

    public function getCategoryByParentId()
    {
        $id = input("post.id", 0 , 'intval');
        if (!$id){
            $this->error("id 不合法");
        }
        $categorys = $this->obj->getNormalCategorysByParentId($id);
        if (!$categorys){
            return show(0, 'err', $categorys);
        }else{
            return show(1, 'success', $categorys);
        }

    }

}
