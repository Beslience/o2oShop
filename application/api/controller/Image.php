<?php
namespace app\api\controller;

use think\Controller;
use think\Request;

class Image extends Controller
{
    public function upload(){
        $file = Request::instance()->file('file');
        $info = $file->move('upload');
        dump($info);
        if ($info && $info->getPathname()){
            return show(1, 'success', '/'.$info->getPathname());
        }
        return show(0, 'upload error');
    }
}