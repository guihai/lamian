<?php 
// 会员数据表模型
namespace app\common\model;

// 引入继承基本类
use app\common\model\Base;

// 引入软删除
use think\model\concern\SoftDelete;

class User extends Base 
{

	// 设置链接表
	protected $table = "user";

	// 设置主键
	protected $pk = "user_id";

	// 设置时间戳
	protected $autoWriteTimestamp = true;

	// 设置创建时间
	protected $createTime = 'create_time';

	// 设置更新时间
	protected $updateTime = 'update_time';

	// // 设置删除时间  添加这个数据会出错
	// use SoftDelete;
 //    protected $deleteTime = 'delete_time';


	



}


 ?>