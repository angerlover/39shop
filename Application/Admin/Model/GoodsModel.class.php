<?php
/**
 * Created by PhpStorm.
 * User: pepe
 * Date: 2017/8/2 0002
 * Time: 10:27
 */
namespace Admin\Model;
use Think\Model;

class GoodsModel extends Model {

    // 允许添加使用的字段
    protected $insertFields = 'is_floor,sort_num,promote_price,promote_start_date,promote_end_date,is_new,is_hot,is_best,type_id,brand_id,goods_name,market_price,shop_price,is_on_sale,goods_desc,cat_id';
    // 允许修改的字段
    protected $updateFields = 'type_id,is_floor,sort_num,promote_price,promote_start_date,promote_end_date,is_new,is_hot,is_best,brand_id,id,goods_name,market_price,shop_price,is_on_sale,goods_desc,cat_id';


    // 验证规则
    protected $_validate = array(

        array('goods_name', 'require', '商品名字不能为空'),
        array('cat_id', 'require', '分类不能为空'),
        array('market_price', 'require', '市场价格不能为空'),
        array('market_price', 'currency', '市场价格必须是货币'),
        array('shop_price', 'require', '本店价格不能为空'),
        array('shop_price', 'currency', '本店价格必须是货币'),
        array('is_on_sale', 'require', '是否上架不能为空')

    );

    /**
     * 钩子函数 这里主要处理图片的上传
     * @param $data
     * @param $options
     */
    function _before_insert(&$data, $options) {

        // 处理图片
        if ($_FILES['logo']['error'] == 0) {

            $res = uploadOne('logo', 'Goods', array(
                array(700, 700),
                array(350, 350),
                array(130, 130),
                array(50, 50)
            ));

            // 最后千万别忘了把各种图片的路径写入数组
            $data['logo'] = $res['images'][0];
            $data['sm_logo'] = $res['images'][4];
            $data['mid_logo'] = $res['images'][3];
            $data['big_logo'] = $res['images'][2];
            $data['mbig_logo'] = $res['images'][1];

        }

        // 添加时间
        $data['addtime'] = date('Y-m-d H:i:s', time());
        // 去除goods_desc
        $data['goods_desc'] = removeXSS($_POST['goods_desc']);


    }

