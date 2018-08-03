<?php
namespace app\bis\controller;

use think\Controller;

class Login extends Controller
{
    public function index(){
        if (request()->isPost()){
            $data = input('post.');
            // 用户数据校验
            $ret = model('BisAccount')->get(['username'=>$data['username']]);
            if (!$ret || $ret->status != 1){
                $this->error("该用户不存在,或用户未被审核通过");
            }
            if ($ret->password != md5($data['password'].$ret->code)){
                $this->error('密码不正确');
            }
            model('BisAccount')->updateById(['last_login_time' => time()], $ret->id);
            // 保存用户信息 bis是作用域
            session('bisAccount', $ret, 'bis');
            return $this->success("登录成功",  url("index/index"));
        }else{
            // 获取 session
            $account = session('bisAccount','','bis');
            if ($account && $account->id){
                return $this->redirect(url("index/index"));
            }
            return $this->fetch();
        }
    }

    public function loginout(){
        // 清楚session
        session(null,'bis');
        // 跳转登录页
        return $this->redirect(url("login/index"));
    }
}