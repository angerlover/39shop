<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller {
    /**
     * 从商品详情页添加到购物车
     */
    public function add()
    {
        if(IS_POST)
        {
//            dump($_POST);die;
            $cartModel = D('Home/Cart');
            if($cartModel->create(I('post.'),1))
            {
                if($cartModel->add())
                {
                    $this->success('加入购物车成功',U('lst'));
                    exit;
                }
            }

            $this->error('加入购物车失败，原因：'.$cartModel->getError());
        }
    }

    public function lst()
    {
        dump($_COOKIE);
    }
}