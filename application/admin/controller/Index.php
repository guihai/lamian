<?php
namespace app\admin\controller;

use app\admin\common\controller\Base;

use think\Db;

use think\facade\Session;

use app\common\model\Site as SiteModel;

class Index extends Base
{

	// 后台首页
    public function index()
    {
        // 判断是否登陆
        $this->ifLogin();
    	// $title = Db::table('site')->where('site_id',1)->find();

    	// $this->view->assign('title',$title['site_name']);
    	$site = SiteModel::get(1);
    	$this->view->assign('site',$site);

        return $this->view->fetch();
    }



    // 欢迎页
    public function welcome()
    {
    	return $this->view->fetch();
    }

    // 退出登陆，清除Session
    public function loginout()
    {
        // 清除session

        Session::clear();

        // 跳转到登陆页
        $this->success('退出成功','login/index');

    }

}



