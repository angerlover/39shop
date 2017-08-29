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

    /**
     * 购物车页面
     */
    public function lst()
    {

        // 获取购物车数据
        $cartModel = D('Home/cart');
        $data = $cartModel->getCartData();
//        dump($data);die;
        $this->assign(array(
            'data' => $data,
            '_page_title'=>'购物车',
            '_show_nav'=>0,
            '_page_keywords'=>'详情',
            '_page_description'=>'详情'
        ));

        $this->display();

    }

    public function ajaxGetCart()
    {
        // 获取购物车数据
        $cartModel = D('Home/cart');
        $data = $cartModel->getCartData();

        echo json_encode($data);

    }
}