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
        $db_bbs_user = new Model("area");

        $where = array("area_name"=>array('like',"%{$_GET['search']['value']}%"));
        $db_draw = intval($_GET['draw']);
        $db_start = $_GET['start'] ? $_GET['start'] : 0;
        $db_length = $_GET['length'] ? $_GET['length'] : 10;
        $db_limit = $db_start.",".$db_length;
        $db_total = $db_bbs_user->where($where)->count();
        $data_bbs_user = $db_bbs_user->where($where)->order()->limit($db_limit)->select();

        ajaxReturn(array('draw'=>$db_draw,'recordsTotal'=>$db_total,'recordsFiltered'=>$db_total,'data'=>$data_bbs_user),"json");
    }
    /* 用户的列表 end */
}
