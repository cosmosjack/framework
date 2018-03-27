<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/19
 * Time: 19:10
 * QQ:  997823131 
 */
class fileControl extends BaseControl{

    public function __construct(){
        parent::__construct();
    }

    public function indexOp(){
        echo 'this is file';

        if($_POST['sub'] == 'ok'){
              p($_FILES);
            // 上传图片
            $upload = new UploadFile();
            $upload->set('default_dir', ATTACH_GOODS . DS . '1' . DS . $upload->getSysSetPath());
            $upload->set('default_dir', 'uedit' . DS . $upload->getSysSetPath());
            $upload->set('max_size', C('image_max_filesize'));

            $upload->set('thumb_width', GOODS_IMAGES_WIDTH);
            $upload->set('thumb_height', GOODS_IMAGES_HEIGHT);
            $upload->set('thumb_ext', GOODS_IMAGES_EXT);
            $upload->set('fprefix', 1);
            $upload->set('allow_type', array('gif', 'jpg', 'jpeg', 'png'));

//        echo '<pre>';
//        var_dump($upload);
//        echo '</pre>';

            $result = $upload->upfile('file',true);
            p($result);


        }



        Tpl::showpage("file");
    }
}