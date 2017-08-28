<?php
/**
 * Created by PhpStorm.
 * User: pepe
 * Date: 2017/8/27 0027
 * Time: 7:56
 */

namespace Home\Controller;
use Think\Controller;

class NavController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $catModel = D('Admin/Category');
        $navData = $catModel->getNavData();
        $this->assign(
            'navData',$navData
        );
    }
}