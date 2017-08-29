<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller
{
   public function login()
   {
       if (IS_POST)
       {
           $model = D('Admin/Member');
           if($info = $model->validate($model->_login_validate)->create())
           {
               if ($model->login())
               {
                   $returnUrl = U('/'); // 默认跳回首页
                   if(session('returnUrl'))
                   {
                       $returnUrl = session('returnUrl');
                   }
                   $this->success('登录成功！',$returnUrl);
                   exit();
               }
           }
           $this->error($model->getError());
       }
       $this->assign(array(
           '_page_title'=>'登录',
           '_show_nav'=>0,
           '_page_keywords'=>'登录',
           '_page_description'=>'登录'
       ));
       $this->display();
   }
   public function regist()
   {

       if(IS_POST)
       {
           $model = D('Admin/Member');
           if ( $info  = $model->create(I('post.'),1))
           {
               if($model->add())
               {
                   $this->success('注册成功',U('login'));
                   exit();
               }
           }
          $this->error($model->getError());

       }
       $this->assign(array(
           '_page_title'=>'注册',
           '_show_nav'=>0,
           '_page_keywords'=>'注册',
           '_page_description'=>'注册'
       ));
       $this->display();
   }
   public function chkcode()
   {
       $verify = new \Think\Verify(array(
           'fontSize' => 30,
           'length'  =>2,
           'useNoise' =>false,
       ));

       $verify->entry();
   }

    /**
     * ajax判断登录
     */
   function ajaxChkLogin()
   {
       if(session('m_id'))
       {
           echo json_encode(array(
               'login'=>1,
               'username' => session('m_username'),
           ));
       }
       else
       {
           echo json_encode(array(
               'login'=>0,
           ));
       }
   }

    /**
     * 登出
     */
   function logout()
   {
       $MemberModel = D('Admin/Member');
       $MemberModel->logout();
       redirect('/');
   }



}