<?php
/**
 * Created by PhpStorm.
 * User: pepe
 * Date: 2017/8/28 0028
 * Time: 10:35
 */

namespace Home\Model;
use Think\Model;

class CartModel extends Model
{
    protected $insertFields = 'goods_id,goods_attr_id,goods_number';
    protected $_validate = array(
        array('goods_id','require','必须选择商品',1),
        array('goods_number','chkGoodsNumber','库存量不足！',1,'callback'),
    );

    /**
     * @param $goodsNumber
     * @return bool
     * 验证库存量是否超出
     */
    function chkGoodsNumber($goodsNumber)
    {
        // 升序排列attr_id 此时不能用$this->goods_attr_id吧  因为还是检查阶段
        $gaid = I('post.goods_attr_id');
        sort($gaid,SORT_NUMERIC);
        // 转为字符串(防止null下面gn无法取值)
        $gaid =(string) implode(',',$gaid);
        $gnModel = D('Admin/goods_number');
        $gn = $gnModel->field('goods_number')
            ->where(array(
                'goods_attr_id' => array('eq',$gaid),
                'goods_id' =>array('eq',I('post.goods_id'))
            ))->find();

        return $gn['goods_number'] > $goodsNumber;
    }

    /**
     * 重写父类的表单验证
     */
    function add()
    {
        // 判断是否已经登录
        $m_id = session('m_id');
        sort($this->goods_attr_id,SORT_NUMERIC);
        $this->goods_attr_id = (string)implode(',',$this->goods_attr_id);
        // 存入数据库
        if ($m_id)
        {
            $goods_number = $this->goods_number;
            // 是否已经加入了购物车(find方法会覆盖掉表单的数据，此时$this->goods_number被覆盖了)
            $has = $this->where(array(
                'goods_id' => $this->goods_id,
                'goods_attr_id' => $this->goods_attr_id,
                'member_id' =>$m_id,
            ))->find();
            if ($has) // 已经加入购物车的只需要把增加数量
            {
                $this->where(array(
                    'id' => array('eq',$has['id'])
                ))->setInc('goods_number',$goods_number);
            }
            else
            {
                parent::add(array(
                    'goods_id' => $this->goods_id,
                    'member_id' =>$m_id,
                    'goods_attr_id' => $this->goods_attr_id,
                    'goods_number' => $this->goods_number,
                ));
            }
        }
        // 存到cookie
        else
        {
            // 从cookie中取出
            $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            // 拼出要装进cookie的字符串
            $key = $this->goods_id.'-'.$this->goods_attr_id;
            // 判断是否已经在购物车
            if (isset($cart[$key]))
            {
                $cart[$key] += $this->goods_number;
            }
            else
            {
                $cart[$key] = $this->goods_number;
            }

            // 存回到cookie中去
            setcookie('cart',serialize($cart),time()+30*86400,'/');
        }

        return true;
    }

    /**
     * 登录时把cookie的数据存入数据库
     */
    function moveCookieToDb()
    {
        // 判断是否已经登录
        $m_id = session('m_id');

        if ($m_id)
        {
            $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            // 循环每一个cookie中的购物车
            foreach ($cart as $k => $v)
            {
                $_k = explode('-',$k);
                // 依然判断数据库中是否已经存在
                // 是否已经加入了购物车(find方法会覆盖掉表单的数据，此时$this->goods_number被覆盖了)
                $has = $this->where(array(
                    'goods_id' => $_k[0],
                    'goods_attr_id' => $_k[1],
                    'member_id' =>$m_id,
                ))->find();
                if ($has) // 已经加入购物车的只需要把增加数量
                {
                    $this->where(array(
                        'id' => array('eq',$has['id'])
                    ))->setInc('goods_number',$v);
                }
                else
                {
                    parent::add(array(
                        'goods_id' => $k[0],
                        'member_id' =>$m_id,
                        'goods_attr_id' => $k[1],
                        'goods_number' => $v,
                    ));
                }

            }
        }

        setcookie('cart','',time()-1,'/');
    }
}