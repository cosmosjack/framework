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
            $val['url'] = urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
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
            showMessage('参数错误',urlBBS('order','index'));
        $db_order = new Model('bbs_order');
        $map = array();
        $map['id'] = array('eq',$id);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $info = $db_order
                ->field('id,code,activity_time,activity_no,activity_periods,order_amount,childs_arr,parents_arr,order_time,parents_arr,order_status')
                ->where($map)
                ->find();
        if(empty($info))
            showMessage('订单不存在',urlBBS('order','index'));
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
        if(empty($activityInfo))
            showMessage('活动不存在',urlBBS('order','index'));
        //活动轮播图
        $db_banner = new Model('bbs_uploads');
        $banner = $db_banner->where('upload_type=1 and item_id='.$activityInfo['id'])->select();
        //活动详情
        $info['activity_desc'] = htmlspecialchars_decode($activityInfo['activity_desc']);
        //推荐活动
        $map = array();
        $field = 'id,activity_title,activity_no,activity_periods,activity_index_pic,activity_tag,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
        $list = $db_activity
                ->field($field)
                ->where($map)
                ->order('activity_click desc,activity_begin_time')
                ->limit(2)
                ->select();
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
                showMessage('参数错误',urlBBS('order','index'));
            $db_order = new Model('bbs_order');
            $map = array();
            $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
            $map['id'] = array('eq',$id); 
            $info = $db_order->where($map)->find();
            if(empty($info))
                showMessage('订单不存在',urlBBS('order','index'));
            Tpl::output('info',$info);
            Tpl::setLayout("common_login_layout");
            Tpl::showpage('pay_order');
            exit();
        }
        $id = $_POST['id'];
        if(empty($id))
            ajaxReturn(array('code'=>'0','msg'=>'参数错误','control'=>'ajaxPayOrder'));
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $map['id'] = array('eq',$id); 
        $info = $db_order->where($map)->find();
        if(empty($info))
            ajaxReturn(array('code'=>'0','msg'=>'订单不存在','control'=>'ajaxPayOrder'));
        //活动是否结束
        if($info['activity_end_time'] < time())
            ajaxReturn(array('code'=>'0','msg'=>'活动已结束','control'=>'ajaxDefray'));
        //判断时间是否允许修改,开始12小时前不能支付
        if(time()>$info['activity_begin_time']-3600*12)
            ajaxReturn(array('code'=>'0','msg'=>'活动开始12小时前不能支付订单','control'=>'ajaxCancelOrder'));
        if($info['order_status'] != 1)
            ajaxReturn(array('code'=>'0','msg'=>'订单已支付或已取消','control'=>'ajaxPayOrder'));
        //下面和报名流程一样
        $map = array();
        $map['activity_no'] = $info['activity_no'];
        $map['activity_periods'] = $info['activity_periods'];
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $activityInfo = $db_activity->where($map)->find();
        if(empty($activityInfo)){
            $activityInfo = $db_activity_periods->where($map)->find();
        }
        if(empty($activityInfo))
            ajaxReturn(array('code'=>'0','msg'=>'活动不存在','control'=>'ajaxPayOrder'));
        //人数限制
        if($activityInfo['already_num'] >= $activityInfo['total_number'])
            ajaxReturn(array('code'=>'0','msg'=>'报名人数已满,请选择其他活动','control'=>'ajaxDefray'));
        if($activityInfo['already_num']+$info['order_num'] > $activityInfo['total_number'])
            ajaxReturn(array('code'=>'0','msg'=>'票数不够,还有'.($activityInfo['total_number']-$activityInfo['already_num']).'张票','control'=>'ajaxDefray'));
        $db_order = new Model('bbs_order');
        
        //订单支付后,把数据写进申请表
        $parents = unserialize($info['parents_arr']);
        $childs = unserialize($info['childs_arr']);
        $db_apply = new Model('bbs_apply');
        $data = array();
        $data['activity_no'] = $info['activity_no'];
        $data['activity_title'] = $info['activity_title'];
        $data['member_id'] = $_SESSION['userInfo']['id'];
        $data['member_name'] = $_SESSION['userInfo']['member_name'];
        $data['parents_id'] = $parents[0]['id'];
        $data['parents_name'] = $parents[0]['name'];
        $data['parents_phone'] = $parents[0]['phone'];
        $data['parents_sex'] = $parents[0]['sex'];
        $data['parents_headimgurl'] = $parents[0]['img'];
        $data['apply_time'] = time();
        $data['order_id'] = $info['id'];
        $data['activity_periods'] = $info['activity_periods'];
        /* 统计小组数量 每个小组当前报名人数 总人数 当前要插入的数量 start */
        //p($info);
        $groupInfo = calc_group($info['activity_no'],$info['activity_periods']);
        $each_group_num = ceil($activityInfo['total_number']/count($groupInfo['data']));

        foreach ($groupInfo['data'] as $val) {
            $array[$val['group_id']] = ($each_group_num-$val['total_num'])<=0?0:($each_group_num-$val['total_num']); 
        }
        // p($array);
        $num = count($childs);
        $a = 1;
        $group_id_arr = array();
        foreach($array as $k=>$v){
            for($i=1;$i<=$v;$i++){
                if(($a-$num)<=0){
                    $group_id_arr[] = $k;
                    $a++;
                }else{
                    break;
                }
            }
        } 
        // p($groupInfo);p($group_id_arr);
        // die();
        /* 统计小组数量 每个小组当前报名人数 总人数 end */
        //这里考虑可以用事物
        foreach ($childs as $key => $val) {

            $data['child_id'] = $val['id'];
            $data['child_name'] = $val['name'];
            $data['child_phone'] = $val['phone'];
            $data['child_sex'] = $val['sex'];
            $data['child_height'] = $val['height'];
            $data['child_headimgurl'] = $val['img'];
            // //分组id向上取整
            // $data['group_id'] = ceil($already_num/$info['every_group_num']);
            $data['group_id'] = $group_id_arr[$key]?$group_id_arr[$key]:1;
            //$already_num++;
            // p($data);
            $db_apply->insert($data);
        }
        //修改活动表
        $map = array();
        $map['activity_no'] = $info['activity_no'];
        $map['activity_periods'] = $info['activity_periods'];
        $update = array();
        $update['already_num'] = array('exp','already_num+'.count($childs));
        $db_activity->where($map)->update($update);
        $db_activity_periods->where($map)->update($update);
        //修改订单表状态
        $result = $db_order->where('id='.$info['id'])->update(array('order_status'=>2,'pay_no'=>'111'));
        if($result)
            ajaxReturn(array('code'=>'200','msg'=>'支付成功','control'=>'ajaxPayOrder'));
        else
            ajaxReturn(array('code'=>'0','msg'=>'支付失败','control'=>'ajaxPayOrder'));
    }
    //检查登录
    public function checkLogin(){
        if(empty($_SESSION['is_login'])){
            if(isAjax())
                ajaxReturn(array('code'=>'0','msg'=>'请先登录','control'=>'checkLogin'));
            else
                //header("Location: ".urlBBS('index','login'));
                showMessage('请先登录',urlBBS('index','login'));
        }
    }
}