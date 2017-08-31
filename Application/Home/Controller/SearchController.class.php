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
        // 1 先获取这个分类下的所有商品id
        $goodsModel = D('Admin/Goods');
        $catModel = D('Admin/category');
        $data = $goodsModel->cat_search($catId);
        $goodsIds = $data['goods_ids'];
        // 2 再获取这些商品的搜索条件
        $serachByCatCondition = $catModel->getSearchConditionByGoodsIds($goodsIds);
//        dump($serachByCatCondition);die;
        // 2 获取搜索处理的商品数据

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

    /**
     * 根据关键字搜索
     */
    function key_search()
    {
        $key = I('get.key');
        $goodsModel = D('Admin/Goods');
        $catModel = D('Admin/category');
        $data = $goodsModel->key_search($key);
        $serachByCatCondition = $catModel->getSearchConditionByGoodsIds($data['goods_id']);
        $this->assign(array(
            'data' => $data, // 搜索数据
            'searchData' => $serachByCatCondition, //搜索条件
            '_page_title'=>'关键字搜索页',
            '_show_nav'=>0,
            '_page_keywords'=>'搜索页',
            '_page_description'=>'搜索页'
        ));
        $this->display();

    }
}