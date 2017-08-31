<?php
namespace Home\Controller;
use Think\Controller;
class CommentController extends Controller {
    /**
     *  AJAX发表评论（没有视图）
     */
    public function add()
    {
//        $this->error('wrong','',true);die;
        if(IS_POST)
        {
            $Model = D('Admin/Comment');
            if($Model->create(I('post.'),1))
            {
                if($id = $Model->add())
                {
                    $this->success(array(
                        'id' => $id,
                        'face' => session('face'),
                        'username' => session('m_username'),
                        'addtime' => date('Y-m-d H:i:s'),
                        'content' => I('post.content'),
                        'star' => I('post.star'),
                    ),'',true);
                    exit;
                }
            }
            $this->error($Model->getError(),'',true);
        }
    }

}