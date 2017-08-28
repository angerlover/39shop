<?php
/**
 * Created by PhpStorm.
 * User: pepe
 * Date: 2017/7/23 0023
 * Time: 16:33
 */

namespace Admin\Controller;
use Admin\Model\AttributeModel;

class GoodsController extends BaseController{
    /**
     * 商品库存
     */
    function goods_number(){
        $id = I('get.id');
        $gnModel = D('goods_number');
        if (IS_POST){

            // 修改的时候先删除再添加，所以添加和修改直接一律先删除一遍，再添加
            $gnModel->where(array(
                'goods_id'=>array('eq',$id),
            ))->delete();
            $data = I('post.');
//            dump($data);die;
            //处理表单插入到goods_number表中
            $goods_attr_id = I('post.attr_value');
            $goods_number = I('post.goods_number');
//            dump($goods_attr_id);dump($goods_number);die;
            // 如果这件商品有属性值 则常规添加
            if($goods_attr_id)
            {
                // 计算一下属性id值和库存量的比例
                $rate = count($goods_attr_id)/count($goods_number);
                // 遍历短的
                foreach ($goods_number as $k => $v){
                    $index = array($rate*$k);
                    for($i=1;$i<$rate;$i++)
                    {
                        $index[$i] = $index[$i-1] + 1;
                    }

                    $value = array_slice($goods_attr_id,$index[0],$rate);
                    $value = implode(',',$value);
//                $index1 = $rate * $k;
//                $index2 = $index1 + 1;
                    $gnModel->add(array(
                        'goods_id'=>$id,
                        'goods_number'=>$v,
                        'goods_attr_id'=>$value,
                    ));
                }
            }
            else // 没有商品属性则直接添加库存
            {
                $gnModel->add(array(
                    'goods_id' => $id,
                    'goods_number' => $goods_number[0],
                ));
            }

            $this->success('库存设置成功！',U('showlist?id='.I('get.id')));
            exit();
        }
        // 由于添加和修改其实是一个表单 所有要先把已经设置好的库存先取出来
        $gnData = $gnModel->where(array(
            'goods_id'=>array('eq',$id),
        ))->select();
//        dump($gnData);die;
        // 根据id查找‘商品属性表’获取当前商品的所有属性
        $gaModel = D('goods_attr');
        $gaData = $gaModel->alias('a')
                        ->field('a.*,b.attr_name')
                    ->join('LEFT JOIN __ATTRIBUTE__ b on a.attr_id = b.id')
                    ->where(array(
                        'attr_type'=>array('eq','可选'),
                        'a.goods_id'=>array('eq',$id),
                    ))->select();
        // 为了更方便的制作库存量列表表单 把这个二维数组变成三维
        $_gaData = array();
        foreach ($gaData as $k => $v){
            $_gaData[$v['attr_name']][] = $v; // 这行代码好牛逼啊
        }
//        dump($_gaData);die;
        $this->assign(
            array(
                'gnData'=>$gnData,
                'gaData'=>$_gaData,
                '_page_title'=>'商品库存',
                '_page_btn_name'=>'返回商品列表',
                '_page_btn_link'=>U('showlist'),
            )
        );
        $this->display();
    }

    // 处理删除属性
    public function ajaxDelAttr()
    {
        $goodsId = addslashes(I('get.goods_id'));
        $gaid = addslashes(I('get.gaid'));
        $gaModel = D('goods_attr');
        $gaModel->delete($gaid);
        // 删除相关库存量数据
        $gnModel = D('goods_number');
        $gnModel->where(array(
            'goods_id' => array('EXP' ,"=$goodsId or AND FIND_IN_SET($gaid, attr_list)"),
        ))->delete();
    }

    /**
     *  ajax处理商品属性的添加
     */
    public function ajaxAttrAdd(){
        $typeId = I('get.type_id');
        $attrModel = D('attribute');
        echo json_encode($attrModel ->where(array(
            'type_id' => array('eq',$typeId),
        ))->select());
    }
    // 添加商品方法
    public function add(){

        if (IS_POST){
//            dump($_FILES);die;
//            dump($_POST);die;

            // 表模型
            $goods = D('goods');
            // 收集表单数据
            $info = $goods->create(I('post.'),1); // 1代表这是一个添加表单
            if ($info){ // 收集数据成功
//                dump($info);die;
                $result = $goods->add();
                if($result){ // 入库成功
                    $this->success('添加商品成功',U('showlist?p='.I('get.p')));
                    exit;
                }
            }
            $this->error = $goods->getError();
            // 错误提示和跳转
            $this->error($this->error,'add');
            
        }
        // 获取商品的分类id
        $catModel = D('category');
        $catData = $catModel->getTree();


        // 取出所有的会员级别
        $mlModel = D('member_level');
        $mlData = $mlModel->select();
        $this->assign(
            array(
                'catData'=>$catData,
                'mlData'=>$mlData,
                '_page_title'=>'添加商品',
                '_page_btn_name'=>'返回',
                '_page_btn_link'=>U('showlist'),
            )
        );
        // 取出所有的商品品牌
        $brand = D('brand');
        $brandData = $brand->select();

        $this->assign('brandData',$brandData);
        // 显示添加商品页面
        $this->display();
    }

