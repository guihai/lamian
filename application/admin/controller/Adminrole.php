<?php 
// 管理员角色管理
namespace app\admin\controller;

// // 引入数据表model,管理员数据表
// use app\admin\common\model\Admins as AdminsModel;

// 引入角色数据模型
use app\admin\common\model\Adminrole as AdminroleModel ;

// 引入权限表
use app\admin\common\model\Rolepower ;



// 引入继承类
use app\admin\common\controller\Base ;

class Adminrole extends Base 
{
	// 显示主页
	public function index()
	{
		// 获取数据表内容
		$date = AdminroleModel::all();

		// 数据计数
		$count = count($date);

		// 变量模板输出
		
		$this->view->assign('count',$count);


		// 制作分页
		$datelist = AdminroleModel::paginate(6);

		$this->view->assign('datelist',$datelist);

		// 渲染模板
		return $this->view->fetch();
	}

	// 添加角色显示页
	public function add()
	{
		// 获取权限表赋值
		$power = Rolepower::all();

		$this->view->assign('power',$power);


		// 渲染模板
		return $this->view->fetch();

	}

	// 添加操作
	public function doadd()
	{
		// 获取信息
		$admin_role = $this->request->post();
		// halt($admin_role);

		// 数据库查找是否存在相同名称
		$res = AdminroleModel::where('role_name',$admin_role['role_name'])->find();

		if ($res) {//为真就是存在
			exit(json_encode(['code'=>1,'msg'=>'角色存在请重新填写']));
		}else{
			AdminroleModel::create([
				'role_name' => $admin_role['role_name'],
				'role_text' => $admin_role['role_text'],
				'power_id'  => $admin_role['power_id']
			]);

			exit(json_encode(['code'=>2,'msg'=>'添加成功']));
		}

		
	}



	// 角色编辑
	public function edit()
	{

		// 获取权限表赋值
		$power = Rolepower::all();

		$this->view->assign('power',$power);

		// 获取前端要编辑的数据id
		$role_id = $this->request->param('role_id');


		// 根据id搜索数据，将角色名称和描述传入前端
		$adminrole = AdminroleModel::where('role_id',$role_id)->find();

		$this->view->assign('adminrole',$adminrole);

		// 渲染模板
		return $this->view->fetch();
	}

	// 执行编辑保存
	public function doedit()
	{

		// 获取前端信息
		$admin_role = $this->request->post();

		// 搜索对应的数据表数据
		$res = AdminroleModel::where('role_id',$admin_role['role_id'])->find();

		// 更新数据
		$res->role_name = $admin_role['role_name'];
		$res->role_text = $admin_role['role_text'];
		$res->power_id  = $admin_role['power_id'];
		$adres = $res->save();

		// 前端返回数据
		if ($adres) {
			exit(json_encode(['code'=>1,'msg'=>'保存成功']));
		}else{
			exit(json_encode(['code'=>2,'msg'=>'保存失败']));
		}



	}


	// 删除方法
	public function delete()
	{
		// 接受前端要删除的数据
		$role_id = $this->request->post('role_id');
		// halt($role_id);

		// 根据id查询管理员
		$adminrole = AdminroleModel::where('role_id',$role_id)->find();


		// 超级管理员不能删除
		if ($adminrole['role_name'] == '超级管理员') {
			exit(json_encode(['code'=>1,'msg'=>'超级管理员不能删除']) );
		}else{

			$adminrole->delete();

			exit(json_encode(['code'=>2,'msg'=>'删除成功']) );

		}

	}





}



 ?>