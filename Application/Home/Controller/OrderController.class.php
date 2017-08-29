<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {
    /**
     * 订单确认
     */
    public function add()
    {
        // 检查是否登录
        $m_id = session('m_id');
        if(!$m_id)
        {
            // 没有登录跳到首页,登录后再跳回来
            session('returnUrl',U('Order/add'));
            redirect(U('Member/login'));

        }

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