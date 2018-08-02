<?php
namespace app\index\controller;

use think\Config;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        //dump(Config::get('view_replace_str'));
        return $this->fetch();
    }
}
