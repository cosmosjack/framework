<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/4/11
 * Time: 15:22
 * QQ:  997823131 
 */
class admin_userControl extends BaseAdminControl{

    public function __construct(){
        parent::__construct();
    }

    /* 用户的列表 start */
    public function user_listOp(){
        $db_bbs_user = new Model();
        /* 查询条件 start */
        $where = array("member_name"=>array('like',"%{$_GET['search']['value']}%"));
        /* 查询条件 end */
        /* 排序条件 start */
        $column = array("id","member_name","city","add_time","member_phone","last_login_ip","is_teacher","integral");
        $column_key = intval($_GET['order'][0]['column']);
        $choose_column = $column[$column_key];
        $choose_sort = $_GET['order'][0]['dir'];
        $order = $choose_column." ".$choose_sort;
//        $order = "";
//        p($order);
        /* 排序条件 end */

        $db_draw = intval($_GET['draw']);
        $db_start = $_GET['start'] ? $_GET['start'] : 0;
        $db_length = $_GET['length'] ? $_GET['length'] : 10;
        $db_limit = $db_start.",".$db_length;
        $db_total = $db_bbs_user->table("bbs_user")->where($where)->count();
//        $data_bbs_user = $db_bbs_user->where($where)->order()->limit($db_limit)->select();

        $on = "bbs_user.city = area.area_id";
        $data_bbs_user = $db_bbs_user
            ->table("bbs_user,area")
            ->field("bbs_user.id,bbs_user.member_name,bbs_user.city,bbs_user.add_time,bbs_user.integral,bbs_user.last_login_ip,bbs_user.is_teacher,bbs_user.member_phone,area.area_id,area.area_name")
            ->join("left")
            ->on($on)
            ->where($where)
            ->order($order)
            ->limit($db_limit)
            ->select();

        ajaxReturn(array('draw'=>$db_draw,'recordsTotal'=>$db_total,'recordsFiltered'=>$db_total,'data'=>$data_bbs_user),"json");
    }
    /* 用户的列表 end */

    /* 获取用户的认证信息 start */
    public function get_auth_infoOp(){
        // 根据传递过来的用户ID 查询用户的认证信息
        $db_bbs_child = new Model("bbs_child");
        $db_bbs_parent = new Model("bbs_parents");
        $where = array("member_id"=>intval($_GET['id']));
        $data_bbs_child = $db_bbs_child->where($where)->select();
        $data_bbs_parent = $db_bbs_parent->where($where)->select();
        ajaxReturn(array('child'=>$data_bbs_child,'parent'=>$data_bbs_parent),"JSON");
    }
    /* 获取用户的认证信息 end */
}
