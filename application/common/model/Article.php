<?php 
// 文章模型，前台后台都要用
namespace app\common\model;


use app\common\model\Base;

// article表是前后台公用的 所以可以放在common下
class Article extends Base 
{	
	// 匹配数据表
 	protected $table = 'article';

 	// 设置主键
 	protected $pk = 'art_id';

 	// 开启自动时间戳
 	protected $autoWriteTimestamp = true;

 	// 设置创建，更新时间字段
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 设置文章状态分类获取器
	public function getArtrecttr($value)
	{
		// $artrec = [ 0=>'分享', 1=>'热点', 2=>'推荐'];
		$status = [0=>'分享',1=>'热点',2=>'推荐'];
        return $status[$value];
	}


}


 ?>