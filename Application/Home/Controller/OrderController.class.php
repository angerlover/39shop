<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {
    /**
     * 从商品详情页添加到购物车
     */
    public function add()
    {
        if(IS_POST)
        {
//            dump($_POST);die;
            $orderModel = D('Admin/Order');
            if($orderModel->create(I('post.'),1))
            {
                if($id = $orderModel->add())
                {
                    $this->success('下单成功！',U('order_success?id='.$id));
                    exit;
                }
            }

            $this->error('下单失败！，原因：'.$orderModel->getError());
        }


        // 获取购物车数据
        $cartModel = D('Home/cart');
        $data = $cartModel->getCartData();
        $this->assign(array(
            'data' => $data,
            '_page_title'=>'订单确认页',
            '_show_nav'=>0,
            '_page_keywords'=>'订单确认页',
            '_page_description'=>'订单确认页'
        ));

        $this->display();
    }

}