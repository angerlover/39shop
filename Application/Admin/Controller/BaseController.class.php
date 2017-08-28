<?php
/**
 * Created by PhpStorm.
 * User: pepe
 * Date: 2017/8/22 0022
 * Time: 15:37
 */
namespace Admin\Controller;
use Think\Controller;

class BaseController extends Controller{


    function __construct() {
        parent::__construct();

        if(!session('id')) {
            $this->error('必须先登录!',U('Login/login'));
        }
        // 所有管理员都可以进后台首页
        if(CONTROLLER_NAME == 'Index'){
            return true;
        }

        $priModel = D('privilege');
        if(!$priModel->chkpri()){
            $this->error('无权访问！');
        }
    }
}