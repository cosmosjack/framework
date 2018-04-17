<?php
/**
 *
 *	我的个人中心控制器
 *	Create by :杨奇林
 *  time:201803.21
 *  qq:928944169
 */
class mineControl extends BaseControl{

    public function __construct(){
        parent::__construct();
        Tpl::setLayout("common_login_layout");
        $this->checkLogin();
    }
    //首页
    public function indexOp(){
        Tpl::setLayout("common_layout");
    	//查询最新的用户信息
    	$db_user = new Model('bbs_user');
    	$info = $db_user->where('id='.$_SESSION['is_login'])->find();
    	//p($info);
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$info['id']);
        //$map['order_status'] = array('eq',3);
        //查询成长记录总数,查参加活动的订单总数
        $growCount = $db_order->where($map)->count();
        //成长相册数量
        $albumCount = 0;
        $list = $db_order->where($map)->field('activity_no,activity_periods')->select();
        $db_album = new Model('bbs_album');
        //p($list);
        foreach ($list as $val) {
            $map = array();
            $map['activity_no'] = array('eq',$val['activity_no']);
            //$map['activity_periods'] = array('eq',$val['activity_periods']);
            $count = $db_album->where($map)->count();
            $albumCount += $count;
        }
        
        //我的收藏
        $db_collect = new Model('bbs_collect');
        $map = array();
        $map['member_id'] = array('eq',$info['id']);
        $collectCount = $db_collect->where($map)->count();
        Tpl::output("info",$info);
        Tpl::output("albumCount",$albumCount);
        Tpl::output("growCount",$growCount);
        Tpl::output("collectCount",$collectCount);
        Tpl::showpage("mine");
    }
    //我的相册
    public function albumOp(){
        if(!isAjax()){
            Tpl::showpage('my_album');
            exit();
        }
        //参加的活动,查bbs_order
        $pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:6;
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        //$map['order_status'] = array('eq',3);
        $count = $db_order->where($map)->group('activity_no')->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'album'));
        $list = $db_order
                ->field('activity_no,activity_periods,activity_title,activity_index_pic,order_time')
                ->where($map)
                ->order('order_time desc')
                ->group('activity_no')
                ->page($pageSize)
                ->select();
        if(!empty($list)){
            $db_album = new Model('bbs_album');
            foreach ($list as &$val) {
                $map = array();
                $map['upload_type'] = array('eq',1);
                $map['activity_no'] = array('eq',$val['activity_no']);
                //$map['activity_periods'] = array('eq',$val['activity_periods']);//测试需要，暂时屏蔽
                $val['count'] = $db_album->where($map)->count();
                $val['url'] = urlBBS('mine','photo',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['time'] = date('Y-m-d',$val['order_time']);
                // $info = $db_uploads
                //         ->where($map)
                //         ->field('file_name')
                //         ->order('upload_time desc')
                //         ->find();
                // $val['img'] = $info['file_name'];
            }
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'album','list'=>$list));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'album'));
        }

    }
    //相片
    public function photoOp(){
        if(!isAjax()){
            //查询活动详情
            $activity_no = $_GET['activity_no'];
            $activity_periods = $_GET['activity_periods'];
            // $db_activity = new Model('bbs_activity');
            // $db_activity_periods = new Model('bbs_activity_periods');
            // $map = array();
            // $map['activity_no'] = array('eq',$activity_no);
            // $map['activity_periods'] = array('eq',$activity_periods);
            // $info = $db_activity->where($map)->field('activity_no,activity_periods,activity_title')->find();
            // //p($info);p($map);exit();
            // if(empty($info)){
            //     $info = $db_activity_periods
            //             ->where($map)
            //             ->field('activity_no,activity_periods,activity_title')
            //             ->find();
            // }
            // if(empty($info))
            //     showMessage('活动不存在',urlBBS('mine','album'));
            // Tpl::output('info',$info);
            // 查活动的领队
            $db_apply = new Model('bbs_apply');
            $map = array();
            $map['activity_no'] = array('eq',$activity_no);
            $map['activity_periods'] = array('eq',$activity_periods);
            $teacherList = $db_apply->where($map)->field('teacher_id')->group('teacher_id')->select(); 
            $ids = array_column($teacherList,'teacher_id');
            Tpl::output('activity_no',$activity_no);
            Tpl::output('activity_periods',$activity_periods);
            Tpl::output('ids',$ids);
            Tpl::showpage('photo_album');
            exit();
        }
        $activity_no = $_POST['activity_no'];
        $activity_periods = $_POST['activity_periods'];
        if(empty($activity_no) || empty($activity_periods))
            ajaxReturn(array('code'=>'0','msg'=>'参数错误','control'=>'photo'));
        $pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:10;
        $db_album = new Model('bbs_album');
        $map = array();
        $map['upload_type'] = array('eq',1);
        $map['activity_no'] = array('eq',$activity_no);
        //$map['activity_periods'] = array('eq',$val['activity_periods']);//测试需要，暂时屏蔽
        $count = $db_album->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'photo'));
        $list = $db_album
                ->field('file_name,activity_no,upload_time')
                ->where($map)
                ->order('upload_time desc')
                ->page($pageSize)
                ->select();
        if(!empty($list))
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'photo','list'=>$list));
        else
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'photo'));
    }
    //上传图片
    public function uploadImgOp(){
        //当前的活动
        $activity_no = $_GET['activity_no'];
        $activity_periods = $_GET['activity_periods'];
        //$activity_title = $_GET['activity_title'];
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $info = $db_activity->where($map)->field('activity_no,activity_periods,activity_title')->find();
        //p($info);p($map);exit();
        if(empty($info)){
            $info = $db_activity_periods
                    ->where($map)
                    ->field('activity_no,activity_periods,activity_title')
                    ->find();
        }
        //参加的活动,查bbs_order
        // $db_order = new Model('bbs_order');
        // $map = array();
        // $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        // //$map['order_status'] = array('eq',3);
        // $list = $db_order
        //         ->field('activity_title,activity_no,activity_periods')
        //         ->where($map)
        //         ->group('activity_no')
        //         ->select();
        Tpl::output('activity_no',$activity_no);
        Tpl::output('activity_periods',$activity_periods);
        Tpl::output('activity_title',$info['activity_title']);
        // Tpl::output('list',$list);
        Tpl::showpage('upload_img');
        exit();
    }
    //上传动作
    public function uploadsOp(){
        $activity_no = $_POST['activity_no'];
        $activity_periods = $_POST['activity_periods'];
        if(empty($activity_no))
            ajaxReturn(array('code'=>'0','msg'=>'请选择活动','control'=>'uploads'));
        if(empty($_FILES['photo']['name']))
            ajaxReturn(array('code'=>'0','msg'=>'请选择图片','control'=>'uploads'));
        // 查活动的领队
        $db_apply = new Model('bbs_apply');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $teacherList = $db_apply->where($map)->field('teacher_id')->group('teacher_id')->select(); 
        $ids = array_column($teacherList,'teacher_id');
        if(!in_array($_SESSION['userInfo']['id'], $ids))
            ajaxReturn(array('code'=>'0','msg'=>'抱歉,您不是改活动的领队','control'=>'uploads'));
        //p($_FILES);
        //上传的图片都是在一个input框里面,要对其做处理
        foreach ($_FILES['photo']['name'] as $key => $val) {
            $_FILES['img'.$key]['name'] = $val;
            $_FILES['img'.$key]['type'] = $_FILES['photo']['type'][$key];
            $_FILES['img'.$key]['tmp_name'] = $_FILES['photo']['tmp_name'][$key];
            $_FILES['img'.$key]['error'] = $_FILES['photo']['error'][$key];
            $_FILES['img'.$key]['size'] = $_FILES['photo']['size'][$key];
        }
        unset($_FILES['photo']);
        //p($_FILES);
        //开始上传
        $i = 0;
        $err = '';
        foreach ($_FILES as $key=>$val) {
            if($val['name'] != ''){
                $upload     = new UploadFile();
                $member_img_path = 'data'.DS."upload".DS;
                $upload->set('default_dir',$member_img_path.'member');//路径保存
                $upload->set('fprefix','photo_'.$activityId);//文件名前缀
                $upload->set('allow_type',array('gif','jpg','jpeg','bmp','png'));//允许上传的文件类型
                $upload->set('max_size',1024*5);//允许的最大文件大小，单位为KB
                $result = $upload->upfile($key,true);
                //p($result);
                if (!$result)
                    ajaxReturn(array('code'=>'0','msg'=>'头像上传失败','control'=>$upload->error,'name'=>$val['name']));
                else{
                    $headimgurl = 'http://haoshaonian.oss-cn-shenzhen.aliyuncs.com'.DS.$member_img_path.'member'.DS.$upload->file_name;
                //p($headimgurl);
                //保存数据库
                $db_album = new Model('bbs_album');
                $data = array();
                $data['file_name'] = $headimgurl;
                $data['file_size'] = $val['size'];
                $data['upload_type'] = 1;
                $data['upload_time'] =time();
                $data['activity_no'] = $activity_no;
                $data['activity_periods'] = $activity_periods;
                $result = $db_album->insert($data);
                //p($data);p($result);
                if($result)
                    $i++;
                else
                    $err .= $val['name'].',';
                }
            }
        }
        if($i == count($_FILES))
            ajaxReturn(array('code'=>'200','msg'=>$i.'张上传成功','control'=>'uploads'));
        else
            ajaxReturn(array('code'=>'0','msg'=>$err.'上传失败','control'=>'uploads'));
    }
    //成长记录
    public function growRecordOp(){
        Tpl::showpage('growth_record');
    }
    //记录详情
    public function growDetailOp(){
        Tpl::showpage('grow_detail');
    }
    //活动足迹
    public function activityPugOp(){
        Tpl::showpage('activity_pug');
    }
    //我的收藏
    public function collectOp(){
        if(!isAjax()){
            Tpl::showpage('collect');
            exit();
        }
        $pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:3;
        $db_collect = new Model('bbs_collect');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $count = $db_collect->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'collect'));
        $collect_list = $db_collect
                        ->field('activity_no,activity_periods')
                        ->where($map)
                        ->order('add_time desc')
                        ->page($pageSize)
                        ->select();
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $list = array();
        foreach ($collect_list as $val) {
            $map = array();
            $map['activity_no'] = array('eq',$val['activity_no']);
            $map['activity_periods'] = array('eq',$val['activity_periods']);
            $field = 'id,activity_no,activity_periods,activity_title,activity_ptitle,activity_index_pic,activity_tag,activity_city,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price';
            $info = $db_activity->field($field)->where($map)->find();
            if(empty($info))
                $info = $db_activity_periods->field($field)->where($map)->find();
            $list[] = $info;
        }
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
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'collect','list'=>$list));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'collect'));
        }
    }
    //优惠券
    public function couponOp(){
        Tpl::showpage("coupon");
    }
    //退出
    public function signOutOp(){
    	//清空session
    	$_SESSION['is_login'] = null;
    	$_SESSION['userInfo'] = null;
    	//showMessage('退出成功',urlBBS('index','login'));
    	header("Location: ".urlBBS('index','login'));
    }
    //检查登录
    public function checkLogin(){
    	if(empty($_SESSION['is_login'])){
    		if(isAjax())
    			ajaxReturn(array('code'=>'200','msg'=>'请先登录','control'=>'checkLogin','url'=>urlBBS('index','login')));
    		else
    			header("Location: ".urlBBS('index','login'));
    			//showDialog('请先登录',urlBBS('index','login'));
    	}
    }
}