<?php
namespace app\admin\controller;

use think\Controller;

class Bis extends Controller
{
    private $obj ;

    public function _initialize(){
        $this->obj = model('Bis');
    }

    /**
     * 入驻申请列表
     * @return mixed
     */
    public function apply()
    {
        $bis = $this->obj->getBisByStatus();
        return $this->fetch('',[
            "bis" => $bis,
        ]);
    }

    /**
     * 正常的商户列表
     * @return mixed
     */
    public function index(){
        $bis = $this->obj->getBisByStatus(1);
        return $this->fetch('', [
            'bis' => $bis,
        ]);
    }

    public function detail(){
        $id = input("get.id");
        if (empty($id)){
            return $this->error("id错误");
        }
        // 获取一级城市数据
        $citys = model('City')->getNormalCitysByParentId();
        // 获取一级栏目数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        // 获取商户数据
        $bisData = model("Bis")->get($id);
        $locationData = model("BisLocation")->get(["bis_id" => $id, "is_main" => 1]);
        $accountData = model('BisAccount')->get(["bis_id" => $id, "is_main" => 1]);
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'bisData' => $bisData,
            "locationData" => $locationData,
            "accountData" => $accountData,
        ]);
    }

    public function status(){
        $data = input('get.');
        /*$validate = validate('Bis');
        if (!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }*/
        $res = $this->obj->save(['status' => $data['status']], ['id' => $data['id']]);
        $location = model("BisLocation")->save(['status' => $data['status']], ['bis_id' => $data['id'], "is_main" => 1]);
        $account = model("BisAccount")->save(['status' => $data['status']], ['bis_id' => $data['id'], "is_main" => 1]);
        if ($res && $location && $account){
            // 发送邮件
            // status 1 通过 2 不通过 -1 删除
            $this->success('状态更新成功');
        }else{
            $this->error('状态更新失败');
        }
    }

    private function update($data){
        $res = $this->obj->save($data,['id' => intval($data['id'])]);
        if ($res){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }
}
