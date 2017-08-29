<?php
namespace Home\Controller;
use Think\Controller;
class MyController extends Controller {

    function __construct()
    {
        parent::__construct();
        $m_id = session('m_id');
        if (!$m_id)
        {
            session('returnUrl',U('My/'.ACTION_NAME));
            redirect(U('Member/login'));
        }
    }

    /**
     * 我的订单
     */
    function order()
    {

        $orderModel = D('Admin/Order');
        $data = $orderModel->search();
//        dump($data);die;
        $this->assign(array(
            'data' => $data,
            '_page_title'=>'我的订单',
            '_show_nav'=>0,
        ));
        $this->display();
    }
}