    /**
     * @param $data
     * @param $options
     * 修改之前
     */
    function _before_update(&$data, $options) {
        // 获取id
        $id = $options['where']['id'];
        // 修改扩展分类
        // 对会员价格的修改
        $catIds = I('post.ext_cat_id');
        $gcModel = D('goods_cat');
        // 根据id删除原来的扩展分类
        $gcModel->where(array(
            'goods_id' => array('eq', $id),
        ))->delete();

        if($catIds)
        {
            foreach ($catIds as $k => $v)
            {
                if(empty($v))
                    continue ;
                $gcModel->add(array(
                    'cat_id' => $v,
                    'goods_id' => $id,
                ));
            }
        }
        // 处理logo
        if ($_FILES['logo']['error'] == 0) {
            $res = uploadOne('logo', 'Goods', array(
                array(700, 700),
                array(350, 350),
                array(130, 130),
                array(50, 50),
            ));

            // 最后千万别忘了把各种图片的路径写入数组
            $data['logo'] = $res['images'][0];
            $data['mbig_logo'] = $res['images'][1];
            $data['big_logo'] = $res['images'][2];
            $data['mid_logo'] = $res['images'][3];
            $data['sm_logo'] = $res['images'][4];

            // 把原来的图从硬盘删除删除
            $info = $this->field('logo,sm_logo,mid_logo,big_logo,mbig_logo')->find($id);
            deleteImage($info);
        }
        // 对会员价格的修改
        $mp = I('post.member_price');
//        dump($mp);die;
        $mpModel = D('member_price');
// 根据id删除原来的会员价格
//        $mpModel->where("goods_id = $data[id]")->delete();
        $mpModel->where(array(
            'goods_id' => array('eq', $id),
        ))->delete();
        foreach ($mp as $k => $v) {
            // 判断去除不合理的数字
            $_v = (float)$v;
            if ($_v > 0) {
                $mpModel->add(array(
                        'price' => $v,
                        'level_id' => $k,
                        'goods_id' => $id,
                    )
                );
            }

        }
        // 图片相册
        if (isset($_FILES)) {
            $pics = array(); // 待生成的数组(传了几张图里面就有几个元素，当然是二维的)
            foreach ($_FILES['pic']['name'] as $k => $v) { // 其实这里面选择name type什么亦可
                $pics[] = array(
                    'name' => $v,
                    'type' => $_FILES['pic']['type'][$k],
                    'tmp_name' => $_FILES['pic']['tmp_name'][$k],
                    'error' => $_FILES['pic']['error'][$k],
                    'size' => $_FILES['pic']['size'][$k],
                );
            }

//            dump($pics);die; // 测试
            $_FILES = $pics; // uplodeOne函数是利用$_FIELS来上传的
            // 模型
            $gpModel = D('goods_pic');
            // 循环遍历上传
            foreach ($pics as $k => $v) {
                if ($v['error'] == 0) {
                    $res = uploadOne($k, 'Goods', array(
                        array(650, 650),
                        array(350, 350),
                        array(50, 50),

                    ));

                    // 判断是否上传成功
                    if ($res['ok'] == 1) {
                        $gpModel->add(array(
                                'pic' => $res['images'][0],
                                'big_pic' => $res['images'][1],
                                'mid_pic' => $res['images'][2],
                                'sm_pic' => $res['images'][3],
                                'goods_id' => $id
                            )
                        );
                    }
                }

            }
        }

        // 处理商品属性
        $gaModel = D('goods_attr');
        $gaid = I('post.goods_attr_id'); // 商品属性表
        $attrValue = I('post.attr_value');
        $_i = 0;
        foreach ($attrValue as $k => $v){

            foreach($v as $k1=>$v1){

//                $res = $gaModel->execute("replace into p39_goods_attr
//                values($gaid[$_i],$id,$k,$v1)
//
//              ");
                if($gaid[$_i] == ''){ // 添加的情况
//                    dump($k);die;
                    if ($v1!='')
                    {
                        $gaModel->add(array(
                            'goods_id'=>$id,
                            'attr_id'=>$k,
                            'attr_value'=>$v1,
                        ));
                    }

                }else{ // 修改的情况
                    $gaModel->where(array(
                        'id'=>array('eq',$gaid[$_i])
                    ))->setField('attr_value',$v1);

                }
                // 这个$_i的位置！！！！！！！！！！！！！！！！！！！！！！！！！！！
                $_i++;
            }
        }

        // 自己过滤描述中的字段
        $data['goods_desc'] = removeXSS($data['goods_desc']);
    }

    /**
     * @param $options
     * 删除之前的钩子
     */
    function _before_delete($options) {

        $id = $options['where']['id'];
        // 删除商品库存！
        $gnModel = D('goods_number');
        $gnModel->where(array(
            'goods_id'=>array('eq',$id),
        ))->delete();
        // 删除商品属性
        D('goods_attr')->where(array(
            'goods_id'=>array('eq',$id)
        ))->delete();
        // 删除扩展分类
        D('goods_cat')->where(array(
            'goods_id'=>array('eq',$id)
        ))->delete();

        // 删除五个logo
        $info = $this->field('logo,sm_logo,mid_logo,big_logo,mbig_logo')->find($id);
        deleteImage($info);

        // 删除会员价格
        $mpModel = D('member_price');
        $mpModel->where(  // 根据id删除会员价格
            array(
                'goods_id' => array('eq',$id)
            )
        )->delete();
        // 删除相册
        $pic_info = D('goods_pic')->field('pic,sm_pic,mid_pic,big_pic')->where(array(
            'goods_id' => array('eq', $id),
        ))->select();
        // 相册硬盘删除
        foreach ($pic_info as $k=>$v){
            deleteImage($v);
        }
        // 相册数据库删除
        D('goods_pic')->where(array('goods_id'=>array('eq',$id)))->delete();
    }

