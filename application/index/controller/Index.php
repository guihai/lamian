<?php
namespace app\index\controller;

use app\common\controller\Base;

// 引入文章model
use app\common\model\Article;

class Index extends Base
{
	// 首页方法
    public function index()
    {

    	// 渲染模板
        return $this->view->fetch();
    }

    
}
