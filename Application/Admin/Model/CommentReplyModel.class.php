<?php
namespace Admin\Model;
use Think\Cache\Driver\Redis;
use Think\Model;
class CommentReplyModel extends Model
{
    // 提交时允许接收的字段
	protected $insertFields = array('content','comment_id');
	protected $_validate = array(
		array('comment_id', 'require', '参数错误！', 1, 'regex', 3),
		array('content', '1,200', '评论内容在200以内！', 1, 'length'),
	);

	protected function _before_insert(&$data, $options)
    {
        // 判断登录
        $memberId = session('m_id');
        if (!$memberId)
        {
            $this->error='必须先登录!';
            return false;
        }

        // 添加几个必要的字段
        $data['member_id'] = $memberId;
        $data['addtime'] = date('Y-m-d H:i:s');


    }

}