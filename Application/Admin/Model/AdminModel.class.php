<?php
namespace Admin\Model;
use Think\Cache\Driver\Redis;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('username','password','cpassword','chkcode');
	protected $updateFields = array('id','username','password','cpassword');
	protected $_validate = array(
		array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
		array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('username', '', '用户名已经存在！', 1, 'unique', 3),
		array('cpassword', 'password', '两次密码必须一致！', 1, 'confirm', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),// 只在添加的时候生效
	);

    // 为登录的表单定义一个验证规则
    public $_login_validate = array(
        array('username', 'require', '用户名不能为空！', 1),
        array('password', 'require', '密码不能为空！', 1),
        array('chkcode', 'require', '验证码不能为空！', 1),
        array('chkcode', 'check_verify', '验证码不正确！', 1, 'callback'),
    );

    /**
     * 验证码
     * @param $code
     * @param string $id
     * @return bool
     */
    function check_verify($code,$id=''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /**
     * 验证登录
     */
    public function login(){
        // 从模型中获取用户名和密码
        $username = $this->username;
        $password = $this->password;
        // 先查询这个用户名是否存在
        $user = $this->where(array(
            'username' => array('eq', $username),
        ))->find();
        if($user)
        {
            if($user['password'] == md5($password))
            {
                // 登录成功存session
                session('id', $user['id']);
                session('username', $user['username']);
                return TRUE;
            }
            else
            {
                $this->error = '密码不正确！';
                return FALSE;
            }
        }
        else
        {
            $this->error = '用户名不存在！';
            return FALSE;
        }

    }
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')
            ->field('a.*,GROUP_CONCAT(c.role_name) role_name')
            ->join('LEFT JOIN __ADMIN_ROLE__ b on a.id = b.admin_id')
            ->join('LEFT JOIN __ROLE__ c on b.role_id = c.id')
            ->where($where)
            ->group('a.id')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	    // 把管理员密码改成加密的形式
        $data['password'] = md5($data['password']);

	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
	    // 如果没有写密码就去掉这个字段
        if($data['password']){
            $data['password'] = md5($data['password']);
        }else{
            unset($data['password']);
        }

        // 处理提交过来的管理员角色信息
        $arModel = D('admin_role');
        $rids = I('post.role_id');
        $arModel->where(array(
            'admin_id'=>array('eq',$option['where']['id']),
        ))->delete();

        foreach ($rids as $v){
            $arModel->add(array(
                'admin_id'=>$option['where']['id'],
                'role_id'=>$v,
            ));
        }

	}
	// 删除前
	protected function _before_delete($option)
	{
        // 超级管理员不能删除
	    if($option['where']['id']==1){
	        $this->error = '超级管理员不能删除';
	        return false;
        }
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	// 插入后
	protected function _after_insert($data, $options) {

        $id = $data['id'];

        // 插入到管理员角色表
        $arModel = D('admin_role');
        $role_id = I('post.role_id');


        foreach ($role_id as $v){
            $arModel->add(array(
                'admin_id'=>$id,
                    'role_id'=>$v,
            )
            );
        }
    }
    /************************************ 其他方法 ********************************************/
    function logout(){
        session(null);
    }
}