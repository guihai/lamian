<?php 
// 前端用户注册控制器
namespace app\index\controller;

use app\common\controller\Base;

// 引入数据模型
use app\common\model\User as UserModel;

// 引入facade\session
use think\facade\Session;

class User extends Base 
{
	// 登陆判断，不登录跳转到登录页,所有的会员管理菜单页都要执行此操作
	protected function ifLogin()
	{
		if (!Session::has('user_id')) { //没有session
			
			$this->error('请先登陆','user/login');
		}
	}





	// 会员中心-菜单-用户中心 
	public function index()
	{
		$this->ifLogin();
		// 渲染模板
		return $this->view->fetch();
	}





	// 会员中心-菜单-我的主页
	public function home()
	{
		$this->ifLogin();
		// 渲染模板
		return $this->view->fetch();
	}

	// 会员中心-菜单-基本设置
	public function set()
	{
		$this->ifLogin();
		// 渲染模板
		return $this->view->fetch();

	}

	// 会员中心-菜单-我的消息
	public function message()
	{
		$this->ifLogin();
		// 渲染模板
		return $this->view->fetch();

	}
////////////////////////////////////////////////////////////////////////////////////////

	// 以下是注册和登陆
	// 防止重复登陆
    public function isLogin()
    {
    	// 如果有了Session 就显示已经登陆，跳转首页
    	if (Session::has('user_id')) {
    		$this->error('您已经登陆','index/index');
    	}

    }


	// 会员注册
	public function reg()
	{
		// 是否登录
		$this->isLogin();
		// 渲染模板
		return $this->view->fetch();
	}

	// 会员注册方法
	public function doreg()
	{

		// halt(UserModel::all());

		// 获取前端数据
		$data = $this->request->post();


		// 搜索邮箱是否存在
		$res = UserModel::where('user_email',trim($data['user_email']))->find();
		// $res = UserModel::where('user_name',trim($data['user_name']))->find();
	

		if ($res) {//搜索结果存在

			exit(json_encode(['code'=>1,'msg'=>'邮箱已存在']));
		}else{
			// 创建用户数据
			$user = UserModel::create([
				'user_email'=> trim($data['user_email']) ,
				'user_name' => trim($data['user_name']) ,
				'password'  => md5(trim($data['password']))
			]);

			// halt($user);


			// 保存session，注意要重新搜索这个数据，才能获得其自动创建字段的默认值
			$sessionuser = UserModel::where('user_email',$user['user_email'])->find();
			// Session::set('name','thinkphp');
			Session::set('user_id',$sessionuser['user_id']);
			Session::set('user_email',$sessionuser['user_email']);
			Session::set('user_name',$sessionuser['user_name']);
			Session::set('user_class',$sessionuser['user_class']);
			Session::set('user_powerid',$sessionuser['user_powerid']);
			Session::set('password',$sessionuser['password']);
			Session::set('create_time',$sessionuser['create_time']);


			// 返回前端

			exit(json_encode(['code'=>2,'msg'=>'恭喜注册成功']));
		}


	}



	// 会员登录
	public function login()
	{
		// 判断是否登录
		$this->isLogin();

		// 渲染模板
		return $this->view->fetch();
	}


	// 执行登录
	public function dologin()
	{

		// 获取登陆信息,采用控制器自带的$this->request，就不用引入facade\Request了
    	$date = $this->request->post();
        // halt($date);

    	// 根据会员邮箱搜索，没有数据名返回账号错误
    	$user = UserModel::where("user_email",trim($date['user_email']))->find();
    	

    	if ($user == false) {

    		exit(json_encode(['code'=>1,'msg'=>'邮箱错误']));
    	}

    	// 匹配密码，密码不对返回密码错误
    	if($user['password'] !== md5(trim($date['password'])) ){

    		exit(json_encode(["code"=>2,"msg"=>'密码错误']));
    	}


    	// 匹配成功保存session
    	Session::set('user_id',$user['user_id']);
		Session::set('user_email',$user['user_email']);
		Session::set('user_name',$user['user_name']);
		Session::set('user_class',$user['user_class']);
		Session::set('user_powerid',$user['user_powerid']);
		Session::set('password',$user['password']);
		Session::set('create_time',$user['create_time']);


    	// 匹配成功，前端执行跳转
    	exit(json_encode(["code"=>3,"msg"=>'登陆成功']));
	}



	// 会员退出登陆，清除Session
    public function loginout()
    {
        // 清除session

        Session::clear();

        // 跳转到登陆页
        $this->success('退出成功','index/index');

    }




}


 ?>