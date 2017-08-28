<?php
namespace Home\Controller;
class IndexController extends NavController {
    public function index(){

        // 获取首页促销商品数据
        $goodsModel = D('Admin/goods');
        $proData = $goodsModel->getPromoteGoods(5);
        // 获取首页的推荐商品数据
        $newGoods = $goodsModel->getRecGoods('is_new');
        $hotGoods = $goodsModel->getRecGoods('is_hot');
        $bestGoods = $goodsModel->getRecGoods('is_best');
        // 获取首页楼层数据
        $catModel = D('Admin/Category');
        $floorData = $catModel->getFloorData();
//        dump($floorData);die;
        // 设置页面信息
        $this->assign(array(
            'floorData'=>$floorData,
            'newGoods'=>$newGoods,
            'hotGoods'=>$hotGoods,
            'bestGoods'=>$bestGoods,
            'proData'=>$proData,
            '_page_title'=>'京西商城',
            '_show_nav'=>1,
            '_page_keywords'=>'首页',
            '_page_description'=>'首页'
        ));
        $this->display();
    }

    /**
     * 商品详情页
     */
    function goods()
    {
        // 获取商品的全部基本信息
        $id = I('get.id');
        $goodsModel = D('Admin/Goods');
        $info = $goodsModel->find($id);
        // 获取商品的所有属性信息
        $gaModel = D('Admin/goods_attr');
        $gaData = $gaModel->alias('a')
            ->field('a.*,b.attr_name,b.attr_type')
            ->join('LEFT JOIN __ATTRIBUTE__ b on a.attr_id = b.id')
            ->where(array(
                'a.goods_id'=>array('eq',$id),
            ))->select();
//        dump($gaData);die;
        // 获取面包屑导航的数据
        $parentPath = D('Admin/Category')-> parentPath($info['cat_id']);
        $this->assign(array(
            'info' =>$info,
            'parentPath' => $parentPath,
        ));
        // 整理商品属性,把可选属性和唯一属性分开
        $uniAttr = array();
        $mulAttr = array();
        foreach ($gaData as $k => $v)
        {
            if ($v['attr_type']=='唯一')
            {
                $uniAttr[] = $v;
            }
            else
            {
               //把同一个属性放在一起
                $mulAttr[$v['attr_name']][] = $v;
            }
        }
        // 获取商品相册数据
        $gpModel = D('Admin/goods_pic');
        $gpData = $gpModel->where(array(
            'goods_id' => array('eq',$id),
        ))->select();
        $this->assign('gpData',$gpData);
        // 获取商品的会员价格
        $gpModel = D('Admin/member_price');
        $gmpData = $gpModel->alias('a')
            ->field('a.price,b.level_name')
            ->join('LEFT JOIN __MEMBER_LEVEL__ b on a.level_id = b.id')
            ->where(array(
                'a.goods_id' => array('eq',$id),
            ))->select();
        $viewPath = C('IMAGE_CONFIG');
        $this->assign(array(
            'gmpData'=>$gmpData,
            'viewPath' => $viewPath['viewPath'],
            'uniAttr'=>$uniAttr,
            'mulAttr'=>$mulAttr,
            '_page_title'=>$info['goods_name'].'商品详情',
            '_show_nav'=>0,
            '_page_keywords'=>'详情',
            '_page_description'=>'详情'
        ));
        $this->display();

    }

    /**
     * 获取最近浏览的历史
     */
    public function displayHistory()
    {
       // cookie存放的是商品id
        $id = I('get.id');
        // 从cookie中获取数组id
        $data = isset($_COOKIE['displayHistory'])?unserialize($_COOKIE['displayHistory']):array();
        // 把最新的id放到第一位置
        array_unshift($data,$id);
        // 去重
        $data = array_unique($data);
        if(count($data)>6)
        {
            array_slice($data,0,6);
        }
        setcookie('displayHistory', serialize($data), time() + 30 * 86400, '/');
        $goodsModel = D('Admin/Goods');
        $data = implode(',',$data); // 数组转化为字符串
        $viewedData = $goodsModel
            ->field('id,goods_name,sm_logo')
            ->where(array(
                'id'=>array('in',$data),
                'is_on_sale'=>array('eq','是'),
            ))->limit(6)
            ->order("FIELD(id,$data)")
            ->select();

        echo json_encode($viewedData);
    }

    /**
     * ajax获取商品的会员价格
     */
    function ajaxGetMemberPrice()
    {
        $goodsModel = D('Admin/goods');
        $goods_id = I('get.goods_id');
        echo $goodsModel->getMemberPrice($goods_id);
    }
}