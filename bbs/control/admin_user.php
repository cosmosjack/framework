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

    /* 改变用户的信息 start */
    public function mod_infoOp(){
        $db_bbs_user = new Model('bbs_user');
        $where['id'] = $_POST['member_id'];
        $update['member_phone'] = $_POST['member_phone'];
        $update['integral'] = $_POST['member_integral'];
        $update['is_teacher'] = $_POST['is_teacher'];
        $result = $db_bbs_user->where($where)->update($update);
        if($result){
            showMessage("修改成功",'','','succ');
        }
    }
    /* 改变用户的信息 end */

    /* 儿童的查询功能 start */
    public function searchOp(){
        /* 如果有传递进来 child_id 则直接显示 查询的内容 start */
        if(isset($_GET['child_id']) && intval($_GET['child_id']) >0){
            //查询
            /* 查出儿童的基本信息 start */
            $db_child = new Model('bbs_child');
            $data_child = $db_child->where(array('id'=>$_GET['child_id']))->find();
            Tpl::output("data_child",$data_child);
            /* 查出儿童的基本信息 end */

            $where['child_id'] = $_GET['child_id'];

            $order = "apply_time desc";

            $db_apply = new Model('bbs_apply');

            $data_apply = $db_apply
                ->where($where)
                ->order($order)
                ->page(3)
                ->select();
//        p($data_apply);
            Tpl::output("data_apply",$data_apply);
            Tpl::output('fpage',$db_apply->showpage());

        }

        Tpl::showpage("admin_user.search");
    }
    /* 儿童的查询功能 end */
    /* 根据儿童的名字查询出相应的儿童 start */
    public function get_child_listByNameOp(){
        $db_child = new Model();
        $where['child_name'] = array("like","%".$_GET['child_name']."%");
        $sql ='SELECT DISTINCT 33hao_bbs_child.id as new_id,33hao_bbs_child.*,33hao_bbs_parents.parents_name,33hao_bbs_parents.parents_phone FROM 33hao_bbs_child LEFT JOIN 33hao_bbs_parents ON 33hao_bbs_child.member_id = 33hao_bbs_parents.member_id WHERE 33hao_bbs_child.child_name LIKE "%'.$_GET['child_name'].'%" GROUP BY new_id HAVING count(*)>0';
        $data_child = $db_child->query($sql);

        /* 查出这个儿童的监护人 查询其中一条监护人 start */

        /* 查出这个儿童的监护人 查询其中一条监护人 end */

        if($data_child){
            ajaxReturn(array('control'=>'get_child_listByNameOp','code'=>200,'msg'=>'成功','data'=>$data_child),"JSON");
        }else{
            ajaxReturn(array('control'=>'get_child_listByNameOp','code'=>0,'msg'=>'无此儿童'),"JSON");
        }
    }
    /* 根据儿童的名字查询出相应的儿童 end */

    /* 修改儿童的代理人 start */
    public function mod_child_staffOp(){
        $db_child = new Model('bbs_child');
        $where['id'] = $_GET['id'];
        $update['staff'] = $_GET['staff'];
        $result = $db_child->where($where)->update($update);
        if($result){
            ajaxReturn(array('control'=>'mod_child_staffOp','code'=>200,'msg'=>'修改成功'),"JSON");
        }else{
            ajaxReturn(array('control'=>'mod_child_staffOp','code'=>0,'msg'=>'无修改'),"JSON");
        }
    }
    /* 修改儿童的代理人 end */

    /* 儿童列表功能 start */
    public function child_listOp(){
        $db_child = new Model();
        $where = array();
        /* 是否有限制订单状态 start */
        /*if(isset($_GET['order_state']) && is_numeric($_GET['order_state'])){
            $where['order_status'] = $_GET['order_state'];
        }*/
        /* 是否有限制订单状态 end */
        if(!empty($_GET['child_name'])){
            $where['child_name'] = array("like","%".$_GET['child_name']."%");
            $sql ='SELECT DISTINCT 33hao_bbs_child.id as new_id,33hao_bbs_child.*,33hao_bbs_parents.parents_name,33hao_bbs_parents.parents_phone FROM 33hao_bbs_child LEFT JOIN 33hao_bbs_parents ON 33hao_bbs_child.member_id = 33hao_bbs_parents.member_id WHERE 33hao_bbs_child.child_name LIKE "%'.$_GET['child_name'].'%" GROUP BY new_id HAVING count(*)>0';
            $sql_total ='SELECT count(*) FROM (SELECT DISTINCT 33hao_bbs_child.id as new_id,33hao_bbs_child.*,33hao_bbs_parents.parents_name,33hao_bbs_parents.parents_phone FROM 33hao_bbs_child LEFT JOIN 33hao_bbs_parents ON 33hao_bbs_child.member_id = 33hao_bbs_parents.member_id WHERE 33hao_bbs_child.child_name LIKE "%'.$_GET['child_name'].'%" GROUP BY new_id HAVING count(*)>0) aa';
        }else{
            $sql = 'SELECT DISTINCT 33hao_bbs_child.id as new_id,33hao_bbs_child.*,33hao_bbs_parents.parents_name,33hao_bbs_parents.parents_phone FROM 33hao_bbs_child LEFT JOIN 33hao_bbs_parents ON 33hao_bbs_child.member_id = 33hao_bbs_parents.member_id  GROUP BY new_id HAVING count(*)>0';
            $sql_total = 'SELECT count(*) FROM (SELECT DISTINCT 33hao_bbs_child.id as new_id,33hao_bbs_child.*,33hao_bbs_parents.parents_name,33hao_bbs_parents.parents_phone FROM 33hao_bbs_child LEFT JOIN 33hao_bbs_parents ON 33hao_bbs_child.member_id = 33hao_bbs_parents.member_id  GROUP BY new_id HAVING count(*)>0) aa';
        }
        $total_num = $db_child->query($sql_total);
//        p($total_num[0]['count(*)']);
        /* 分页 start */
        $page = new Page();
        $page->setTotalNum($total_num[0]['count(*)']);
        $page->setEachNum(6);
        $limit_start = $page->getLimitStart();
        $limit_each = $page->getEachNum();
//        p($page->getLimitStart());
//        p($page->getLimitEnd());

        $sql = $sql." LIMIT $limit_start , $limit_each";
//        die();
        /* 分页 end */
        $order = "id desc";
//        $on = "bbs_child.member_id = bbs_parents.member_id";
        $data_bbs_child = $db_child
//            ->page(6)
            ->query($sql);

//            ->table("bbs_child,bbs_parents")
//            ->field("bbs_child.*,bbs_parents.parents_name,bbs_parents.parents_phone,bbs_parents.relation")
//            ->join("right")
//            ->on($on)
//            ->where($where)
//            ->group('id')
//            ->having('count(*)>0')
//            ->order($order)
//            ->page(6)
//            ->select();
//        p($data_bbs_child);
        Tpl::output("data_bbs_activity",$data_bbs_child);
        Tpl::output('fpage',$page->show());
        Tpl::showpage("child_list");
    }
    /* 儿童列表功能 end */
}
