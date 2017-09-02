<?php
namespace Admin\Model;
use Think\Cache\Driver\Redis;
use Think\Model;
class CommentModel extends Model
{
    // 提交时允许接收的字段
	protected $insertFields = array('goods_id','content','star');
	protected $_validate = array(
		array('goods_id', 'require', '参数错误！', 1, 'regex', 3),
		array('star', '1,2,3,4,5', '只能是1到5的数字！', 1, 'in'),
		array('content', '1,200', '评论内容在200以内！', 1, 'length'),
	);

	protected function _before_insert(&$data, $options)
    {
        // 判断登录
        $memberId = session('m_id');
        if (!$memberId)
        {
            $this->error='必须登录才能评论!';
            return false;
        }

        // 添加几个必要的字段
        $data['member_id'] = $memberId;
        $data['addtime'] = date('Y-m-d H:i:s');

        // 添加页面填写的印象
        $yxNames = I('post.yx_name');
        $yxIds = I('post.yx_id');
        $yxModel = D('Yinxiang');
        if($yxIds)
        {
            foreach ($yxIds as $k => $v)
            {
                $yxModel->where(array('id'=>array('eq',$v)))->setInc('yx_count');
            }
        }
        if ($yxNames)
        {
            str_replace('，',',',$yxNames); // 中文逗号转英文
            $yxNames = explode(',',$yxNames); // 转换为数组
            foreach($yxNames as $k => $v)
            {
                $v = trim($v);
                if(empty($v)) // 过滤掉空的印象
                    continue;
                // 已经存在直接+1
                $has = $yxModel->where(array(
                    'goods_id' => $data['goods_id'],
                    'yx_name' => $v,
                ))->find();
                if($has)
                {    // 已经有的印象加1
                    $yxModel->where(array(
                        'goods_id' => $data['goods_id'],
                        'yx_name' => $v,
                    ))->setInc('yx_count');
                }
                else
                {  // 没有的印象则添加
                    $yxModel->add(array(
                        'goods_id' => $data['goods_id'],
                        'yx_name' => $v,
                        'yx_count' =>1,
                    ));

                }
            }
        }
    }

    /**
     * 取一件商品的评论，包括回复的数据，带分页效果
     */
    function search($goodsId,$numPerPage = 2)
    {
        $where = array();
        $where['a.goods_id'] = array('eq',$goodsId);

        // 总数量
        $count = $this->alias('a')->where($where)->count();
        // 总页数
        $pageCount = ceil($count/$numPerPage);
        // 获取当前页
        $currentPage = max(1,(int)I('get.p',1));
        // 关键：：计算limit第一个参数 偏移量
        $offset = ($currentPage-1) * $numPerPage;
        // 如果是第一页把当前的好评率和印象也取出来
        if ($currentPage == 1)
        {
            $hao = $zhong = $cha = 0;
            // 获取所有的得分
            $stars = $this->alias('a')->field('star')->where($where)->select();
            foreach ($stars as $k => $v)
            {
                if($v['star'] == 3)
                {
                    $zhong ++ ;
                }
                elseif ($v['star']>3)
                {
                    $hao ++;
                }
                else
                {
                    $cha ++;
                }
            }
            $total = $hao + $cha + $zhong;
            $hao = round(($hao/$total) * 100,2);
            $zhong = round(($zhong/$total) * 100,2);
            $cha = round(($cha/$total) * 100,2);

            // 获取印象数据
            $yxData = D('Yinxiang')->where(array(
                'goods_id' => array('eq',$goodsId),
            ))->select();

        }
        // 取数据
        $data = $this->alias('a')
            ->field('a.id,a.addtime,a.content,a.star,a.click_count,b.username,b.face,COUNT(c.id) reply_count')
            ->join('LEFT JOIN __MEMBER__ b on a.member_id = b.id
                    LEFT JOIN __COMMENT_REPLY__ c on a.id = c.comment_id')
            ->where($where)
            ->order('a.id DESC')
            ->group('a.id')
            ->limit("$offset,$numPerPage")
            ->select();
        $crModel = D('comment_reply');
        // 循环每个评论获取回复
        foreach($data as $k=>&$v)
        {
            $v['reply'] = $crModel->alias('a')
                ->field('a.addtime,a.content,b.face,b.username')
                ->join('LEFT JOIN __MEMBER__ b on a.member_id = b.id')
                ->where(array(
                    'a.comment_id' => $v['id']
                ))->order('a.id ASC')
                ->select();
        }
        return array(
            'hao' => $hao,
            'cha' => $cha,
            'zhong' => $zhong,
            'data' => $data,
            'pageCount' => $pageCount,
            'yxData' => $yxData,
            'memberId' =>(int)session('m_id'),
        );
    }
}