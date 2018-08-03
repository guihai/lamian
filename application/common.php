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
// 自建的公共函数放在这里,成为公共函数，控制器，模板，模型中可以使用



// 创建列表页,文章详情页 根据文章id获取用户名,需要引入用户表
use app\common\model\User;

	// 创建函数，参数就是文章的user_id
    function getArtUse($user_id)
    {
        // 根据user_id在use表中查询use
        $userdate = User::where( "user_id", $user_id)->find();

        // 返回user_name
        return $userdate["user_name"];
    }
      
