<?php
/**
 *
 *	订单控制器
 *	Create by :杨奇林
 *  time:201803.24
 *  qq:928944169
 */
class orderControl extends BaseControl{

    public function __construct(){
        parent::__construct();
        //$this->checkLogin();
    }
    //待付款列表
    public function indexOp(){
    	Tpl::showpage("order");
    }
    //已付款列表
    public function orderPaidOp(){
    	Tpl::showpage("order_paid");
    }
    //已完成列表
    public function orderCompletedOp(){
        Tpl::showpage("order_completed");
    }
    //已退款列表
    public function orderRefundOp(){
        Tpl::showpage("order_refund");
    }
    //分页数据
    public function listPageOp(){
        if(!isAjax())
            ajaxReturn(array('code'=>'0','msg'=>'使用ajax提交','control'=>'listPage'));
        $pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:3;
        $map = array();
        //$map['is_recommend'] = array('eq',1);
        $db_activity = Model('goods');
        $count = $db_activity->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));
        //$_GET['curpage'] = 2;
        $field = 'id,activity_title,activity_index_pic,activity_tag,address,min_age,max_age,activity_begin_time,activity_end_time,total_number';
        $list = array();
        $list = $db_activity
                ->field('')
                ->where($map)
                //->order('activity_click desc')
                ->page($pageSize)
                ->select();
        //p($db_activity->showpage());
        //p($list);
        if(!empty($list))
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'listPage','list'=>$list,'totalPage'=>ceil($count/$pageSize)));
        else
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));

    }
    //订单详情
    public function orderDetailOp(){
        Tpl::setLayout("common_login_layout");
        Tpl::showpage("order_data");
    }
    //检查登录
    public function checkLogin(){
        if(empty($_SESSION['is_login'])){
            if(isAjax())
                ajaxReturn(array('code'=>'0','msg'=>'请先登录','control'=>'checkLogin'));
            else
                header("Location: ".urlBBS('index','login'));
                //showDialog('请先登录',urlBBS('index','login'));
        }
    }
}