    /**
     * 搜索 分页 排序
     */
    function search($perPage = 20){
        //1 搜索
        $where = array(); // 1.1搜索条件数组


        // 1.2判断搜索的条件
        // 品牌
        $bid = I('get.brand_id');
        if($bid){
            $where['a.brand_id'] = array('eq',$bid);
        }
        $gn = I('get.gn');
        if ($gn){ // 1.2.1商品名称
            $where['a.goods_name'] = array('like',"%$gn%");
        }
        //1.2.2 价格
        $fp = I('get.fp');
        $tp = I('get.tp');
        if ($fp && $tp){
            $where['a.shop_price'] = array('between',array($fp,$tp));
        }elseif($fp){
            $where['a.shop_price'] = array('egt',$fp);
        }elseif($tp){
            $where['a.shop_price'] = array('elt',$tp);
        }

        // 1.2.3 是否上架
        $ios = I('get.ios');
        if($ios){
            $where['a.is_on_sale'] = array('eq',$ios); // where is_on_sale = ''
        }

        // 1.2.4 添加时间
        $ft = I('ft');
        $tt = I('tt');
        if ($ft && $tt){
            $where['a.addtime'] = array('between',array($ft,$tt));
        }elseif($ft){
            $where['a.addtime'] = array('egt',$ft);
        }elseif($tt){
            $where['a.addtime'] = array('elt',$tt);
        }
        // 商品分类
        $catid = I('get.catid');
        if ($catid){
           $ids = $this->getIdsByCatId($catid);
           $where['a.id'] = array('in',$ids);
        }

        //2 排序
        $orderBy = 'a.id'; //默认排序字段
        $orderWay = 'desc';
        $odby = I('get.odby');

        if($odby){
            if($odby == 'id_asc'){
                $orderWay = 'asc';
            }elseif($odby == 'p_desc'){
                $orderBy = 'a.shop_price';
            }elseif($odby == 'p_asc'){
                $orderBy = 'a.shop_price';
                $orderWay = 'asc';
            }
        }

        //2 分页
        // 获取所有记录条数
        $cnt = $this->where($where)->count();
        // 实例化分页对象
        $page = new \Think\Page($cnt,$perPage);
        // 美化分页
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        // 上一页下一页的效果
        $pageString = $page->show();



        // 返回数据
        $data = $this->order("$orderBy $orderWay")
            ->field('a.*,b.brand_name,c.cat_name,GROUP_CONCAT(e.cat_name SEPARATOR "<br/>") ext_cat_name')
            ->alias('a')
            ->join('LEFT JOIN __BRAND__ b on a.brand_id = b.id
                    LEFT JOIN __CATEGORY__ c on a.cat_id = c.id
                    LEFT JOIN __GOODS_CAT__ d on a.id = d.goods_id
                    LEFT JOIN __CATEGORY__ e on d.cat_id = e.id
                    ')
            ->where($where)
            ->limit($page->firstRow.','.$page->listRows)
            ->group('a.id')
            ->select();

        return array(
            'data' => $data,
            'pageString' => $pageString,

        );
    }

    /**
     * @param $data
     * @param $options
     * 插入之后的操作 获得商品id然后插入到会员价格中
     */
    function _after_insert($data, $options) {

        // 处理商品属性
        $attrValue = I('post.attr_value');
//        dump($attrValue);die;
        $gaModel = D('goods_attr'); // 商品模型
        foreach ($attrValue as $k => $v){
             // 去重
                $v = array_unique($v);
                 // 属性没填的就不要入库了
                    foreach($v as $k1 => $v1) {
                        if ($v1 != '') {
                        $gaModel->add(array(
                            'goods_id' => $data['id'],
                            'attr_id' => $k,
                            'attr_value' => $v1,
                        ));
                    }
                    }

        }

        // 扩展分类
        $extCatModel = D('goods_cat');
        $extCatData = I('post.ext_cat_id');
        // 插入
        if ($extCatData){ // 判断有没有
            foreach ($extCatData as $k=>$v){
                if(empty($v)){ // 如果没选择 跳过
                    continue;
                }
                $extCatModel->add(array(
                    'goods_id'=>$data['id'],
                    'cat_id'=>$v
                ));
            }

        }



        // 获取商品id插入到会员价格中
        $mp = I('post.member_price');
        $mpModel = D('member_price');
        foreach ($mp as $k=>$v){

            // 判断去除不合理的数字
            $_v = (float)$v;
            if ($_v > 0){
                $mpModel->add(array(
                        'price'=>$v,
                        'level_id'=>$k,
                        'goods_id'=>$data['id'],
                    )
                );
            }

        }

        // 同样利用id插入到商品相册表中

        // 处理表单提交的相册
        $pics = array(); // 待生成的数组(传了几张图里面就有几个元素，当然是二维的)
        foreach ($_FILES['pic']['name'] as $k=>$v){ // 其实这里面选择name type什么亦可
            $pics[] = array(
                'name' => $v,
                'type' => $_FILES['pic']['type'][$k],
                'tmp_name' => $_FILES['pic']['tmp_name'][$k],
                'error' => $_FILES['pic']['error'][$k],
                'size' => $_FILES['pic']['size'][$k],
            );
        }

//            dump($pics);die; // 测试
        $_FILES = $pics; // uplodeOne函数是利用$_FIELS来上传的
        // 模型
        $gpModel = D('goods_pic');
        // 循环遍历上传
        foreach ($pics as $k => $v){
                if ($v['error']==0){
                    $res = uploadOne($k,'Goods',array(
                        array(650,650),
                        array(350,350),
                        array(50,50),

                    ));

                    // 判断是否上传成功
                    if ($res['ok'] == 1){
                        $gpModel->add(array(
                                'pic' => $res['images'][0],
                                'big_pic' => $res['images'][1],
                                'mid_pic' => $res['images'][2],
                                'sm_pic' => $res['images'][3],
                                'goods_id' => $data['id']
                            )
                        );
                    }
                }

        }



    }
    /*
     * 根据分类id查找包括主分类和扩展分类的商品id
     */
    function getIdsByCatId($catId){

        // 1主分类
        // 1.1 还要获取所有当前id子分类，也要一并搜索出来
        $children = D('Admin/category')->getChildren($catId);
        $children[] = $catId; // 把当前id也一起装进去

        // 1.2 查询
        $gids = $this->field('id')->where(array(
            'cat_id'=>array('in',$children),
        ))->select();


        // 2扩展分类
        // 2.1 获取当前扩展分类的所有商品id
       $gcModel = D('goods_cat');
        $eids = $gcModel->field('DISTINCT goods_id id')->where(array(// 这里把goods_id变为id是为了合并数组的时候方便
            'cat_id'=>array('in',$children)
        ))->select();


        // 1和2合并起来
        // 判断
        if($gids&& $eids){
            $gids = array_merge($gids,$eids);
        }elseif ($eids){
            $gids = $eids;
        }

        // 二维变一维
        $ids = array();
        foreach ($gids as $k=>$v){
            $ids[] = $v['id'];
        }

        return $ids;
    }

    /**
     * 获取当前正在促销的商品
     * @param int $limit
     */
    function getPromoteGoods($limit = 5)
    {
        $today = date("Y-m-d H:i");
        return $this->field('id,promote_price,goods_name,mid_logo')
            ->where(array(
                'is_on_sale'=>array('eq','是'),
                'promote_price'=>array('gt',0),
                'promote_start_date'=>array('elt',$today),
                'promote_end_date'=>array('egt',$today),
            ))->limit($limit)
            ->order('sort_num ASC')
            ->select();

    }

    /**
     * @param $type
     * @param int $limit
     * 获取推荐商品（新品，精品，热卖）
     */
    function getRecGoods($type,$limit=5)
    {
        return $this->field('id,shop_price,goods_name,mid_logo')
            ->where(array(
                'is_on_sale' =>array('eq','是'),
                $type=>array('eq','是')
            ))->limit($limit)
            ->order('sort_num ASC')
            ->select();
    }

    /**
     * 获取当面会员的价格
     */
    function getMemberPrice($goods_id)
    {
        // 获取会员级别id
        $level_id = session('level_id');

        // 额外考虑当前的促销价格 如果促销价格比本店价低 则返回促销价格
        $today = date('Y-m-d H:i');
        $promotePrice = $this->field('promote_price')
            ->where(array(
                'promote_start_date'=>array('elt',$today),
                'promote_end_date'=>array('egt',$today),
                'id' =>array('eq',$goods_id),
            ))->find();
        // 如果登录返回会员价格
        if ($level_id)
        {
            // 从会员价格表获取当前会员的价格
            $mpModel = D('Admin/member_price');
            $mpPrice = $mpModel->field('price')->where(array(
                'level_id' => array('eq',$level_id),
                'goods_id' => array('eq',$goods_id),
            ))->find();
            // 如果确实有设置当前会员价格
            if ($mpPrice['price'])
            {
                if($promotePrice['promote_price'])
                    return min($mpPrice['price'],$promotePrice['promote_price']);
                else
                    return $mpPrice['price'];
            }
            else
            {

                $shop_price = $this->field('shop_price')->find($goods_id);

                if($promotePrice['promote_price'])
                    return min($shop_price['shop_price'],$promotePrice['promote_price']);
                else
                    return $shop_price['shop_price'];
            }
        }
        else // 没有登录返回本店价
        {

            $shop_price = $this->field('shop_price')->find($goods_id);
            if($promotePrice['promote_price'])
                return min($shop_price['shop_price'],$promotePrice['promote_price']);
            else
                return $shop_price['shop_price'];
        }

    }
}