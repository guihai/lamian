<?php 
// 这是控制器的基本类
namespace app\admin\common\controller;

use think\Controller;

use think\facade\Session;

class Base extends Controller 
{
	// 控制器初始化方法，此方法在子类所有方法前执行
	protected function initialize()
	{
		// 必须先继承父类的初始化方法
		parent::initialize();

		// 在这里，执行登陆判断，这样其他的继承类都会先判断，主要用在后台管理类
		$this->ifLogin();
	}

	// 登陆判断，不登录跳转到登录页,所有的后台登陆页都要执行此操作
	protected function ifLogin()
	{
		if (!Session::has('ad_id')) { //没有session
			
			$this->error('请先登陆','login/index');
		}
	}



}

 ?>