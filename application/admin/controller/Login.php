<?php
namespace app\admin\controller;

// 引入模型
use app\admin\common\model\Admins;

// 引入Session
use think\facade\Session;


// use app\admin\common\controller\Base;

// 注意，后台管理要引用判断登陆的方法，这个方法不适合登陆页使用，所以这里继承的是基础控制器
use think\Controller;

class Login extends Controller
{
    public function index()
    {
    	// 判断是否登陆
    	$this->isLogin();

        return $this->view->fetch();
    }

    // 登陆验证
    public function check()
    {
    	// 获取登陆信息,采用控制器自带的$this->request，就不用引入facade\Request了
    	$date = $this->request->post();
        // halt($date);

    	// 根据用户名搜索，没有用户名返回账号错误
    	$admins = Admins::where("ad_name",trim($date['ad_name']))->find();
    	// halt($admins);
    	if ($admins==false) {

    		exit(json_encode(['code'=>1,'msg'=>'账号错误']));
    	}

    	// 匹配密码，密码不对返回密码错误
    	if($admins['password'] !== md5(trim($date['password'])) ){

    		exit(json_encode(["code"=>2,"msg"=>'密码错误']));
    	}

    	// 匹配成功保存session
    	Session::set('ad_id',$admins['ad_id']);
    	Session::set('ad_name',$admins['ad_name']);


    	// 匹配成功，前端执行跳转
    	exit(json_encode(["code"=>3,"msg"=>'登陆成功']));

    }

    // 防止重复登陆
    public function isLogin()
    {
    	// 如果有了Session 就显示已经登陆，跳转后台首页
    	if (Session::has('ad_id')) {
    		$this->error('请不要重复登陆','index/index');
    	}

    }

}
