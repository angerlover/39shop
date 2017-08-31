<?php
namespace Home\Controller;
class SearchController extends NavController
{
    /**
     *  根据分类的id搜索页面
     */
    function cat_search()
    {
        $catId = I('get.cat_id');
        // 1 获取搜索条件
        $catModel = D('Admin/category');
        $serachByCatCondition = $catModel->getSearchConditionByCatId($catId);
//        dump($serachByCatCondition);die;
        // 2 获取搜索处理的商品数据
        $goodsModel = D('Admin/Goods');
        $data = $goodsModel->cat_search($catId);
//        dump($data);die;
        $this->assign(array(
            'data' => $data, // 搜索数据
            'searchData' => $serachByCatCondition, //搜索条件
            '_page_title'=>'搜索页',
            '_show_nav'=>0,
            '_page_keywords'=>'搜索页',
            '_page_description'=>'搜索页'
        ));
        $this->display();
    }
}