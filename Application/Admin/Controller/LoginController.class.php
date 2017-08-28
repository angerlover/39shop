<?php
/**
 * Created by PhpStorm.
 * User: pepe
 * Date: 2017/8/22 0022
 * Time: 10:53
 */
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{

    function login() {

        if (IS_POST) {
            $adminModel = D('admin');
            if ($adminModel->validate($adminModel->_login_validate)->create()) {
                if($adminModel->login()){
                    $this->success('登录成功',U('Index/index') );
                    exit;
                }
            }
            else {
                $this->error('登录失败！失败原因:'.$adminModel->getError());
            }
        }
        $this->display();
    }

    function chcode(){

        $verify = new \Think\Verify(array(
            'fontSize' => 30,
            'length'  =>2,
            'useNoise' =>false,
        ));

        $verify->entry();
    }

    function logout(){
        $adminModel = D('admin');
        $adminModel->logout();
        session(null);
        redirect('login');
    }
}