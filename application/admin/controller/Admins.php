<?php 
// 管理员管理

namespace app\admin\controller;

// 引入数据表model,管理员数据表
use app\admin\common\model\Admins as AdminsModel;

// 引入角色数据模型
use app\admin\common\model\Adminrole ;

// 引入继承类
use app\admin\common\controller\Base ;




class Admins extends Base 
{
	// 首页方法
	public function index()
	{
		// 获取数据表数据
		// $data = AdminsModel::all();
		// halt($data);
		// 变量模板输出
		// $this->view->assign('data',$data);

		// 计数总数据
		$count = count(AdminsModel::all()) ;
		// 计数输出到模板
		$this->view->assign('count',$count);

		// 包含分页的样式
		// 这个方法制作数据分页比较快 Model::paginate(参数),获取所有模型数据，并制作分页，参数是显示数字


		$datalist = AdminsModel::paginate(5);
		// halt($datalist);

		// 变量模板输出
		$this->view->assign('datalist',$datalist);

		// 渲染模板
		return $this->view->fetch();

	}



	// 添加管理员显示页
	public function add()
	{

		// 前端角色要做单选，从数据表adminrole引入数据 
		// $rolename = Adminrole::all()->column('role_name');

		$adminrole = Adminrole::all();
		// halt($adminrole);

		// 模板输出变量
		$this->view->assign('adminrole',$adminrole);

		// 渲染模板
		return $this->view->fetch();
	}

	// 管理员添加保存
	public function doadd()
	{
		// 获取前端数据
		$data = $this->request->post();
		// halt($data);

		// 查找用户名是否存在，用户名存在不能添加
		$res = AdminsModel::where( "ad_name" , $data["ad_name"])->find();

		if ($res) { //res存在就是真
			exit(json_encode(['code'=>1,'msg'=>'用户名存在，请重新填写']));
		}

		// 用户名不存在，添加数据，返回成功
		AdminsModel::create([
			'ad_name'  => $data['ad_name'],
			'password' => md5(trim($data['password'])),
			'truename' => $data['truename'],
			'role_id'  => $data['role_id']

		]);

		exit(json_encode(['code'=>2,'msg'=>'增加成功']));

	}

	// 管理员列表——操作——编辑
	public function edit()
	{
		// 获取管理员分组
		$adminrole = Adminrole::all();
		// halt($adminrole);

		// 模板输出变量
		$this->view->assign('adminrole',$adminrole);


		// 获取前端url('方法'，[name=>val])，传入的值
		$ad_id = $this->request->param('ad_id');
		// halt($ad_id);

		// 根据获取的id值查找数据
		$admin = AdminsModel::where('ad_id',$ad_id)->find();

		// 模板变量输出
		$this->view->assign('admin',$admin);


		// 渲染模板
		return $this->view->fetch();
	}

	// 保存修改
	public function doedit()
	{
		// 获取前端数据
		$data = $this->request->post();
		// halt($data);

		// 获取数据表对应数据
		$res = AdminsModel::where( "ad_name" , $data["ad_name"])->find();

		// 更新数据
		$res->truename = $data['truename'];
		$res->role_id  = $data['role_id'];
		$res->password = md5(trim($data['password']));
		$adres = $res->save();

		if ($adres) {
			exit(json_encode(['code'=>1,'msg'=>'保存成功']));
		}else{
			exit(json_encode(['code'=>2,'msg'=>'保存失败']));
		}

	}

	// 管理员删除
	public function delete()
	{
		// 接受前端要删除的数据
		$ad_id = $this->request->post('ad_id');
		// halt($ad_id);

		// 根据id查询管理员
		$admins = AdminsModel::where('ad_id',$ad_id)->find();
		// halt($admins);

		// 管理员不能删除
		if ($admins['ad_name'] == 'admin') {
			exit(json_encode(['code'=>1,'msg'=>'admin不能删除']) );
		}else{

			$admins->delete();

			exit(json_encode(['code'=>2,'msg'=>'删除成功']) );

		}


		// 根据数据查询结果，进行删除
	}
	





}
 ?>