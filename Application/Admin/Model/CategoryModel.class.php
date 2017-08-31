<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model
{
    protected $insertFields = array('is_floor','cat_name','parent_id');
    protected $updateFields = array('is_floor','id','cat_name','parent_id');
    protected $_validate = array(
        array('cat_name', 'require', '分类名称不能为空！', 1, 'regex', 3),
        array('cat_name', '1,30', '品牌名称的值最长不能超过 30 个字符！', 1, 'length', 3),
    );

    /**
     * 获取指定id的所有分类(多用于删除某一分类)
     */
    function getChildren($catid){

        $data = $this->select();
        return $this->_getChildren($data,$catid,true);
    }

    /**
     * 递归的在指定的data中寻找指定id的所有子类id
     * @param $data 寻找范围（一般是全部表数据）
     * @param $catid 带寻找id
     * @param $isClear 是否要清楚（否则多次查询会一直存到数组中）
     */
      private function _getChildren($data,$catid,$isClear=true){
        static $res = array();// 用于保存id
        // 遍历data范围
        foreach ($data as $k=>$v){
            //若当前数据的parent_id等于catid
            if($v['parent_id']==$catid){
                //存入数组
                $res[] = $v[id];
                // 递归：继续寻找
                $this->_getChildren($data,$v[id],false);
            }
        }
        return $res;

    }

    /**
     * 获取所有分类的树形结构
     */
    function getTree(){
        $data = $this->select();
        return $this->_getTree($data);
    }

    /**
     * 在指定分类内获取树形结构
     * @param $data
     * @param $parent_id
     * @param int $level 当前分类级别
     */
     private function _getTree($data,$parent_id=0,$level=0){
        static $_res = array();//用于储存树形结构id
        foreach ($data as $k => $v){
            if($v['parent_id']==$parent_id){
                // 找到儿子了，记录下id和当前的级别
                $v['level'] = $level;
                $_res[] = $v;
                // 递归继续寻找
                $this->_getTree($data,$v['id'],$level+1);
            }
        }
        return $_res;
    }

    /**
     * 删除分类之前要把子分类删除
     * @param $options
     */
    protected function _before_delete($options) {
        $id = $options['where']['id'];
        // 获取所有的子分类
        $children = $this->getChildren($id);
        // 如果有子分类
        if($children){
            // 删除子分类
            $children = implode(',',$children);
            $model = new \Think\Model();
            $model->table('__CATEGORY__')->delete($children);

        }
    }

    /**
     * 获取前台导航条的数据
     */
    function getNavData()
    {
        // 全部数据
        $all = $this->select();
        // 用于存放的数组
        $navData = array();

        // 遍历找出前三级
        foreach ($all as $k=>$v)
        {
            if($v['parent_id']==0)
            {
                // 一级分类存
                // 继续寻找第二级
                foreach($all as $k1=>$v1)
                {
                    if($v1['parent_id']==$v['id'])
                    {

                        foreach ($all as $k2=>$v2)
                        {
                            if($v2['parent_id']==$v1['id'])
                            {
                                $v1['children'][] = $v2;
                            }
                        }
                        $v['children'][] = $v1;
                        // 继续寻找第三级的
                    }
                }
                // 一级分类入数组
                $navData[] = $v;
            }
        }
        return $navData;
    }

    /**
     * 获取前台首页的楼层数据
     */
    function getFloorData()
    {
        $floorData = S('floorData');
//        if(!$floorData)
//        {
            // 获取推荐到楼层的顶级分类
            $res = array();
            $res = $this->where(array(
                'parent_id' => array('eq',0),
                'is_floor' => array('eq','是'),
            ))
            ->select();
            $goodsModel = D('Admin/Goods');



            // 遍历顶级分类获取当前分类下的推荐商品
            foreach ($res as $k => $v)
            {
                // 获取当前分类下的商品品牌
                $ids = $goodsModel->getIdsByCatId($v['id']);
//                dump($ids);die;
                $res[$k]['brand'] = $goodsModel
                    ->alias('a')
                    ->field('DISTINCT brand_id,b.logo,b.brand_name')
                    ->join('LEFT JOIN __BRAND__ b on a.brand_id = b.id')
                    ->where(array(
                        'a.id'=>array('in',$ids),
                        'a.brand_id'=>array('neq',0), // 品牌id不为0
                    ))->limit(9)->select();
                // 获取未推荐的二级分类(用于楼层左侧的小列表)
                $res[$k]['subCat'] = $this->where(array(
                    'parent_id' => array('eq',$v['id']),
                    'is_floor' => array('eq','否'),
                ))->select();
                // 获取推荐的二级分类
                $res[$k]['recSubCat'] = $this->where(array(
                    'parent_id' => array('eq',$v['id']),
                    'is_floor' => array('eq','是'),
                ))->select();

                // 获取所有推荐二级分类下的商品
                foreach ($res[$k]['recSubCat'] as $k1 => &$v1)
                {
                    // 根据商品模型封装的方法获取这个分类下的所有商品id
                    $goodsIds = $goodsModel->getIdsByCatId($v1['id']);
                     $v1['goods'] =  $goodsModel
                         ->field('goods_name,shop_price,mid_logo,id')
                         ->where(array(
                         'id' => array('in',$goodsIds),
                         'is_on_sale' => array('eq','是'),
                         'is_floor' => array('eq','是'),
                        ))->order('sort_num ASC')
                         ->limit(8)
                         ->select();
                }
            }
            // 缓存一天
            S('floorData',$res,86400);
            return $res;
//        }
//        else
//        {
//            return $floorData;
//        }

    }

    /**
     * 递归获取一个分类的所有先分类
     */
    function parentPath($catId)
    {
        static $res = array();

        $info = $this->field('cat_name,id,parent_id')->find($catId);

        $res[] = $info;

        if($info['parent_id'] > 0)
        {
            $this->parentPath($info['parent_id']);
        }

        return $res;
    }

    /**
     * @param $catId
     * 根据分类id获取前台搜索条件
     */
    function getSearchConditionByCatId($catId)
    {
        $res = array();
        /**********品牌***********/
        $goodsModel = D('Admin/goods');
        // 获取当前分类下的所有商品id
        $ids = $goodsModel->getIdsByCatId($catId);

        $res['brand'] = $goodsModel
            ->alias('a')
            ->field('DISTINCT brand_id,b.brand_name,b.logo')
            ->join('LEFT JOIN __BRAND__ b on a.brand_id = b.id')
            ->where(array(
                'a.id'=>array('in',$ids),
                'a.brand_id'=>array('neq',0), // 品牌id不为0
            ))->select();

        /**********价格***********/
        $sectionCount = 6; // 默认6个区间段
        $priceInfo = $goodsModel->field('MAX(shop_price) max_price,MIN(shop_price) min_price')
            ->where(array(
            'id' => array('in',$ids)
        ))->find();
        // 价格区间
        $priceSection = $priceInfo['max_price'] - $priceInfo['min_price'];
        $goodsCount = count($ids);

        // 根据价格极差计算分几段
        if($goodsCount > 1)
        {
            if($priceSection < 100)
                $sectionCount = 2;
            elseif ($priceSection < 1000)
                $sectionCount = 4;
            elseif ($priceSection < 10000)
                $sectionCount = 6;
            else
                $sectionCount = 7;
        }
        $pricePerSection = ceil($priceSection/$sectionCount);
        $price = array();
        $firstPrice = 0; // 第一个价格段的开始
        for ($i=0;$i<$sectionCount;$i++)
        {
            // 每段的结尾价格
            $_tempEnd = $firstPrice + $pricePerSection;
            // 把段尾价格取整
            $price[] = $firstPrice .'-'.$_tempEnd;

            $firstPrice = $_tempEnd + 1;
        }

        $res['price'] = $price;
        /**********属性***********/
        $gaModel = D('Admin/goods_attr');
        $gaData = $gaModel->alias('a')
            ->field('DISTINCT a.attr_id,a.attr_value,b.attr_name')
            ->join('LEFT JOIN __ATTRIBUTE__ b on a.attr_id = b.id')
            ->where(array(
                'a.goods_id' => array('in',$ids),
                'a.attr_value' => array('neq','')
            ))->select();

        // 二维转三维
        $_gaData = array();
        foreach($gaData as $k=> $v)
        {
            $_gaData[$v['attr_name']][] = $v;
        }

        // 放入
        $res['attr'] = $_gaData;

        return $res;
    }

}