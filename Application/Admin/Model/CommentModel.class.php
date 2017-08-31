<?php
namespace Admin\Model;
use Think\Cache\Driver\Redis;
use Think\Model;
class CommentModel extends Model
{
    // 提交时允许接收的字段
	protected $insertFields = array('goods_id','content','star');
	protected $_validate = array(
		array('goods_id', 'require', '参数错误！', 1, 'regex', 3),
		array('star', '1,2,3,4,5', '只能是1到5的数字！', 1, 'in'),
		array('content', '1,200', '评论内容在200以内！', 1, 'length'),
	);

}