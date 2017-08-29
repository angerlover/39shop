<?php
namespace Admin\Model;
use Think\Cache\Driver\Redis;
use Think\Model;
class OrderModel extends Model
{
	protected $insertFields = array('shr_name','shr_tel','shr_province','shr_city','shr_area','shr_address');
	// 下单时的验证规则
    protected $_validate = array(
        array('shr_name', 'require', '收货人姓名不能为空！', 1, 'regex', 3),
        array('shr_tel', 'require', '收货人电话不能为空！', 1, 'regex', 3),
        array('shr_province', 'require', '所在省不能为空！', 1, 'regex', 3),
        array('shr_city', 'require', '所在城市不能为空！', 1, 'regex', 3),
        array('shr_area', 'require', '所在地区不能为空！', 1, 'regex', 3),
        array('shr_address', 'require', '详细地址不能为空！', 1, 'regex', 3),
    );
	protected function _before_insert(&$data, &$option)
	{
        $m_id = session('m_id');
        /********下单前的一系列检查**********/
        if(!$m_id)
        {
            // 没有登录返回错误
            $this->error = '必须登录';
            return false;
        }
        // 检查购物车是否有商品
        $cartModel = D('Cart');
        $option['goods'] = $goods = $cartModel->getCartData();
        if(!goods)
        {
            $this->error = '下单失败！购物车是空的';
            return false;
        }

        // 高并发加锁
        $this->fp = $fp = fopen('./order.lock');
        flock($fp,LOCK_EX);
        // 检查购物车中的库存量并计算总价
        $gnModel = D('goods_number');
        $totalPrice = 0;
        foreach ($goods as $k=> $v)
        {
            $goods_number = $gnModel->field('goods_number')
                ->where(array(
                'goods_id' => array('eq',$v['goods_id']),
                'goods_attr_id' => array('eq',$v['goods_attr_id']),
            ))->find();

            if($goods_number['goods_number'] < $v['goods_number'])
            {
                $this->error = '下单失败！库存量不足';
                return false;
            }
            else
            {
                $totalPrice += $v['goods_number'] * $v['price'];
            }
        }

        // 把所需信息补全
        $data['total_price'] = $totalPrice;
        $data['addtime'] = time();
        $data['member_id'] = $m_id;

        // 正式开始插入数据库之前 开启事务：保证三张表都能操作成功
        $this->startTrans();
	}

    /**
     * @param $data
     * @param $options
     * 主要是插入到 订单商品表 order_goods
     */
	protected function _after_insert($data, $options)
    {
        $ogModel = D('order_goods');
        $gnModel = D('goods_number');

        // 插入到订单商品表
        foreach ($options['goods'] as $k=> $v)
        {
            $res = $ogModel->add(array(
                'order_id' => $data['id'],
                'goods_id' => $v['goods_id'],
                'goods_attr_id' => $v['goods_attr_id'],
                'goods_number' => $v['goods_number'],
                'price' => $v['price'],
        ));
            if(!$res)
            {
                $this->rollback();
                return false;
            }
            // 减库存
            $res = $gnModel->where(array(
                'goods_id' =>array('eq',$v['goods_id']),
                'goods_attr_id' => array('eq',$v['goods_attr_id'])
            ))->setDec('goods_number',$v['goods_number']);
            if(false === $res) // 要用====
            {
                $this->rollback();
                return false;
            }
        }

        // 提交事务
        $this->commit();
        // 释放锁
        flock($this->fp,LOCK_UN);
        fclose($this->fp);

        // 清空购物车
        $cartModel = D('cart');
        $cartModel->clear();

    }

    /**
     * 搜索
     */
    public function search($pageSize = 20)
    {
        $where = array();
        $m_id = session('m_id');
        $where['member_id'] = array('eq',$m_id);
        $noPayCount = $this->where(array(
            'pay_status' => array('eq','否'),
            'member_id' => array('eq',$m_id),
        ))->count();
        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where($where)->count();
        $page = new \Think\Page($count, $pageSize);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $data['page'] = $page->show();
        /************************************** 取数据 ******************************************/
        $data['data'] = $this->alias('a')
            ->field('a.id,a.shr_name,a.total_price,a.addtime,a.pay_status,GROUP_CONCAT(DISTINCT c.sm_logo) logo')
            ->join('LEFT JOIN __ORDER_GOODS__ b on a.id = b.order_id')
            ->join('LEFT JOIN __GOODS__ c on b.goods_id =c.id')
            ->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
        $data['noPayCount'] = $noPayCount;
        return $data;
    }
}