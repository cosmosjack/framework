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
        $this->checkLogin();
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
        $pageSize = !empty($_POST['pageSize'])?$_POST['pageSize']:3;
        $orderStatus = !empty($_POST['orderStatus'])?$_POST['orderStatus']:1;
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        if($orderStatus >= 4){
            $map['order_status'] = array('in',array(4,5));
        }else{
            $map['order_status'] = array('eq',$orderStatus);
        }
        // p($map);
        //$map['is_recommend'] = array('eq',1);
        $db_order = new Model('bbs_order');
        $count = $db_order->where($map)->count();
        //p($count);
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));
        //$_GET['curpage'] = 2;
        $field = 'id,activity_no,activity_periods,activity_title,activity_tag,
        activity_index_pic,order_amount,order_num,activity_time,order_status';
        $list = array();
        $list = $db_order
                ->field($field)
                ->where($map)
                ->order('order_time desc')
                ->page($pageSize)
                ->select();
        //p($db_order->showpage());
        //p($list);
        foreach ($list as &$val) {
            // $val['url'] = urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
            $val['url'] = urlBBS('order','orderDetail',array('id'=>$val['id']));
            if($orderStatus == 1)
                $val['url1'] = urlBBS('order','payOrder',array('id'=>$val['id']));
            else
                $val['url1'] = urlBBS('order','orderDetail',array('id'=>$val['id']));
        }
        if(!empty($list))
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'listPage','list'=>$list));
        else
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));

    }
    //订单详情
    public function orderDetailOp(){
        Tpl::setLayout("common_login_layout");
        $id = $_GET['id'];
        if(empty($id))
            showMessage('参数错误',getenv(HTTP_REFERER));
        $db_order = new Model('bbs_order');
        $map = array();
        $map['id'] = array('eq',$id);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $info = $db_order
                ->field('id,code,activity_time,activity_begin_time,activity_title,activity_address,activity_no,activity_periods,order_amount,order_num,childs_arr,parents_arr,order_time,parents_arr,order_status,remark')
                ->where($map)
                ->find();
        if(empty($info))
            showMessage('订单不存在',getenv(HTTP_REFERER));
        //查活动详情,先查activity，没有再查activity_periods
        $db_activity = new Model('bbs_activity');
        $map = array();
        $map['activity_no'] = $info['activity_no'];
        $map['activity_periods'] = $info['activity_periods'];
        $activityInfo = $db_activity
                        ->field('id,activity_title,activity_tag,activity_city,activity_area,address,min_age,max_age,total_number,already_num,activity_price,activity_desc,activity_begin_time')
                        ->where($map)
                        ->find();
        if(empty($activityInfo)){
            $db_activity_periods = new Model('bbs_activity_periods');
            $activityInfo = $db_activity_periods
                        ->field('id,activity_title,activity_tag,activity_city,activity_area,address,min_age,max_age,total_number,already_num,activity_price,activity_desc,activity_begin_time')
                        ->where($map)
                        ->find();
        }
        // if(empty($activityInfo))
        //     showMessage('活动不存在',getenv(HTTP_REFERER));
        //活动轮播图
        $db_banner = new Model('bbs_uploads');
        $banner = $db_banner->where('upload_type=1 and item_id='.$info['activity_no'])->select();
        //活动详情
        $info['activity_desc'] = htmlspecialchars_decode($activityInfo['activity_desc']);
        //查看是否收藏
        $db_collect = new Model('bbs_collect');
        $map = array();
        $map['activity_periods'] = array('eq',$info['activity_periods']);
        $map['activity_no'] = array('eq',$info['activity_no']);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']); 
        if($db_collect->where($map)->find())
            $info['collect'] = 1;
        //推荐活动
        $map = array();
        $field = 'id,activity_title,activity_no,activity_periods,activity_index_pic,activity_tag,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price,activity_city';
        $list = $db_activity
                ->field($field)
                ->where($map)
                ->order('activity_click desc,activity_begin_time')
                ->limit(2)
                ->select();
        //查看是否收藏
        foreach ($list as &$val) {
            $map = array();
            $map['activity_periods'] = array('eq',$val['activity_periods']);
            $map['activity_no'] = array('eq',$val['activity_no']);
            $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
            if($db_collect->where($map)->find())
                $val['collect'] = 1;
            $val['activity_time'] = (date('Ymd',$val['activity_begin_time'])==date('Ymd',$val['activity_end_time']))?date('n月j日',$val['activity_begin_time']).'一天':(date('n月j日',$val['activity_begin_time']).'~'.date('n月j日',$val['activity_end_time']));
        }
        // p($banner);
        // p($activityInfo);
        Tpl::output('info',$info);
        Tpl::output('activityInfo',$activityInfo);
        Tpl::output('banner',$banner);
        Tpl::output('list',$list);
        Tpl::showpage("order_data");
    }
    //取消订单
    public function ajaxCancelOrderOp(){
        if(!isAjax())
            ajaxReturn(array('code'=>'0','msg'=>'请求方式错误','control'=>'ajaxCancelOrder'));
        $id = $_POST['id'];
        if(empty($id))
            ajaxReturn(array('code'=>'0','msg'=>'参数有误','control'=>'ajaxCancelOrder'));
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $map['id'] = array('eq',$id); 
        $info = $db_order->where($map)->find();
        if(empty($info))
            ajaxReturn(array('code'=>'0','msg'=>'订单不存在','control'=>'ajaxCancelOrder'));
        //判断时间是否允许修改,开始前12小时不能取消
        if(time()>$info['activity_begin_time']-3600*12)
            ajaxReturn(array('code'=>'0','msg'=>'活动开始12小时前不能取消订单','control'=>'ajaxCancelOrder'));
        if($info['order_status'] > 2)
            ajaxReturn(array('code'=>'0','msg'=>'订单已完成或已取消','control'=>'ajaxCancelOrder'));
        $update = array();
        $update['order_status'] = $info['order_status']==1?6:4;
        $result = $db_order->where($map)->update($update);
        // if($info['order_status'] == 1)
        //     $result = $db_order->where($map)->update(array('order_status'=>6));
        // if($info['order_status'] == 2){
        //     $result = $db_order->where($map)->update(array('order_status'=>4));
        //     //删除申请表数据
        //     //修改活动表数据参与人数
        // }
        if($result){
            //修改活动表数据参与人数
            $map = array();
            $map['activity_no'] = array('eq',$info['activity_no']);
            $map['activity_periods'] = array('eq',$info['activity_periods']);
            $db_activity = new Model('bbs_activity');
            $db_activity_periods = new Model('bbs_activity_periods');
            $update = array();
            $update['already_num'] = array('exp','already_num-'.$info['order_num']);
            $db_activity->where($map)->update($update);
            $bbs_activity_periods->where($map)->update($update);
            //删除申请表数据
            $db_apply = new Model('bbs_apply');
            $db_apply->where('order_id='.$info['id'])->delete();
            ajaxReturn(array('code'=>'200','msg'=>'取消成功','control'=>'ajaxCancelOrder','url'=>urlBBS('order','orderDetail',array('id'=>$id))));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'取消失败','control'=>'ajaxCancelOrder'));
        }
    }
    //支付订单
    public function payOrderOp(){
        //微信支付成功后进行下面的操作
        if(!isAjax()){
            $id = $_GET['id'];
            if(empty($id))
                showMessage('参数错误',getenv(HTTP_REFERER));
            $db_order = new Model('bbs_order');
            $map = array();
            $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
            $map['id'] = array('eq',$id); 
            $info = $db_order->where($map)->find();
            if(empty($info))
                showMessage('订单不存在',getenv(HTTP_REFERER));
            Tpl::output('info',$info);
            Tpl::setLayout("common_login_layout");
            Tpl::showpage('pay_order');
            exit();
        }
        $id = $_POST['id'];
        if(empty($id))
            ajaxReturn(array('code'=>'0','msg'=>'参数错误','control'=>'payOrder'));
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $map['id'] = array('eq',$id); 
        $info = $db_order->where($map)->find();
        if(empty($info))
            ajaxReturn(array('code'=>'0','msg'=>'订单不存在','control'=>'payOrder'));
        //活动是否结束
        if($info['activity_end_time'] < time())
            ajaxReturn(array('code'=>'0','msg'=>'活动已结束','control'=>'payOrder'));
        //判断时间是否允许修改,开始12小时前不能支付
        if(time()>$info['activity_begin_time']-3600*12)
            ajaxReturn(array('code'=>'0','msg'=>'活动开始12小时前不能支付订单','control'=>'payOrder'));
        if($info['order_status'] != 1)
            ajaxReturn(array('code'=>'0','msg'=>'订单已支付或已取消','control'=>'payOrder'));
        //下面和报名流程一样
        $map = array();
        $map['activity_no'] = $info['activity_no'];
        $map['activity_periods'] = $info['activity_periods'];
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $activityInfo = $db_activity->where($map)->find();
        if(empty($activityInfo))
            $activityInfo = $db_activity_periods->where($map)->find();
        if(empty($activityInfo))
            ajaxReturn(array('code'=>'0','msg'=>'活动不存在','control'=>'payOrder'));
        //人数限制
        if($activityInfo['already_num'] >= $activityInfo['total_number'])
            ajaxReturn(array('code'=>'0','msg'=>'报名人数已满,请选择其他活动','control'=>'payOrder'));
        if($activityInfo['already_num']+$info['order_num'] > $activityInfo['total_number'])
            ajaxReturn(array('code'=>'0','msg'=>'票数不够,还有'.($activityInfo['total_number']-$activityInfo['already_num']).'张票','control'=>'payOrder'));
        //成功后跳转到微信
        //header("Location: ".urlBBS('order','pay_wx',array('id'=>$id)));
        ajaxReturn(array('code'=>'200','msg'=>'跳转到微信支付','url'=>urlBBS('order','pay_wx',array('id'=>$id))));
    }
    //微信支付页面
    public function pay_wxOp(){
        $id = $_GET['id'];
        if(empty($id))
            showMessage('参数错误',getenv(HTTP_REFERER));
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $map['id'] = array('eq',$id); 
        $info = $db_order->where($map)->find();
        if(empty($info))
            showMessage('订单不存在',getenv(HTTP_REFERER));
        // p($info);
        // p(intval($info['order_amount']*100));
        //因为后台有修改订单金额的功能 ，所以要重新生成订单号
        $pay_no = 'HSN_'.date("YmdHis").mt_rand(100,999);
        $db_order->where($map)->update(array('pay_no'=>$pay_no));
        //调用微信支付
        $wx_api_path = BASE_DATA_PATH.DS."api".DS."payment".DS."wxpay_jsapi".DS;
        include($wx_api_path."wxpay_jsapi.php");
        $wx_pay = new wxpay_jsapi();
        $wx_pay->setConfig('orderSn',$pay_no);
        $wx_pay->setConfig('orderInfo',$info['activity_title']);
        $wx_pay->setConfig('orderFee',intval($info['order_amount']*100));
        echo($wx_pay->paymentHtml());
    }

    //检查登录
    public function checkLogin(){
        if(empty($_SESSION['is_user_login'])){
            if(isAjax())
                ajaxReturn(array('code'=>'0','msg'=>'请先登录','control'=>'checkLogin'));
            else
                //header("Location: ".urlBBS('index','login'));
                showMessage('请先登录',urlBBS('index','login'));
        }
    }
}