<?php 
// 文章分类模型，前台后台都要用
namespace app\common\model;


use app\common\model\Base;

// category表是前后台公用的 所以可以放在common下
class Category extends Base 
{	
	// 匹配数据表
 	protected $table = 'category';

 	// 设置主键
 	protected $pk = 'cate_id';

 	// 开启自动时间戳
 	protected $autoWriteTimestamp = true;

 	// 设置创建，更新时间字段
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';


}


 ?>