<?php 

namespace app\admin\common\model;

// 引入自建的基础model类
use app\common\model\Base;

// 管理员数据表
class Admins extends Base 
{
	// 设置链接表
	protected $table = "admins";

	// 设置主键
	protected $pk = "ad_id";

	// 设置时间戳
	protected $autoWriteTimestamp = true;

	// 设置创建时间
	protected $createTime = 'create_time';

	// 设置更新时间
	protected $updateTime = 'update_time';

	// 制作管理员角色获取器
	public function getRoleIdAttr($value)
	{
		$status = [1=>'超级管理员',2=>'编辑',3=>'客服'];
        return $status[$value];
	}

	// 制作状态获取器
	public function getStatusAttr($value)
	{
		$status = [0=>'启用',1=>'禁用'];
        return $status[$value];
	}

	





}

 ?>