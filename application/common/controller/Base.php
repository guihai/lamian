<?php 
// 这是前端控制器的基本类
namespace app\common\controller;

use think\Controller;

use think\facade\Session;

// 引入文章分类模型
use app\common\model\Category;

class Base extends Controller 
{
	// 控制器初始化方法，此方法在子类所有方法前执行
	protected function initialize()
	{
		// 必须先继承父类的初始化方法
		parent::initialize();

		// 执行导航方法
		$this->shownav();

		// 在这里，执行登陆判断，这样其他的继承类都会先判断，主要用在后台管理类
		// $this->ifLogin();
	}

	// // 登陆判断，不登录跳转到登录页,所有的后台登陆页都要执行此操作
	// protected function ifLogin()
	// {
	// 	if (!Session::has('user_id')) { //没有session
			
	// 		$this->error('请先登陆','index/index');
	// 	}
	// }

	// 前台页面的头部导航方法，前端头部导航是所有的前端页面都调用的，所以写在最基本的继承类型里
	protected function shownav()
	{
		// 获取文章类型数据，状态为1的正常显示
		$artcate = Category::where("status",1)->order('cate_id', 'asc')->select();

		// 模板变量输出
		$this->view->assign('artcate',$artcate);

	}




}

 ?>