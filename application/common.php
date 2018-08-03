<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * @param $url
 * @param int $type 0 get 1 post
 * @param array $data
 * @return mixed
 */
function doCurl($url, $type=0, $data=[]){
    $ch = curl_init(); // 初始化
    // 设置
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0); // 不需要输出头
    if ($type == 1){
        // post
        curl_setopt($ch, CURLOPT_PORT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    // 执行并获取内容
    $output = curl_exec($ch);
    // 释放curl句柄
    curl_close($ch);
    return $output;
}

// 商户入驻申请模块
function bisRegister($status){
    if ($status == 1){
        $str = "入驻申请成功";
    }elseif($status == 0){
        $str = "待审核,审核后平台方会发送邮件通知，请关注邮件";
    }elseif($status == 2){
        $str = "非常抱歉，您提交的材料不符合条件,请重新提交";
    }else{
        $str = "该申请已被删除";
    }
    return $str;
}

/**
 * 使用通用分页
 * @param $obj
 * @return string
 */
function pagination($obj){
    if (!$obj){
        return "";
    }
    return "<div class=\"cl pd-5 bg-1 bk-gray mt-20\">". $obj->render() ."</div>";
}

function getSeCityName($path){
    if (empty($path)){
        return "";
    }
    if (preg_match_all('/,/',$path)){
        $cityPath = explode("," , $path);
        $cityId = $cityPath[1];
    }else{
        $cityId = $path;
    }
    $city = model('City')->get($cityId);
    return $city->name;
}