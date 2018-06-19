<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/22
 * Time: 10:18
 * QQ:  997823131 
 */
class adminControl extends BaseAdminControl{
    public $img_pre_url ;
    private $bbs_upload_path;
    public function __construct(){
        $this->img_pre_url = "http://".C("oss.img_url").DS;
        $this->bbs_upload_path = "data/upload/adv";
        parent::__construct();
    }
//    后台主页界面
    public function indexOp(){
//        p(strtotime('2018-03-22 23:59:59'));

        Tpl::showpage("index");

    }

    /*
     *  网站信息
     */
    public function web_infoOp(){
        Tpl::showpage("web_info");
    }

//    活动列表  这里就不用 datatable 插件了
    public function activity_listOp(){
        /* 先判断是否是 往期的查询 start */
        if(isset($_GET['is_periods']) && $_GET['is_periods'] == true){
            $table_name = "bbs_activity_periods";
            Tpl::output("is_periods",true);
        }else{
            $table_name = "bbs_activity";
            Tpl::output("is_periods",false);
        }
        /* 先判断是否是 往期的查询 end */

        $db_bbs_activity = new Model($table_name);
        $where = array();
        /* 筛选条件 start */
        if(!empty($_GET['activity_title'])){
            $where['activity_title'] = array('like',"%".$_GET['activity_title']."%");
        }
        /* 筛选条件 end */
        if(isset($_GET['activity_no'])){
            $where['activity_no'] = $_GET['activity_no'];
        }

        $data_bbs_activity = $db_bbs_activity->where($where)->page(6)->select();
        /* 查出领队老师 和 报名的学生 start */
//        $db_bbs_teacher = new Model();
        foreach($data_bbs_activity as $key=>$val){

//            $on = 'bbs_activity_teacher.user_id = bbs_user.id';
//            $data_bbs_teacher = $db_bbs_teacher->table("bbs_activity_teacher,bbs_user")->field("bbs_user.id,bbs_user.member_sex,bbs_user.member_phone,bbs_user.headimgurl,bbs_activity_teacher.activity_id")->join("left")->on($on)->where(array("activity_id"=>$val['id']))->select();
//            $data_bbs_activity[$key]['teacher_arr'] = $data_bbs_teacher;// 老师数组

            //计算 当前 百分比
            $data_bbs_activity[$key]['percent'] = sprintf("%.2f",($val['already_num']/$val['total_number']))*100;
            //判断是进行中还是已结束 start
            $now_time = time();
            if($now_time < $val['activity_begin_time']){
                $data_bbs_activity[$key]['state'] = '未开始';
            }
            if($now_time > $val['activity_begin_time'] && $now_time < $val['activity_end_time']){
                $data_bbs_activity[$key]['state'] = '进行中';
            }
            if($now_time > $val['activity_end_time']){
                $data_bbs_activity[$key]['state'] = '已结束';
            }
            //判断是进行中还是已结束 end

        }
        /* 查出领队老师 和 报名的学生 end */
//        p($data_bbs_activity);
//        print_r($db_bbs_activity->showpage());
        Tpl::output("data_bbs_activity",$data_bbs_activity);
        Tpl::output('fpage',$db_bbs_activity->showpage());
        Tpl::showpage("activity_list");
    }


//    活动添加
    public function activity_addOp(){
        Tpl::showpage("activity_add");
    }
//  资讯列表
    public function news_listOp(){
        Tpl::showpage("news_list");
    }
//    资讯添加
    public function news_addOp(){
        Tpl::showpage("news_add");
    }

//    会员列表
    public function user_listOp(){
        Tpl::showpage("user_list");
    }

//    订单列表
    public function order_listOp(){
        // 1 已付款  2 未付款  3 已取消  4已退款
       // 1.未付款 2.已付款未参加 3.已付款已参加 4.退款中 5.已退款6已取消
        $where = array();
        /* 是否有限制订单状态 start */
        if(isset($_GET['order_state']) && is_numeric($_GET['order_state'])){
            $where['order_status'] = $_GET['order_state'];
        }
        /* 是否有限制订单状态 end */
        if(!empty($_GET['activity_title'])){
            $where['activity_title'] = array("like","%".$_GET['activity_title']."%");
        }
        $order = "order_time desc";
        $db_bbs_order = new Model("bbs_order");
        $data_bbs_order = $db_bbs_order
            ->where($where)
            ->order($order)
            ->page(6)
            ->select();
//        p($data_bbs_order);
        Tpl::output("data_bbs_activity",$data_bbs_order);
        Tpl::output('fpage',$db_bbs_order->showpage());
        Tpl::showpage("order_list");
    }

    //点评管理
    public function words_listOp(){
        Tpl::showpage("words_list");
    }

    /* 退出后台 start */
    public function logoutOp(){
        $_SESSION['is_login'] = false;
        showMessage('退出成功',BBS_SITE_URL.DS."index.php?act=admin_login");
    }
    /* 退出后台 end */

    /* 平台设置 start */
    public function settingOp(){
        if(isset($_POST['sub']) && $_POST['sub'] == 'ok'){
            // 现根据 adv_id  查出现有的信息
            $db_adv = new Model('adv');
            $where['adv_id'] = $_POST['adv_id'];
            $data_adv = $db_adv->where($where)->find();
            if(!$data_adv){
                showMessage("请正确选择图片");
                die();
            }
            $data_adv['adv_content'] = mb_unserialize($data_adv['adv_content']);
            $data_adv['adv_content']['adv_slide_url'] = $_POST['ad_link'];

            /* 根据传递过来的数据修改相应的图片 start */
            // 如果有图片则上传 没有则直接修改
            if($_FILES['ad_pic']['error'] > 0){
                $update['adv_title'] = $_POST['ad_name'];
                $update['adv_content'] = serialize($data_adv['adv_content']);
                $result = $db_adv->where($where)->update($update);
                if($result){
                    showMessage("修改成功");
                }else{
                    showMessage("修改失败",'','','error');
                }
                die();
            }else{
                //上传图片
                /* 上传封面图 start */
                $upload_file = new UploadFile();
                $upload_file->set('default_dir',$this->bbs_upload_path);
                $upload_file->set('max_size',1024);
                $cover_img_result = $upload_file->upfile("ad_pic",true);
                if($cover_img_result){
                    $adv_img_url = $this->img_pre_url.$this->bbs_upload_path.DS.$upload_file->file_name;
                    $update['adv_title'] = $_POST['ad_name'];
                    $data_adv['adv_content']['adv_slide_url'] = $_POST['ad_link'];
                    $data_adv['adv_content']['adv_slide_pic'] = $adv_img_url;

                    $update['adv_content'] = serialize($data_adv['adv_content']);
                    $result = $db_adv->where($where)->update($update);
                    if($result){
                        showMessage("修改成功");
                    }else{
                        showMessage("修改失败",'','','error');
                    }
//                    p($adv_img_url);
                }else{
                    $img_error = $upload_file->error;
                    showMessage($img_error,'','','error');
                    die();
                }
                /* 上传封面图 end */
            }
            /* 根据传递过来的数据修改相应的图片 end */

        }else{

            /* 获取当前的首页轮播图数据 start */
            import('function.adv');
            $data_adv = adv_json(1037);
//            p($data_adv);
            Tpl::output('data_adv',$data_adv['adv_info']);
            /* 获取当前的首页轮播图数据 end */

            Tpl::showpage('setting');
        }
    }
    /* 平台设置 end */


}
