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
    //推荐活动分页数据
    public function listPageOp(){
    	if(!isAjax())
    		ajaxReturn(array('code'=>'0','msg'=>'使用ajax提交','control'=>'listPage'));
		$pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:3;
        $db_activity = new Model('bbs_activity');
        //活动时间状态
        $activityTime = !empty($_POST['time'])?$_POST['time']:'ing';
        //活动类型
        $cls_id = !empty($_POST['cls_id'])?$_POST['cls_id']:'';
        //推荐活动
        $is_recommend = !empty($_POST['recommend'])?$_POST['recommend']:'';
        $map = array();
        //还没有结束的活动
        //if($activityTime == 'ing')
            //$map['activity_end_time'] = array('gt',time()); 
        //活动类型 
        if(!empty($cls_id))
            $map['cls_id'] = array('eq',$cls_id);
        if($is_recommend != '')
            $map['is_recommend'] = array('eq',1);
        //$_GET['curpage'] = 2;
        if(!empty($_POST['keyword']))
            $map['activity_title'] = array('like','%'.$_POST['keyword'].'%');
        $order = !empty($_POST['order'])?$_POST['order']:'activity_begin_time desc,activity_click desc';
        $count = $db_activity->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage'));
        //$field = 'id,activity_no,activity_periods,activity_title,activity_ptitle,activity_index_pic,activity_tag,activity_city,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
        $member_id = $_SESSION['userInfo']['id']?$_SESSION['userInfo']['id']:1;
        $list = array();
        $list = $db_activity
                ->table('bbs_activity,bbs_collect')
        		->field('bbs_activity.*,bbs_collect.member_id')
        		->where($map)
                ->join('left')
                ->on('bbs_activity.activity_no=bbs_collect.activity_no and bbs_activity.activity_periods=bbs_collect.activity_periods and bbs_collect.member_id='.$member_id)
        		->order($order)
        		->page($pageSize)
        		->select();
	    //p($db_activity->showpage());
        //p($list);
        if(!empty($list)){
            foreach ($list as &$val) {
                //$val['activity_title'] = mb_substr($val['activity_title'], 0,6,'utf-8');
                $val['activity_time'] = (date('Ymd',$val['activity_begin_time'])==date('Ymd',$val['activity_end_time']))?date('n月j日',$val['activity_begin_time']).'一天':(date('n月j日',$val['activity_begin_time']).'~'.date('n月j日',$val['activity_end_time']));
                $val['url1'] = urlBBS('activity','collect',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['age'] = $val['min_age'].'-'.$val['max_age'];
                $val['city'] = getAreaName($val['activity_city']);
                $url = urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['url'] = $url;
                $val['activity_tag'] = '';
                $num = (int)$val['total_number']-(int)$val['already_num'];
                if($num == 0){
                    $val['top'] = '<div class="Prompt text-right"><span>已经满额<span></div>';
                    //$val['footer'] = '<button class="pro_btn btn_isabled" disabled="disabled">已售罄</button>';
                }else if($num < 5){
                    $val['top'] = '<div class="Prompt text-right"><span>即将满额<span></div>';
                    //$val['footer'] = '<button class="pro_btn" href_url="'.$url.'">去订票</button>';
                }else{
                    //echo 'string';exit();
                    $val['top'] = '';
                    //$val['footer'] = '<button class="pro_btn" href_url="'.$url.'">去订票</button>';
                }
                //查看活动状态
                if($val['activity_begin_time'] > time()){
                    $val['footer'] = '<button class="pro_btn" href_url="'.$url.'">未开始</button>';
                }else if($val['activity_begin_time'] < time() && $val['activity_end_time'] > time()){
                    $val['footer'] = '<button class="pro_btn" href_url="'.$url.'">进行中</button>';
                }else if($val['activity_end_time'] < time()){
                    $val['footer'] = '<button class="pro_btn btn_isabled" href_url="'.$url.'" >已结束</button>';
                }
                //查看是否收藏
                // $db_collect = new Model('bbs_collect');
                // $map = array();
                // $map['activity_no'] = array('eq',$val['activity_no']);
                // $map['activity_periods'] = array('eq',$val['activity_periods']);
                // $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
                // if($db_collect->where($map)->find())
                //     $val['collect'] = 1;
                if(!empty($val['member_id']) && $val['member_id'] == $_SESSION['userInfo']['id'])
                    $val['collect'] = 1;
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
        $pageSize = !empty($_POST['pageSize'])?$_POST['pageSize']:3;
        $db_activity = new Model('bbs_activity_periods');
        $map = array();
        //活动时间状态
        $activityTime = !empty($_POST['time'])?$_POST['time']:'past';
        //活动类型
        $cls_id = !empty($_POST['cls_id'])?$_POST['cls_id']:'';
        //已经结束的活动
        if($activityTime == 'past')
            $map['activity_end_time'] = array('lt',time());
        //按月份刷选活动
        if($activityTime == 'month'){
            $month = $_POST['month'];
            //这个月的第一天
            $firstday = date('Y',time()).'-'.$month.'-'.'1';
            //这个月的最后一天
            $lastday = date('Y-n-j', strtotime("$firstday +1 month -1 day"));
            //var_dump($firstday);var_dump($lastday);
            $map['activity_begin_time'] = array('between',strtotime($firstday).','.strtotime($lastday));
        }
        //活动类型 
        if(!empty($cls_id))
            $map['cls_id'] = array('eq',$cls_id);
        //$_GET['curpage'] = 2;
        //关键字
        if(!empty($_POST['keyword']))
            $map['activity_title'] = array('like','%'.$_POST['keyword'].'%'); 
        $count = $db_activity->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'listPage','count'=>$count));
        //$field = 'id,activity_title,activity_no,activity_periods,activity_index_pic,activity_tag,activity_city,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
        /*先找到最后一期的activity_no和activity_periods，再按这个查找数据，得到相同活动里面最后一期的数据 start*/
        $data = $db_activity
                ->field('activity_no,MAX(activity_periods) activity_periods,activity_begin_time')
                ->where($map)
                ->page($pageSize)
                ->group('activity_no')
                ->order('activity_begin_time desc')
                ->select();
        //p($data);
        $list = array();
        foreach ($data as $val) {
            $map = array();
            $map['activity_no'] = array('eq',$val['activity_no']);
            $map['activity_periods'] = array('eq',$val['activity_periods']);
            $list[] = $db_activity->where($map)->find();
        }
        //p($list);
        /*先找到最后一期的activity_no和activity_periods，再按这个查找数据，得到相同活动里面最后一期的数据 end*/
        //p($db_activity->showpage());
        //p($list);
        if(!empty($list)){
            foreach ($list as &$val) {
                //$val['activity_title'] = mb_substr($val['activity_title'], 0,6,'utf-8');
                $val['activity_time'] = (date('Ymd',$val['activity_begin_time'])==date('Ymd',$val['activity_end_time']))?date('n月j日',$val['activity_begin_time']).'一天':(date('n月j日',$val['activity_begin_time']).'~'.date('n月j日',$val['activity_end_time']));
                $val['url'] = urlBBS('activity','collect',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['url1'] = urlBBS('activity','pastDetail',array('id'=>$val['id']));
                $val['url2'] = urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['age'] = $val['min_age'].'-'.$val['max_age'];
                $val['city'] = getAreaName($val['activity_city']); 
                $val['activity_tag'] = '';
                //查看活动状态
                if($val['activity_begin_time'] > time()){
                    $val['footer'] = '未开始';
                }else if($val['activity_begin_time'] < time() && $val['activity_end_time'] > time()){
                    $val['footer'] = '进行中';
                }else if($val['activity_end_time'] < time()){
                    $val['footer'] = '已结束';
                } 
                // 查看是否收藏
                $db_collect = new Model('bbs_collect');
                $map = array();
                $map['activity_no'] = array('eq',$val['activity_no']);
                $map['activity_periods'] = array('eq',$val['activity_periods']);
                $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
                if($db_collect->where($map)->find())
                    $val['collect'] = 1;
                // if(!empty($val['member_id']) && $val['member_id'] == $_SESSION['userInfo']['id'])
                //     $val['collect'] = 1;
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
            showMessage('参数错误',getenv(HTTP_REFERER));
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $info = $db_activity->where($map)->find();
        if(empty($info))
            $info = $db_activity_periods->where($map)->find();
        if(empty($info))
            showMessage('活动不存在',getenv(HTTP_REFERER));
        //活动轮播图
        $db_banner = new Model('bbs_uploads');
        $banner = $db_banner->where('upload_type=1 and item_id='.$info['activity_no'])->select();
        //p($banner);
        //活动详情
        $info['activity_desc'] = htmlspecialchars_decode($info['activity_desc']);
        //活动时间
        if(date('Ymd',$info['activity_begin_time']) == date('Ymd',$info['activity_end_time']))
            $info['activity_time'] = date('n月j日',$info['activity_begin_time']).'一天';
        else
            $info['activity_time'] = date('n月j日',$info['activity_begin_time']).'~'.date('n月j日',$info['activity_end_time']);
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
        $map['id'] = array('neq',$info['id']);
        $map['activity_end_time'] = array('gt',time());
        $field = 'id,activity_title,activity_no,activity_periods,activity_index_pic,activity_tag,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price,activity_city';
        $list = $db_activity
                //->table('bbs_activity,bbs_collect')
                ->field($field)
                ->where($map)
                //->join('left')
                //->on('bbs_activity.activity_no=bbs_collect.activity_no and bbs_activity.activity_periods=bbs_collect.activity_periods and member_id='.$_SESSION['userInfo']['id'])
                ->order('activity_begin_time,activity_click desc')
                ->limit(2)
                ->select();
        //p($list);
        foreach ($list as &$val) {
            $map = array();
            $map['activity_periods'] = array('eq',$val['activity_periods']);
            $map['activity_no'] = array('eq',$val['activity_no']);
            $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
            //查看是否收藏
            if($db_collect->where($map)->find())
                $val['collect'] = 1;
            $val['activity_time'] = (date('Ymd',$val['activity_begin_time'])==date('Ymd',$val['activity_end_time']))?date('n月j日',$val['activity_begin_time']).'一天':(date('n月j日',$val['activity_begin_time']).'~'.date('n月j日',$val['activity_end_time']));
        }
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
            showMessage('id不能为空',getenv(HTTP_REFERER));
        $db_activity_periods = Model('bbs_activity_periods');
        $info = $db_activity_periods->where('id='.$id)->find();
        if(empty($info))
            showMessage('活动不存在',getenv(HTTP_REFERER));
        //活动轮播图
        $db_banner = new Model('bbs_uploads');
        $banner = $db_banner->where('upload_type=1 and item_id='.$info['activity_no'])->select();
        //p($banner);
        //活动详情
        $info['activity_desc'] = htmlspecialchars_decode($info['activity_desc']);
        //点击量加1
        $update = array();
        $update['activity_click'] = array('exp','activity_click+1');
        $db_activity_periods->where('id='.$id)->update($update);
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
        //查看是否收藏
        $db_collect = new Model('bbs_collect');
        $map = array();
        $map['activity_no'] = array('eq',$info['activity_no']);
        $map['activity_periods'] = array('eq',$info['activity_periods']);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        if($db_collect->where($map)->find())
            $info['collect'] = 1;
        // p($groupInfo);
        // p($group_arr);
        //评论
        $db_comment = new Model('bbs_comment');
        $map = array();
        $map['activity_no'] = $info['activity_no'];
        $map['activity_periods'] = $info['activity_periods'];
        $map['type'] = 1;
        $list = $db_comment->where($map)->select();
        //回复
        $map['type'] = 2;
        foreach ($list as $key => $val) {
            $map['pid'] = $val['id'];
            $list[$key]['data'] = $db_comment->where($map)->order('add_time')->select();
        }
        //p($list);
        Tpl::output('list',$list);
        Tpl::output('banner',$banner);
        Tpl::output('info',$info);
        Tpl::output('groupInfo',$groupInfo['data']);
        Tpl::output('group_arr',$group_arr);
        Tpl::setLayout("common_login_layout");
    	Tpl::showpage("past_detail");
    }
    //收藏活动
    public function collectOp(){
        if(!isAjax())
            ajaxReturn(array('code'=>'0','msg'=>'请求方式错误','control'=>'collect'));
        if(empty($_SESSION['is_user_login']))
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
            $info = $db_activity_periods->where($map)->find();
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
            $data['add_time'] = time();
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
        //查询活动类型
        $db_cls = new Model('bbs_cls');
        $list = $db_cls->select(); 
        Tpl::output('list',$list);
        Tpl::setLayout('common_login_layout');
    	Tpl::showpage("activity_type");
    }
    //活动类型介绍
    public function introduceOp(){
        $db_cls = new Model('bbs_cls');
        $info = $db_cls->where('id='.$_GET['id'])->find(); 
        if(empty($info))
            showMessage('活动类型不存在',getenv(HTTP_REFERER));
        Tpl::output('info',$info);
        Tpl::setLayout('common_login_layout');
        Tpl::showpage("nature_teach");
    }
    //宝贝视频
    public function hotActivityOp(){
    	Tpl::showpage("activity_hot");
    }
    //活动排期
    public function arrangeOp(){
        Tpl::setLayout('common_login_layout');
    	Tpl::showpage("arrange");
    }
    //明星领队
    public function starLeaderOp(){
        //查带的孩子最多的老师，前九名
        $db_user = new Model();
        $list = $db_user
                ->table('bbs_user,bbs_apply')
                ->field('bbs_user.id,bbs_user.nick_name,bbs_user.member_name,bbs_user.headimgurl,count(bbs_apply.id) as num')
                ->where('bbs_user.is_teacher=1')
                ->join('left')
                ->on('bbs_user.id = bbs_apply.teacher_id')
                ->group('bbs_user.id')
                ->order('num desc')
                ->limit(9)
                ->select();
        //p($list);
        Tpl::output('list',$list);
        Tpl::setLayout('common_login_layout');
    	Tpl::showpage("star_leader");
    }
    //领队详情
    public function leaderDetailOp(){
        $id = $_GET['id'];
        if(empty($id))
            $this->showMessage('参数错误',getenv(HTTP_REFERER));
        $db_user = new Model('bbs_user');
        $info = $db_user->where('is_teacher=1 and id='.$id)->find();
        if(empty($info))
            $this->showMessage('领队不存在',getenv(HTTP_REFERER));
        //带儿童数量
        $db_apply = new Model('bbs_apply');
        $map = array();
        $childCount = $db_apply->where('teacher_id='.$info['id'])->count();
        //参加活动次数
        $activityCount = $db_apply
                        ->where('teacher_id='.$info['id'])
                        ->group('activity_no,activity_periods')
                        ->count();
        //p($childCount);p($activityCount);
        //用户等级
        $level = get_member_level($info['id']);
        Tpl::output('info',$info);
        Tpl::output('childCount',$childCount);
        Tpl::output('activityCount',$activityCount);
        Tpl::output('level',$level);
        Tpl::setLayout('common_login_layout');
        Tpl::showpage('leader_detail');
    }
    //小组成员
    public function memberOp(){
        $activity_no = $_GET['activity_no'];
        $activity_periods = $_GET['activity_periods'];
        $group_id = $_GET['group_id'];
        if(empty($activity_no) || empty($activity_periods) || empty($group_id))
            showMessage('参数错误',getenv(HTTP_REFERER));
        //查小组成员
        $db_apply = new Model();
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $map['group_id'] = array('eq',$group_id);
        $list = $db_apply
                ->field('teacher_id,teacher_name,child_name,child_headimgurl,headimgurl')
                ->table('bbs_apply,bbs_user')
                ->join('left')
                ->on('bbs_user.id = bbs_apply.teacher_id')
                ->where($map)->select();
        //p($list);
        Tpl::output('list',$list);
        Tpl::setLayout('common_login_layout');
        Tpl::showpage("member");
    }
    //活动报名页面
    public function defrayOp(){
        $activity_no = $_GET['activity_no'];
        $activity_periods = $_GET['activity_periods'];
        if(empty($activity_no) || empty($activity_periods))
            showMessage('参数错误',getenv(HTTP_REFERER));
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $info = $db_activity->where($map)->find();
        if(empty($info))
            $info = $db_activity_periods->where($map)->find();
        if(empty($info))
            showMessage('活动不存在',getenv(HTTP_REFERER));
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
        $data['activity_time'] = ($info['activity_begin_time']==$info['activity_end_time'])?date('n月j日',$info['activity_begin_time']).'一天':(date('n月j日',$info['activity_begin_time']).'~'.date('n月j日',$info['activity_end_time']));
        $data['activity_begin_time'] = $info['activity_begin_time'];
        $data['activity_end_time'] = $info['activity_end_time'];
        $data['activity_address'] = getAreaName($info['activity_province']).getAreaName($info['activity_city']).getAreaName($info['activity_area']).$info['address'];
        $data['activity_cls_id'] = $info['cls_id'];
        $data['member_id'] = $_SESSION['userInfo']['id'];
        $data['member_name'] = $_SESSION['userInfo']['member_name'];
        $data['order_num'] = count($_POST['students']);
        $data['order_amount'] = floatval($info['activity_price'])*count($_POST['students']);
        $data['order_time'] = time();
        $data['order_status'] = 1;
        $data['childs_arr'] = serialize($_POST['students']);
        $data['parents_arr'] = serialize($_POST['parents']);
        $data['remark'] = $_POST['remark'];
        $pay_no = 'HSN_'.date("YmdHis").mt_rand(100,999);
        $data['pay_no'] = $pay_no;
        // p($data);
        $result = $db_order->insert($data);
        //p($data);
        if($result){
            //成功后跳转到微信
            //header("Location: ".urlBBS('order','pay_wx',array('id'=>$result)));
            ajaxReturn(array('code'=>'200','msg'=>'跳转到微信支付','url'=>urlBBS('order','pay_wx',array('id'=>$result))));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'订单创建失败','control'=>'ajaxDefray'));
        }
    }
    //加载评论数据
    public function commentListOp(){
        $id = $_POST['id'];
        $db_activity_periods = new Model('bbs_activity_periods');
        $info = $db_activity_periods->where(array('id'=>$id))->find();
        if(empty($info))
            ajaxReturn(array('code'=>0,'msg'=>'评论加载失败','control'=>'commentList'));
        $pageSize = $_POST['pageSize']?$_POST['pageSize']:3;
        $db_comment = new Model('bbs_comment');
        //查评论
        $map = array();
        $map['activity_no'] = $info['activity_no'];
        $map['activity_periods'] = $info['activity_periods'];
        $map['pid'] = 0;
        $map['type'] = 1;
        $count = $db_comment->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>0,'msg'=>'暂无数据','control'=>'commentList'));

        $comment_list = $db_comment->where($map)->order('add_time')->page($pageSize)->select();
        //查回复
        $map['type'] = 2;     
        foreach ($comment_list as $key=>&$val) {
            $map['pid'] = $val['id'];
            $val['add_time'] = date("Y-m-d H:i",$val['add_time']);
            // $comment_list[$key]['replay'] = $db_comment->where($map)->order('add_time')->select();
            $comment_list[$key]['replay'] = $this->getChild($val['id']);
        }
        if(!empty($comment_list))
            ajaxReturn(array('code'=>200,'加载数据','comment_list'=>$comment_list));
        else
            ajaxReturn(array('code'=>0,'暂无数据','comment_list'=>$comment_list));
    }
    //查询所有子集回复
    function getChild($pid=0,$list = array(),$level = 0){
        $db_comment = new Model('bbs_comment');
        $data = $db_comment->where('type=2 and pid='.$pid)->select();
        //p($data);
        //判断程序执行的条件
        if(!empty($data) && $level<20){
            //递归调用，得到下一级的节点集
            foreach($data as $key=>$value){
                $list[] = $value;
                $pid = $value['id'];
                $next_level = $level+1;
                $list = $this->getChild($pid,$list,$next_level);
            }
        }
        return $list;  
    }
    //评论
    public function commentOp(){
        if(empty($_SESSION['is_user_login']))
            ajaxReturn(array('code'=>0,'msg'=>'请先登录'));
        if(empty($_POST['id']))
            ajaxReturn(array('code'=>0,'msg'=>'参数错误','control'=>'comment'));
        if(empty($_POST['content']))
            ajaxReturn(array('code'=>0,'msg'=>'内容不能为空','control'=>'comment'));
        $db_activity_periods = new Model('bbs_activity_periods');
        $info = $db_activity_periods->where(array('id'=>$_POST['id']))->find();
        if(empty($info))
            ajaxReturn(array('code'=>0,'msg'=>'活动不存在','control'=>'comment'));
        $db_comment = new Model('bbs_comment');
        $data = array();
        $data['activity_no'] = $info['activity_no'];
        $data['activity_periods'] = $info['activity_periods'];
        $data['comment_id'] = $_SESSION['userInfo']['id']?$_SESSION['userInfo']['id']:0;
        $data['comment_name'] = $_SESSION['userInfo']['id']?$_SESSION['userInfo']['nick_name']:'游客';
        $data['comment_pic'] = $_SESSION['userInfo']['headimgurl']?$_SESSION['userInfo']['headimgurl']:BBS_SITE_URL.'/resource/bootstrap/img/logo.png';
        $data['content'] = $_POST['content'];
        $data['pid'] = 0;
        $data['type'] = 1;
        $data['grade'] = $_POST['grade'];
        $data['add_time'] = time();
        $result = $db_comment->insert($data);
        if($result){
            $data['id'] = $result;
            $data['add_time'] = date('Y-m-d H:i',$data['add_time']);
            ajaxReturn(array('code'=>200,'msg'=>'评论成功','control'=>'comment','info'=>$data));
        }else{
            ajaxReturn(array('code'=>0,'msg'=>'评论失败','control'=>'comment'));
        }
    }
    //回复
    public function replayOp(){
        if(empty($_SESSION['is_user_login']))
            ajaxReturn(array('code'=>0,'msg'=>'请先登录'));
        if(empty($_POST['id']))
            ajaxReturn(array('code'=>0,'msg'=>'参数错误','control'=>'replay'));
        if(empty($_POST['content']))
            ajaxReturn(array('code'=>0,'msg'=>'内容不能为空','control'=>'replay'));
        $db_comment = new Model('bbs_comment');
        $info = $db_comment->where('id='.$_POST['id'])->find();
        if(empty($info))
            ajaxReturn(array('code'=>0,'msg'=>'评论不存在','control'=>'replay'));
        if($info['comment_id'] == $_SESSION['userInfo']['id'])
            ajaxReturn(array('code'=>0,'msg'=>'自己不能回复自己','control'=>'replay'));
        $data = array();
        $data['activity_no'] = $info['activity_no'];
        $data['activity_periods'] = $info['activity_periods'];
        $data['comment_id'] = $_SESSION['userInfo']['id'];
        $data['comment_name'] = $_SESSION['userInfo']['nick_name']?$_SESSION['userInfo']['nick_name']:$_SESSION['userInfo']['member_name'];
        $data['comment_pic'] = $_SESSION['userInfo']['headimgurl']?$_SESSION['userInfo']['headimgurl']:BBS_SITE_URL.'/resource/bootstrap/img/logo.png';
        $data['content'] = $_POST['content'];
        $data['replay_id'] = $_POST['replay_id'];//被回复人id
        $data['replay_name'] = $_POST['replay_name'];//被回复人名字
        $data['pid'] = $_POST['id'];
        $data['type'] = 2;
        $data['add_time'] = time();
        $result = $db_comment->insert($data);
        if($result){
            $data['id'] = $result;
            $data['add_time'] = date('Y-m-d H:i',$data['add_time']);
            ajaxReturn(array('code'=>200,'msg'=>'回复成功','control'=>'replay','info'=>$data));
        }else{
            ajaxReturn(array('code'=>0,'msg'=>'回复失败','control'=>'replay'));
        }
    }
    //协议页面
    public function pactOp(){
        Tpl::showpage('pact');
    }
    //区域信息
    public function testOp(){
        // $db_order = Model('bbs_apply');
        // $db_order->afterPay($_GET['id']);
        // exit();
        $wx_api_path = BASE_DATA_PATH.DS."api".DS."payment".DS."wxpay_jsapi".DS;
        //        p($wx_api_path);
        include($wx_api_path."wxpay_jsapi.php");
        $wx_pay = new wxpay_jsapi();
        $order_pay_no = 'hsn_'.date("YmdHis");//订单支付编码
        $wx_pay->setConfig('orderSn',$order_pay_no);
        $wx_pay->setConfig('orderInfo','测试微信支付');
        $wx_pay->setConfig('orderFee',1);
        echo($wx_pay->paymentHtml());
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