    /**
     * 商品列表页
     */
    function showlist(){

        $goods = D('goods');
        $data = $goods->search();
        $this->assign($data);

        // 获取所有的主分类
        $catData = D('category')->getTree();
        $this->assign(
            array(
                'catData'=>$catData,
                '_page_title'=>'商品列表',
                '_page_btn_name'=>'添加新商品',
                '_page_btn_link'=>U('add?p='.I('get.p')),
            )
        );

        // 需要连表查询指定id的品牌名称
        $this->display();
    }

    // 编辑商品方法
    public function edit(){

        // 表模型
        $goods = D('goods');
        // 获取id
        $id = I('get.goods_id');
        if (IS_POST){
            // 收集表单数据
//            dump(I('post.'));die;
            $info = $goods->create(I('post.'),2);// 2代表这是一个修改表单
//            dump($info);die;
            if ($info){ // 收集数据成功

                $result = $goods->save();
                if($result!==false){ // 只能使用全等
                    $this->success('修改商品成功',U('showlist'));
                    exit;
                }
            }
            $this->error = $goods->getError();
            // 收集数据失败
            $this->error('修改失败！失败原因:'.$this->error,U('edit?id='.$id));

        }

        // 根据当前商品id查找对应的扩展分类
        $gcModel = D('goods_cat');
        $gcData = $gcModel->field('cat_id')->where(array(
            'goods_id'=>array('eq',$id)
        ))->select();
        // 查找当前商品id对应的会员价格 用于显示
        $mpData = D('member_price')->where("goods_id = '$id'")->select();
        $this->assign('mpData',$mpData);

        // 查找所有会员级别信息
        $mlModel = D('member_level');
        $this->assign('mlData',$mlModel->select());
        // 查找商品的相册
        $gpModel = D('goods_pic');
        $gpData = $gpModel->field('id,pic,mid_pic')->where(array('goods_id'=>array('eq',$id)))->select();
        $this->assign('gpData',$gpData);
        // 根据id查找当前的商品
        $data = $goods->find($id);
        $brand = D('brand');
        $this->assign('brandData',$brand->select());
        $this->assign('data',$data);
        // 商品分类
        $catModel = D('category');
        $catData = $catModel->getTree();
        // 根据id查找商品属性
        $attrModel = D('attribute');
        // 要获取属性的名称 类型可选值等等 需要连表查询了
        $gaData = $attrModel
            ->alias('a')
            ->field('a.id attr_id,a.attr_name,a.attr_type,a.attr_option_values,b.attr_value,b.id')
            ->join('LEFT JOIN __GOODS_ATTR__ b ON (a.id = b.attr_id and b.goods_id='.$id.')')
            ->where(array
            ('a.type_id'=>array('eq',$data['type_id']),))
            ->select();
//        $gaData = $gaModel->query("
//            select a.*,b.attr_name,b.attr_type,b.attr_option_values
//            from p39_goods_attr as a left join p39_attribute as b
//            on a.attr_id = b.id
//            where a.goods_id = 77;
//        ");
//        dump($gaData);die;
        $this->assign(
            array(
                'gaData'=>$gaData,
                'gcData' =>$gcData,
                'catData'=>$catData,
                '_page_title'=>'修改商品',
                '_page_btn_name'=>'返回',
                '_page_btn_link'=>U('showlist'),
            )
        );
        // 显示添加商品页面
        $this->display();
    }
    /*
     * 删除商品
     */
    function delete(){
        $id = I('get.id');
        $goods = D('goods');
        $result = $goods->delete($id);
        if(false !== $result){
            $this->success('删除成功',U('showlist'));
        }else{
            $this->error('删除失败!原因:'.$this->getError,'showlist');
        }

    }

    /**
     * 用ajax删除图片
     */
    public function ajaxDelPic(){
        $id = I('get.picid');
//        dump($id);die;
        $gpModel = D('goods_pic');//模型
        // 先删除硬盘
        $pic = $gpModel->field('pic,sm_pic,mid_pic,big_pic')->find($id);
        deleteImage($pic);
        // 再删除数据库
        $gpModel->delete($id);
    }
    // 测试U函数的使用方法
    /*function test(){
        $name = U('showlist');
        echo $name;
    }*/

}