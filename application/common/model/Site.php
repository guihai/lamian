<?php 
// 网站设置模型，前台后台都用
namespace app\common\model;



use app\common\model\Base;

// site表是前后台公用的 所以可以放在common下
class Site extends Base 
{	
	// 匹配数据表
 	protected $table = 'site';

 	// 设置主键
 	protected $pk = 'site_id';

 	// 开启自动时间戳
 	protected $autoWriteTimestamp = true;

 	// 设置更新时间字段
    // protected $createTime = 'create_time';
    protected $updateTime = 'update_time';


}


 ?>