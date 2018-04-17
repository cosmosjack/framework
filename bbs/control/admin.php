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
    public function __construct(){
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

        $where = array();
        $order = "";
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


}
