<?php
/**
 * Created by PhpStorm.
 * User: pepe
 * Date: 2017/8/3 0003
 * Time: 7:31
 */
/**
 * @param $tableName 数据表名
 * @param $selectName select标签的name属性
 * @param $valueFiedlName option的value字段
 * @param $textFiedlName option的text字段
 * @param string $selectedValue 默认选中的值
 * 创建下拉列表
 */
function buildSelect($tableName, $selectName, $valueFieldName, $textFieldName, $selectedValue = '')
{
    $model = D($tableName);
    $data = $model->field("$valueFieldName,$textFieldName")->select();
    $select = "<select name='$selectName'><option value=''>请选择</option>";
    foreach ($data as $k => $v)
    {
        $value = $v[$valueFieldName];
        $text = $v[$textFieldName];
        if($selectedValue && $selectedValue==$value)
            $selected = 'selected="selected"';
        else
            $selected = '';
        $select .= '<option '.$selected.' value="'.$value.'">'.$text.'</option>';
    }
    $select .= '</select>';
    echo $select;
}
// 有选择性的过滤XSS --》 说明：性能非常低-》尽量少用
function removeXSS($data)
{
    require_once './Public/HtmlPurifier/HTMLPurifier.auto.php';
    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    // 设置保留的标签
    $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    // 执行过滤
    return $_clean_xss_obj->purify($data);
}

/**
 * @param $page_name
 * @param $btn_name
 * @param $btn_link
 * 后台公共模板的三个参数
 */
function assignPage($page_name,$btn_name,$btn_link){
    $this->assign(array(
        'page_name'=>$page_name,
        'btn_name'=>$btn_name,
        'btn_link'=>$btn_link
    ));
}

/**
 * @param $url
 * 显示图片
 */
function showImage($url){
    $config = C('IMAGE_CONFIG');
    echo "<img src='{$config['viewPath']}"."$url'>";
}

/**
 * @param $imgName
 * @param $dirName
 * @param array $thumb
 * @return array
 * 上传单张图片
 */
function uploadOne($imgName, $dirName, $thumb = array())
{
    // 上传LOGO
    if(isset($_FILES[$imgName]) && $_FILES[$imgName]['error'] == 0)
    {
        $ic = C('IMAGE_CONFIG');
        $upload = new \Think\Upload(array(
            'rootPath' => $ic['rootPath'],
            'maxSize' => $ic['maxSize'],
            'exts' => $ic['exts'],
        ));// 实例化上传类
        $upload->savePath = $dirName . '/'; // 图片二级目录的名称
        // 上传文件
        // 上传时指定一个要上传的图片的名称，否则会把表单中所有的图片都处理，之后再想其他图片时就再找不到图片了
        $info   =   $upload->upload(array($imgName=>$_FILES[$imgName]));
        if(!$info)
        {
            return array(
                'ok' => 0,
                'error' => $upload->getError(),
            );
        }
        else
        {
            $ret['ok'] = 1;
            $ret['images'][0] = $logoName = $info[$imgName]['savepath'] . $info[$imgName]['savename'];
            // 判断是否生成缩略图
            if($thumb)
            {
                $image = new \Think\Image();
                // 循环生成缩略图
                foreach ($thumb as $k => $v)
                {
                    $ret['images'][$k+1] = $info[$imgName]['savepath'] . 'thumb_'.$k.'_' .$info[$imgName]['savename'];
                    // 打开要处理的图片
                    $image->open($ic['rootPath'].$logoName);
                    $image->thumb($v[0], $v[1])->save($ic['rootPath'].$ret['images'][$k+1]);
                }
            }
            return $ret;
        }
    }
}

/**
 * @param array $image
 * 删除图片
 */
function deleteImage($image = array())
{
    $savePath = C('IMAGE_CONFIG');
    foreach ($image as $v)
    {
        unlink($savePath['rootPath'] . $v);
    }
}