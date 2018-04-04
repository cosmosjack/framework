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
        $db_activity = Model('bbs_activity');
        $map = array();
        //$map['is_recommend'] = array('eq',1);
        //$_GET['curpage'] = 2;
        $count = $db_activity->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));
        $field = 'id,activity_title,activity_index_pic,activity_tag,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
        $list = array();
        $list = $db_activity
        		->field($field)
        		->where($map)
        		->order('activity_click desc')
        		->page($pageSize)
        		->select();
	    //p($db_activity->showpage());
        //p($list);
        if(!empty($list)){
            foreach ($list as &$val) {
                $val['activity_title'] = mb_substr($val['activity_title'], 0,6,'utf-8');
                $val['activity_time'] = (date('Ymd',$val['activity_begin_time'])==date('Ymd',$val['activity_end_time']))?date('m月d日',$val['activity_begin_time']).'一天':(date('m月d日',$val['activity_begin_time']).'~'.date('m月d日',$val['activity_end_time']));
                $val['url1'] = urlBBS('activity','detail',array('id'=>$val['id']));
                $url = urlBBS('activity','defray',array('id'=>$val['id']));
                $num = (int)$val['total_number']-(int)$val['already_num'];
                if($num == 0){
                    $val['top'] = '<div class="col-xs-10 col-xs-offset-1 Prompt text-right"><span>已经满额<span></div>';
                    $val['footer'] = '<button class="pro_btn btn_isabled" disabled="disabled">已售罄</button>';
                }else if($num < 5){
                    $val['top'] = '<div class="col-xs-10 col-xs-offset-1 Prompt text-right"><span>即将满额<span></div>';
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
    //正在进行的活动详情
    public function detailOp(){
        //p($_GET['id']);
        $id = $_GET['id'];
        if(empty($id))
            showMessage('id不能为空',urlBBS());
        $db_activity = Model('bbs_activity');
        $info = $db_activity->where('id='.$id)->find();
        if(empty($info))
            showMessage('活动不存在',urlBBS());
        //活动轮播图
        $db_banner = new Model('bbs_uploads');
        $banner = $db_banner->where('upload_type=1 and item_id='.$info['id'])->select();
        //活动详情
        $info['activity_desc'] = htmlspecialchars_decode($info['activity_desc']);
        //活动时间
        if(date('Ymd',$info['activity_begin_time']) == date('Ymd',$info['activity_end_time']))
            $info['activity_time'] = date('m月d日',$info['activity_begin_time']).'一天';
        else
            $info['activity_time'] = date('m月d日',$info['activity_begin_time']).'~'.date('m月d日',$info['activity_end_time']);
        //推荐活动
        $map = array();
        $field = 'id,activity_title,activity_index_pic,activity_tag,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
        $list = $db_activity
                ->field($field)
                ->where($map)
                ->order('activity_click desc,activity_begin_time')
                ->limit(2)
                ->select();
        //p($info);p($list);p($banner);
        Tpl::output('info',$info);
        Tpl::output('banner',$banner);
        Tpl::output('list',$list);
        Tpl::setLayout("common_login_layout");
    	Tpl::showpage("recom_active");
    }
    //往期活动详情
    public function pastDetailOp(){
    	Tpl::showpage("past_detail");
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
        //p($_GET['id']);
        $id = $_GET['id'];
        if(empty($id))
            showMessage('id不能为空',urlBBS());
        $db_activity = Model('bbs_activity');
        $info = $db_activity->where('id='.$id)->find();
        if(empty($info))
            showMessage('活动不存在',urlBBS());
        //查询活动场次
        $db_activity_periods = new Model('bbs_activity_periods');
        $map = array();
        $map['activity_periods'] = array('neq',$info['activity_periods']);
        $map['activity_no'] = array('eq',$info['activity_no']);
        $map['activity_begin_time'] = array('gt',time());
        $periods = $db_activity_periods
                    ->field('id,activity_no,activity_begin_time,activity_end_time')
                    ->where($map)
                    ->order('activity_begin_time')
                    ->select();
        // p($periods);
        // p($info);
        $info['address'] = getAreaName($info['activity_province']).getAreaName($info['activity_city']).getAreaName($info['activity_area']).$info['address'];
        Tpl::output('info',$info);
        Tpl::output('periods',$periods);
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
        if(!empty($_POST['period'])){
            $db_activity_periods = new Model('bbs_activity_periods');
            $map = array();
            $map['id'] = array('eq',$_POST['period']);
            //$map['activity_no'] = array('eq',$_POST['activity_no']);
            $info = $db_activity_periods->where($map)->find();
            if(empty($info))
                ajaxReturn(array('code'=>'0','msg'=>'活动不存在','control'=>'ajaxDefray'));
        }else{
            $db_activity = new Model('bbs_activity');
            $map = array();
            $map['id'] = array('eq',$_POST['activityId']);
            //$map['activity_no'] = array('eq',$_POST['activity_no']);
            $info = $db_activity->where($map)->find();
            if(empty($info))
                ajaxReturn(array('code'=>'0','msg'=>'活动不存在','control'=>'ajaxDefray'));
        }
        //活动是否结束
        if($info['activity_end_time'] < time())
            ajaxReturn(array('code'=>'0','msg'=>'活动已结束','control'=>'ajaxDefray'));
        //活动开始前一天才可以报名
        if($info['activity_begin_time']-3600*24 < time())
            ajaxReturn(array('code'=>'0','msg'=>'活动开始前一天才可以报名哦','control'=>'ajaxDefray'));
        //人数限制
        if($info['already_num'] >= $info['total_number'])
            ajaxReturn(array('code'=>'0','msg'=>'报名人数已满,请选择其他活动','control'=>'ajaxDefray'));
        $db_order = new Model('bbs_order');
        //查看是否报名
        $map = array();
        $map['activity_no'] = array('eq',$info['activity_no']);
        $map['activity_periods'] = array('eq',$info['activity_periods']);
        $map['member_id'] = $_SESSION['userInfo']['id'];
        if($db_order->where($map)->field('id')->find())
            ajaxReturn(array('code'=>'0','msg'=>'您已经报过名了','control'=>'ajaxDefray'));
        //exit('111');
        $data = array();
        $data['code'] = randomUp(8,0);//确认码，随机英文大写加数字
        $data['activity_no'] = $info['activity_no'];
        $data['activity_title'] = $info['activity_title'];
        $data['activity_periods'] = $info['activity_periods'];
        $data['activity_time'] = ($info['activity_begin_time']==$info['activity_end_time'])?date('m月d日',$info['activity_begin_time']).'一天':(date('m月d日',$info['activity_begin_time']).'~'.date('m月d日',$info['activity_end_time']));
        $data['activity_address'] = getAreaName($info['activity_province']).getAreaName($info['activity_city']).getAreaName($info['activity_area']).$info['address'];
        $data['member_id'] = $_SESSION['userInfo']['id'];
        $data['member_name'] = $_SESSION['userInfo']['member_name'];
        $data['order_amount'] = floatval($info['activity_price'])*count($_POST['students']);
        $data['order_time'] = time();
        $data['order_status'] = 1;
        $data['childs_arr'] = serialize($_POST['students']);
        $data['parents_arr'] = serialize($_POST['parents']);
        $data['remark'] = $_POST['remark'];
        $result = $db_order->insert($data);
        //p($data);
        if($result){
            //修改活动表
            if(!empty($_POST['period'])){
                $update = array();
                $update['already_num'] = array('exp','already_num+1');
                $db_activity_periods->where('id='.$_POST['period'])->update($update);
            }else{
                $update = array();
                $update['already_num'] = array('exp','already_num+1');
                $db_activity->where('id='.$_POST['activityId'])->update($update);
                $db_activity_periods = new Model('bbs_activity_periods');
                $map = array();
                $map['activity_no'] = $info['activity_no'];
                $map['activity_periods'] = $info['activity_periods'];
                $db_activity_periods->where($map)->update($update);
            }
            ajaxReturn(array('code'=>'200','msg'=>'订单创建成功','control'=>'ajaxDefray'));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'订单创建失败','control'=>'ajaxDefray'));
        }
    }
    //区域信息
    public function testOp(){
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