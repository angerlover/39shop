<?php
/**
 * Created by PhpStorm.
 * User: pepe
 * Date: 2017/7/23 0023
 * Time: 16:33
 */

namespace Admin\Controller;
use Think\Model;

class CategoryController extends BaseController {
    // 添加商品方法
    public function add() {

        $model = D('category');
        if (IS_POST) {
            // 表模型
            // 收集表单数据
            $info = $model->create(I('post.'), 1); // 1代表这是一个添加表单
            if ($info) { // 收集数据成功
                $result = $model->add();
                if ($result) { // 入库成功
                    $this->success('添加商品成功', 'lst');
                    exit;
                }
            }
            $this->error = $model->getError();
            // 错误提示和跳转
            $this->error($this->error, 'add');
        }
        // 获取所有分类 用于下拉展示
        $catData = $model->getTree();
        $this->assign(
            array(
                'catData' => $catData,
                '_page_title' => '添加分类',
                '_page_btn_name' => '返回',
                '_page_btn_link' => U('lst'),
            )
        );
        $this->display();
    }

    /**
     * 商品列表页
     */
    function lst() {

        $model = D('category');
        $data = $model->getTree();
        $this->assign('data', $data);
        $this->assign(
            array(
                '_page_title' => '分类列表',
                '_page_btn_name' => '添加新分类',
                '_page_btn_link' => U('add'),
            )
        );
        $this->display();
    }

    // 编辑商品方法
    public function edit() {

        // 表模型
        $model = D('category');
        // 获取要修改的分类id
        $id = I('get.id');
        if (IS_POST) {
            // 收集表单数据
            $info = $model->create(I('post.'), 2);// 2代表这是一个修改表单
            if ($info) { // 收集数据成功
//                dump($info);die;
                $result = $model->save();
                if ($result !== false) { // 只能使用全等
                    $this->success('修改分类成功', U('lst'));
                    exit;
                }
            }
            $this->error = $model->getError();
            // 收集数据失败
            $this->error('修改失败！失败原因:' . $this->error, U('edit?id=' . $id));
        }
        // 获取所有分类
        $catData = $model->getTree();
        // 获取当前分类的记录
        $data = $model->find($id);
        // 获取当前分类的子分类
        $children = $model->getChildren($id);
        $this->assign(
            array(
                'children'=>$children,
                'data'=>$data,
                'catData'=>$catData,
                '_page_title' => '修改分类',
                '_page_btn_name' => '返回',
                '_page_btn_link' => U('lst'),
            )
        );
        $this->display();
    }
        /*
         * 删除分类
         */
        function delete() {
            $id = I('get.id');
            $model = D('category');
            $result = $model->delete($id);
            if (false !== $result) {
                $this->success('删除成功', U('showlist'));
            } else {
                $this->error('删除失败!原因:' . $this->getError);
            }

        }

        /**
         * 用ajax删除图片
         */
        public function ajaxDelPic() {
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