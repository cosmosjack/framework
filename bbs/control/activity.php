<?php
/**
 *
 *	活动控制器
 *	Create by :杨奇林
 *  time:201803.23
 *  qq:928944169
 */
class activityControl extends BaseControl{

    public function __construct(){
        parent::__construct();
    }
    //推荐活动列表
    public function indexOp(){
    	Tpl::showpage("activity");
    }
    //往期活动列表
    public function activityExpiredOp(){
    	Tpl::showpage("activity_expired");
    }
    //分页数据
    public function listPageOp(){
    	if(!isAjax())
    		ajaxReturn(array('code'=>'0','msg'=>'使用ajax提交','control'=>'listPage'));
		$pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:3;
        $db_activity = new Model('bbs_activity');
        //活动时间状态
        $activityTime = !empty($_POST['time'])?$_POST['time']:'ing';
        //活动类型
        $activityType = !empty($_POST['type'])?$_POST['type']:'';
        //推荐活动
        $is_recommend = !empty($_POST['recommend'])?$_POST['recommend']:'';
        $map = array();
        //还没有结束的活动
        if($activityTime == 'ing')
            $map['activity_end_time'] = array('gt',time()); 
        //活动类型
        if(!empty($activityType))
            $map['activity_type'] = array('eq',$activityType);
        if($is_recommend != '')
            $map['is_recommend'] = array('eq',1);
        //$_GET['curpage'] = 2;
        if(!empty($_POST['keyword']))
            $map['activity_title'] = array('like','%'.$_POST['keyword'].'%'); 
        $count = $db_activity->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));
        $field = 'id,activity_no,activity_periods,activity_title,activity_ptitle,activity_index_pic,activity_tag,activity_city,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
        $list = array();
        $list = $db_activity
        		->field($field)
        		->where($map)
        		->order('activity_begin_time,activity_click desc')
        		->page($pageSize)
        		->select();
	    //p($db_activity->showpage());
        //p($list);
        if(!empty($list)){
            foreach ($list as &$val) {
                //$val['activity_title'] = mb_substr($val['activity_title'], 0,6,'utf-8');
                $val['activity_time'] = (date('Ymd',$val['activity_begin_time'])==date('Ymd',$val['activity_end_time']))?date('m月d日',$val['activity_begin_time']).'一天':(date('m月d日',$val['activity_begin_time']).'~'.date('m月d日',$val['activity_end_time']));
                $val['url1'] = urlBBS('activity','collect',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['age'] = $val['min_age'].'-'.$val['max_age'];
                $val['city'] = getAreaName($val['activity_city']);
                $url = urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $num = (int)$val['total_number']-(int)$val['already_num'];
                if($num == 0){
                    $val['top'] = '<div class="Prompt text-right"><span>已经满额<span></div>';
                    $val['footer'] = '<button class="pro_btn btn_isabled" disabled="disabled">已售罄</button>';
                }else if($num < 5){
                    $val['top'] = '<div class="Prompt text-right"><span>即将满额<span></div>';
                    $val['footer'] = '<button class="pro_btn" href_url="'.$url.'">去订票</button>';
                }else{
                    //echo 'string';exit();
                    $val['top'] = '';
                    $val['footer'] = '<button class="pro_btn" href_url="'.$url.'">去订票</button>';
                }
            }
            // p($num);
            // p($list);
        	ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'listPage','list'=>$list));
        }
        else{
        	ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));
        }
    }
    //往期活动列表
    public function listPageOldOp(){
        if(!isAjax())
            ajaxReturn(array('code'=>'0','msg'=>'使用ajax提交','control'=>'listPage'));
        $pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:3;
        $db_activity = new Model('bbs_activity_periods');
        $map = array();
        //已经结束的活动
        $map['activity_end_time'] = array('lt',time());
        //$_GET['curpage'] = 2;
        if(!empty($_POST['keyword']))
            $map['activity_title'] = array('like','%'.$_POST['keyword'].'%'); 
        $count = $db_activity->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));
        $field = 'id,activity_title,activity_index_pic,activity_tag,activity_city,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
        $list = array();
        $list = $db_activity
                ->field($field)
                ->where($map)
                ->page($pageSize)
                ->order('activity_periods desc,activity_click desc')
                ->group('activity_no')
                ->select();
        //p($db_activity->showpage());
        //p($list);
        if(!empty($list)){
            foreach ($list as &$val) {
                //$val['activity_title'] = mb_substr($val['activity_title'], 0,6,'utf-8');
                $val['activity_time'] = (date('Ymd',$val['activity_begin_time'])==date('Ymd',$val['activity_end_time']))?date('m月d日',$val['activity_begin_time']).'一天':(date('m月d日',$val['activity_begin_time']).'~'.date('m月d日',$val['activity_end_time']));
                $val['url1'] = urlBBS('activity','pastDetail',array('id'=>$val['id']));
                $val['age'] = $val['min_age'].'-'.$val['max_age'];
                $val['city'] = getAreaName($val['activity_city']);  
            }
            // p($num);
            // p($list);
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'listPage','list'=>$list));
        }
        else{
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));
        }
    }
    //推荐活动详情
    public function detailOp(){
        //p($_GET['id']);
        $activity_no = $_GET['activity_no'];
        $activity_periods = $_GET['activity_periods'];
        if(empty($activity_no) || empty($activity_periods))
            showMessage('参数错误',urlBBS());
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $info = $db_activity->where($map)->find();
        if(empty($info))
            $info = $db_activity_periods->where($map)->find();
        if(empty($info))
            showMessage('活动不存在',urlBBS());
        //活动轮播图
        $db_banner = new Model('bbs_uploads');
        $banner = $db_banner->where('upload_type=1 and item_id='.$info['activity_no'])->select();
        //活动详情
        $info['activity_desc'] = htmlspecialchars_decode($info['activity_desc']);
        //活动时间
        if(date('Ymd',$info['activity_begin_time']) == date('Ymd',$info['activity_end_time']))
            $info['activity_time'] = date('m月d日',$info['activity_begin_time']).'一天';
        else
            $info['activity_time'] = date('m月d日',$info['activity_begin_time']).'~'.date('m月d日',$info['activity_end_time']);
        //点击量加1
        $update = array();
        $update['activity_click'] = array('exp','activity_click+1');
        $db_activity->where($map)->update($update);
        $db_activity_periods->where($map)->update($update);
        //其他期数
        //$db_activity_periods = new Model('bbs_activity_periods');
        $map = array();
        $map['activity_periods'] = array('neq',$info['activity_periods']);
        $map['activity_no'] = array('eq',$info['activity_no']);
        $map['activity_begin_time'] = array('gt',time()+3600*12);
        $periods = $db_activity_periods
                    ->field('id,activity_no,activity_periods,activity_begin_time,activity_end_time')
                    ->where($map)
                    ->order('activity_periods,activity_begin_time')
                    ->select();
        //推荐活动
        $map = array();
        $map['id'] = array('neq',$info['id']);
        $map['activity_end_time'] = array('gt',time());
        $field = 'id,activity_title,activity_no,activity_periods,activity_index_pic,activity_tag,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
        $list = $db_activity
                ->field($field)
                ->where($map)
                ->order('activity_begin_time,activity_click desc')
                ->limit(2)
                ->select();
        //p($info);p($list);p($banner);
        Tpl::output('info',$info);
        Tpl::output('banner',$banner);
        Tpl::output('periods',$periods);
        Tpl::output('list',$list);
        Tpl::setLayout("common_login_layout");
    	Tpl::showpage("recom_active");
    }
    //往期活动详情
    public function pastDetailOp(){
        $id = $_GET['id'];
        if(empty($id))
            showMessage('id不能为空',urlBBS());
        $db_activity = Model('bbs_activity_periods');
        $info = $db_activity->where('id='.$id)->find();
        if(empty($info))
            showMessage('活动不存在',urlBBS());
        //活动轮播图
        $db_banner = new Model('bbs_uploads');
        $banner = $db_banner->where('upload_type=1 and item_id='.$info['id'])->select();
        //p($banner);
        //活动详情
        $info['activity_desc'] = htmlspecialchars_decode($info['activity_desc']);
        //点击量加1
        $update = array();
        $update['activity_click'] = array('exp','activity_click+1');
        $db_activity->where('id='.$id)->update($update);
        //队伍
        $db_apply = new Model('bbs_apply');
        $map = array();
        $map['activity_no'] = array('eq',$info['activity_no']);
        $map['activity_periods'] = array('eq',$info['activity_periods']);
        $groupInfo = calc_group($info['activity_no'],$info['activity_periods']);
        $group_arr = array();
        foreach ($groupInfo['data'] as $val) {
            if($val['total_num'] > 0){
                $map['group_id'] = array('eq',$val['group_id']);
                $group_arr[$val['group_id']] = $db_apply
                                            ->field('teacher_id,teacher_name,child_id,child_name,child_headimgurl')
                                            ->where($map)
                                            ->limit(4)
                                            ->select();
            }
        }
        // p($groupInfo);
        // p($group_arr);
        //评论
        Tpl::output('banner',$banner);
        Tpl::output('info',$info);
        Tpl::output('groupInfo',$groupInfo['data']);
        Tpl::output('group_arr',$group_arr);
    	Tpl::showpage("past_detail");
    }
    //收藏活动
    public function collectOp(){
        if(!isAjax())
            ajaxReturn(array('code'=>'0','msg'=>'请求方式错误','control'=>'collect'));
        if(empty($_SESSION['is_login']))
            ajaxReturn(array('code'=>'0','msg'=>'请先登录','control'=>'collect','url'=>urlBBS('index','login')));
        $activity_no = $_GET['activity_no'];
        $activity_periods = $_GET['activity_periods'];
        if(empty($activity_no) || empty($activity_periods))
            ajaxReturn(array('code'=>'0','msg'=>'参数错误','control'=>'collect'));
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $info = $db_activity->where($map)->find();
        if(empty($info))
            $info = $db_activity->where($map)->find();
        if(empty($info))
            ajaxReturn(array('code'=>'0','msg'=>'活动不存在','control'=>'collect'));
        $db_collect = new Model('bbs_collect');
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $collectInfo = $db_collect->where($map)->find();
        //收藏或取消
        if(empty($collectInfo)){
            $data = array();
            $data['activity_no'] = $activity_no;
            $data['activity_periods'] = $activity_periods;
            $data['member_id'] = $_SESSION['userInfo']['id'];
            $data['member_name'] = $_SESSION['userInfo']['member_name'];
            $result = $db_collect->insert($data);
            if($result)
                ajaxReturn(array('code'=>'200','msg'=>'收藏成功','control'=>'collect','flag'=>1));
            else
                ajaxReturn(array('code'=>'0','msg'=>'收藏失败','control'=>'collect'));
        }else{
            $result = $db_collect->where($map)->delete();
                ajaxReturn(array('code'=>'200','msg'=>'取消成功','control'=>'collect','flag'=>2));
            //很奇怪，删除成功的时候返回值是false
            // if($result)
            //     ajaxReturn(array('code'=>'200','msg'=>'取消成功','control'=>'collect','flag'=>2));
            // else
            //     ajaxReturn(array('code'=>'0','msg'=>'取消失败','control'=>'collect'));
        }
    }
    //活动类型
    public function activityTypeOp(){
    	Tpl::showpage("activity_type");
    }
    //活动类型介绍
    public function introduceOp(){
        Tpl::setLayout('common_login_layout');
        Tpl::showpage("nature_teach");
    }
    //宝贝视频
    public function babyVideoOp(){
    	Tpl::showpage("baby_video");
    }
    //活动排期
    public function arrangeOp(){
    	Tpl::showpage("arrange");
    }
    //明星领队
    public function starLeaderOp(){
    	Tpl::showpage("star_leader");
    }
    //领队详情
    public function leaderDetailOp(){
        Tpl::showpage('leader_detail');
    }
    //小组成员
    public function memberOp(){
        Tpl::showpage("member");
    }
    //活动报名页面
    public function defrayOp(){
         $activity_no = $_GET['activity_no'];
        $activity_periods = $_GET['activity_periods'];
        if(empty($activity_no) || empty($activity_periods))
            showMessage('参数错误',urlBBS());
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $info = $db_activity->where($map)->find();
        if(empty($info))
            $info = $db_activity_periods->where($map)->find();
        if(empty($info))
            showMessage('活动不存在',urlBBS());
        // p($periods);
        // p($info);
        //其他期数
        //$db_activity_periods = new Model('bbs_activity_periods');
        // $map = array();
        // $map['activity_periods'] = array('neq',$info['activity_periods']);
        // $map['activity_no'] = array('eq',$info['activity_no']);
        // $map['activity_begin_time'] = array('gt',time()+3600*24);
        // $periods = $db_activity_periods
        //             ->field('id,activity_no,activity_begin_time,activity_end_time')
        //             ->where($map)
        //             ->order('activity_periods,activity_begin_time')
        //             ->select();
        $info['address'] = getAreaName($info['activity_province']).getAreaName($info['activity_city']).getAreaName($info['activity_area']).$info['address'];
        Tpl::output('info',$info);
        //Tpl::output('periods',$periods);
        Tpl::setLayout("common_login_layout");
        Tpl::showpage("defray");
    }
    //活动报名操作
    public function ajaxDefrayOp(){
        //p(unserialize($_POST['students']));
        //p($_POST);exit();
        if(empty($_POST['de_phone']))
            ajaxReturn(array('code'=>'0','msg'=>'请填写手机号','control'=>'ajaxDefray'));
        if(!isPhone($_POST['de_phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机格式不正确','control'=>'ajaxDefray'));
        if(empty($_POST['parents']))
            ajaxReturn(array('code'=>'0','msg'=>'请选择监护人','control'=>'ajaxDefray'));
        if(empty($_POST['students']))
            ajaxReturn(array('code'=>'0','msg'=>'请选择学员','control'=>'ajaxDefray'));
        //查询活动信息
        $activity_no = $_POST['activity_no'];
        $activity_periods = $_POST['activity_periods'];
        if(empty($activity_no) || empty($activity_periods))
            ajaxReturn(array('code'=>'0','msg'=>'参数错误','control'=>'ajaxDefray'));
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $info = $db_activity->where($map)->find();
        if(empty($info))
            $info = $db_activity_periods->where($map)->find();
        if(empty($info))
            ajaxReturn(array('code'=>'0','msg'=>'活动不存在','control'=>'ajaxDefray'));
        //活动是否结束
        if($info['activity_end_time'] < time())
            ajaxReturn(array('code'=>'0','msg'=>'活动已结束','control'=>'ajaxDefray'));
        //活动开始12小时前才可以报名
        if($info['activity_begin_time']-3600*12 < time())
            ajaxReturn(array('code'=>'0','msg'=>'活动开始12小时前才可以报名哦','control'=>'ajaxDefray'));
        //人数限制
        if($info['already_num'] >= $info['total_number'])
            ajaxReturn(array('code'=>'0','msg'=>'报名人数已满,请选择其他活动','control'=>'ajaxDefray'));
        if($info['already_num']+count($_POST['students']) > $info['total_number'])
            ajaxReturn(array('code'=>'0','msg'=>'票数不够,还有'.($info['total_number']-$info['already_num']).'张票','control'=>'ajaxDefray'));
        $db_order = new Model('bbs_order');
        //查看是否报名
        $map = array();
        $map['activity_no'] = array('eq',$info['activity_no']);
        $map['activity_periods'] = array('eq',$info['activity_periods']);
        $map['member_id'] = $_SESSION['userInfo']['id'];
        $map['order_status'] = array('elt',3);
        if($db_order->where($map)->field('id')->find())
            ajaxReturn(array('code'=>'0','msg'=>'您已经报过名了','control'=>'ajaxDefray'));
        //exit('111');
        $data = array();
        $data['code'] = randomUp(8,0);//确认码，随机英文大写加数字
        $data['activity_no'] = $info['activity_no'];
        $data['activity_title'] = $info['activity_title'];
        $data['activity_index_pic'] = $info['activity_index_pic'];
        $data['activity_tag'] = $info['activity_tag'];
        $data['activity_periods'] = $info['activity_periods'];
        $data['activity_time'] = ($info['activity_begin_time']==$info['activity_end_time'])?date('m月d日',$info['activity_begin_time']).'一天':(date('m月d日',$info['activity_begin_time']).'~'.date('m月d日',$info['activity_end_time']));
        $data['activity_begin_time'] = $info['activity_begin_time'];
        $data['activity_end_time'] = $info['activity_end_time'];
        $data['activity_address'] = getAreaName($info['activity_province']).getAreaName($info['activity_city']).getAreaName($info['activity_area']).$info['address'];
        $data['member_id'] = $_SESSION['userInfo']['id'];
        $data['member_name'] = $_SESSION['userInfo']['member_name'];
        $data['order_num'] = count($_POST['students']);
        $data['order_amount'] = floatval($info['activity_price'])*count($_POST['students']);
        $data['order_time'] = time();
        $data['order_status'] = 1;
        $data['childs_arr'] = serialize($_POST['students']);
        $data['parents_arr'] = serialize($_POST['parents']);
        $data['remark'] = $_POST['remark'];
        $result = $db_order->insert($data);
        //p($data);
        if($result){
            //微信支付成功后进行下面的操作
            //订单支付后,把数据写进申请表
            $db_apply = new Model('bbs_apply');
            $already_num = $info['already_num']+1;
            $data = array();
            $data['activity_no'] = $info['activity_no'];
            $data['activity_title'] = $info['activity_title'];
            $data['member_id'] = $_SESSION['userInfo']['id'];
            $data['member_name'] = $_SESSION['userInfo']['member_name'];
            $data['parents_id'] = $_POST['parents'][0]['id'];
            $data['parents_name'] = $_POST['parents'][0]['name'];
            $data['parents_phone'] = $_POST['parents'][0]['phone'];
            $data['parents_sex'] = $_POST['parents'][0]['sex'];
            $data['parents_headimgurl'] = $_POST['parents'][0]['img'];
            $data['apply_time'] = time();
            $data['order_id'] = $result;
            $data['activity_periods'] = $info['activity_periods'];
            /* 统计小组数量 每个小组当前报名人数 总人数 当前要插入的数量 start */
            //p($info);
            $groupInfo = calc_group($info['activity_no'],$info['activity_periods']);
            $each_group_num = ceil($info['total_number']/count($groupInfo['data']));

            foreach ($groupInfo['data'] as $val) {
                $array[$val['group_id']] = ($each_group_num-$val['total_num'])<=0?0:($each_group_num-$val['total_num']); 
            }
            // p($array);
            $num = count($_POST['students']);
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
            //考虑使用事物
            foreach ($_POST['students'] as $key => $val) {

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
            //修改活动表报名人数
            $update = array();
            $update['already_num'] = array('exp','already_num+'.count($_POST['students']));
            $map = array();
            $map['activity_no'] = $info['activity_no'];
            $map['activity_periods'] = $info['activity_periods'];
            $db_activity->where($map)->update($update);
            $db_activity_periods->where($map)->update($update);
            //修改订单表状态
            $db_order->where('id='.$result)->update(array('order_status'=>2,'pay_no'=>'111'));

            ajaxReturn(array('code'=>'200','msg'=>'订单创建成功','control'=>'ajaxDefray'));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'订单创建失败','control'=>'ajaxDefray'));
        }
    }
    //区域信息
    public function testOp(){
        $groupInfo = calc_group($_GET['id'],$_GET['periods']);
        p($groupInfo);
        var_dump(randomUp(4,0));
        var_dump(random(4,1));
        exit();
        $db_area = Model('area');
        $area = array();
        $list1 = $db_area->field('area_name as name,area_id as code')->where('area_deep=1')->select();
        foreach ($list1 as $key=>$val) {
            $list2 = $db_area->field('area_name as name,area_id as code')->where('area_deep=2 and area_parent_id='.$val['code'])->select();
            foreach ($list2 as $k => $v) {
                $list3 = $db_area->field('area_name as name,area_id as code')->where('area_deep=3 and area_parent_id='.$v['code'])->select();
                $list2[$k]['sub'] = $list3;
            }
            // $area['name'] = $val['area_name'];
            // $area['code'] = $val['area_id'];
            $list1[$key]['sub'] = $list2;
        }
        p(json_encode($list1));
        //var_dump(file_put_content('area.json',json_encode($list1)));
        $handle = fopen('area.json', 'w+');
        if ($handle === false) echo 'string';
        fwrite($handle,json_encode($list1));
        fclose($handle);
    }
}