<?php 
// 数据模型对应site，后台菜单对应网站设置
namespace app\admin\controller;

use app\admin\common\controller\Base;

use app\common\model\Site as SiteModel;

use think\facade\Request;

class Site extends Base
{
	// 主页面
	public function index()
	{
		// 获取数据表信息赋值
		$site = SiteModel::get(1);

		// 将变量输出到模板前端
		$this->view->assign('site',$site);

		// 渲染模板
		return $this->view->fetch();
	}

	// 编辑方法
	public function edit()
	{
		// 获取数据表信息赋值
		$site = SiteModel::get(1);

		// 将变量输出到模板前端
		$this->view->assign('site',$site);

		return $this->view->fetch();
	}


	// 编辑保存方法
	public function save()
	{
		// 这个方法不需要返回值
		// 获取提交信息
		$date = Request::param();

		// 以下是数据库静态方法更新，不会增加时间戳
		// 时间字段的自动写入仅针对模型的写入方法，如果使用数据库的更新或者写入方法则无效。
		// SiteModel::where('site_id',1)->update($date);

		// 以下是模型的更新方法，
		// SiteModel::update($data,['site_id' => 1]);


		//更新用户表  以下是模型更新方法，可以增加时间戳
		SiteModel::update($date, ['site_id' => 1]);


	}




}



 ?>