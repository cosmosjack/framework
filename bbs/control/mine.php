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
    	$info = $db_user->where('id='.$_SESSION['is_user_login'])->find();
    	//p($info);
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$info['id']);
        $map['order_status'] = array('eq',3);
        //查询成长记录总数,查参加活动的订单总数
        $growCount = $db_order->where($map)->count();
        //成长相册数量
        $albumCount = $growCount;
        // $list = $db_order->where($map)->field('activity_no,activity_periods')->select();
        // $db_album = new Model('bbs_album');
        // //p($list);
        // foreach ($list as $val) {
        //     $map = array();
        //     $map['activity_no'] = array('eq',$val['activity_no']);
        //     //$map['activity_periods'] = array('eq',$val['activity_periods']);
        //     $count = $db_album->where($map)->count();
        //     $albumCount += $count;
        // }
        //我的领队
        if($info['is_teacher']){
            $db_apply = new Model();
            // $teacherCount = $db_apply
            //             ->where('teacher_id='.$info['id'])
            //             ->group('activity_no,activity_periods')
            //             ->count();
            //             
            $sql = "select count(id) as num from (SELECT id FROM 33hao_bbs_apply WHERE `teacher_id`={$info['id']} GROUP BY `activity_no`,`activity_periods`) a";
            $teacherCount = $db_apply->query($sql);//p($teacherCount);
            Tpl::output("teacherCount",$teacherCount[0]['num']);
        }
        //我的收藏
        $db_collect = new Model('bbs_collect');
        $map = array();
        $map['member_id'] = array('eq',$info['id']);
        $collectCount = $db_collect->where($map)->count();
        //用户等级
        $level = get_member_level($info['id']);
        //p($level);
        Tpl::output("info",$info);
        Tpl::output("albumCount",$albumCount);
        Tpl::output("growCount",$growCount);
        Tpl::output("collectCount",$collectCount);
        Tpl::output("level",$level);
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
        $map['order_status'] = array('eq',3);
        $count = $db_order->where($map)->group('activity_no')->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'album'));
        $list = $db_order
                ->field('activity_no,activity_periods,activity_title,activity_index_pic,order_time')
                ->where($map)
                ->order('order_time desc')
                ->group('activity_no,activity_periods')
                ->page($pageSize)
                ->select();

        //查相册里面上传的相片数量
        if(!empty($list)){
            $db_album = new Model('bbs_album');
            foreach ($list as &$val) {

                //获取分组信息
                $group = get_group($val['activity_no'],$val['activity_periods'],$_SESSION['userInfo']['id']);
                $group_id_arr = array_column($group, 'group_id');
        
                $map = array();
                $map['upload_type'] = array('eq',1);
                $map['activity_no'] = array('eq',$val['activity_no']);
                $map['activity_periods'] = array('eq',$val['activity_periods']);
                $map['group_id'] = array('in',$group_id_arr);
                $val['count'] = $db_album->where($map)->count();
                $val['url'] = urlBBS('mine','photo',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['time'] = date('Y-m-d',$val['order_time']);
                $val['activity_title'] = '【第'.$val['activity_periods'].'期】'.$val['activity_title'];
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
    //普通用户查看相片
    public function photoOp(){
        if(!isAjax()){
            $activity_no = $_GET['activity_no'];
            $activity_periods = $_GET['activity_periods'];
            //查询用户是否参与此活动
            $db_order = new Model('bbs_order');
            $map = array();
            $map['activity_no'] = array('eq',$activity_no);
            $map['activity_periods'] = array('eq',$activity_periods);
            $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
            $map['order_status'] = array('eq',3);
            $info = $db_order->field('activity_title')->where($map)->find();
            if(empty($info))
                showMessage('您没有参与此活动',getenv(HTTP_REFERER));
            //p($ids);p($teacherList);
            Tpl::output('activity_no',$activity_no);
            Tpl::output('activity_periods',$activity_periods);
            Tpl::output('activity_title',$info['activity_title']);
            Tpl::showpage('photo_album');
            exit();
        }
        $activity_no = $_POST['activity_no'];
        $activity_periods = $_POST['activity_periods'];
        if(empty($activity_no) || empty($activity_periods))
            ajaxReturn(array('code'=>'0','msg'=>'参数错误','control'=>'photo'));

        //获取分组信息
        $group = get_group($activity_no,$activity_periods,$_SESSION['userInfo']['id']);
        $group_id_arr = array_column($group, 'group_id');

        $pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:10;
        $db_album = new Model('bbs_album');
        $map = array();
        $map['upload_type'] = array('eq',1);
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $map['group_id'] = array('in',$group_id_arr);
        $count = $db_album->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'photo','group'=>$group_id_arr));
        $list = $db_album
                ->field('file_name,activity_no,upload_time')
                ->where($map)
                ->order('upload_time desc')
                ->page($pageSize)
                ->select();
        if(!empty($list))
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'photo','list'=>$list,'group'=>$group_id_arr));
        else
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'photo'));
    }
    //领队老师查看相片
    public function photoLeaderOp(){
        if(!isAjax()){
            //查询活动详情
            $activity_no = $_GET['activity_no'];
            $activity_periods = $_GET['activity_periods'];
            //查是否是该活动的领队
            $db_apply = new Model('bbs_apply');
            $map = array();
            $map['activity_no'] = array('eq',$activity_no);
            $map['activity_periods'] = array('eq',$activity_periods);
            $map['teacher_id'] = array('eq',$_SESSION['userInfo']['id']);
            $info = $db_apply->field('teacher_id,activity_title')->where($map)->find();
            if(empty($info))
                showMessage('您没有参与此活动',getenv(HTTP_REFERER));
            // 查活动的领队
            // $db_apply = new Model('bbs_apply');
            // $map = array();
            // $map['activity_no'] = array('eq',$activity_no);
            // $map['activity_periods'] = array('eq',$activity_periods);
            // $teacherList = $db_apply->where($map)->field('teacher_id')->group('teacher_id')->select(); 
            // $ids = array_column($teacherList,'teacher_id');
            // Tpl::output('ids',$ids);
            //p($ids);p($teacherList);
            Tpl::output('activity_no',$activity_no);
            Tpl::output('activity_periods',$activity_periods);
            Tpl::output('activity_title',$info['activity_title']);
            Tpl::showpage('photo_leader');
            exit();
        }
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
        
        /*获取领队老师的所在的小组，可能有多个 start*/
        $db_apply = new Model('bbs_apply');
        $map = array();
        $map['activity_no'] = $activity_no;
        $map['activity_periods'] = $activity_periods;
        $map['teacher_id'] = $_SESSION['userInfo']['id'];
        $group = $db_apply
                ->field('id,activity_no,activity_periods,activity_title,group_id,teacher_id,teacher_name')
                ->where($map)
                ->group('group_id')
                ->order('group_id')
                ->select();
        Tpl::output('group',$group);
        /*获取领队老师的所在的小组，可能有多个 end*/

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
        $group_id = $_POST['group_id'];
        if(empty($activity_no))
            ajaxReturn(array('code'=>'0','msg'=>'请选择活动','control'=>'uploads'));
        if(empty($_FILES['photo']['name']))
            ajaxReturn(array('code'=>'0','msg'=>'请选择图片','control'=>'uploads'));
        if(empty($group_id))
            ajaxReturn(array('code'=>'0','msg'=>'请选择队伍','control'=>'uploads'));
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
                $data['group_id'] = $group_id;
                $data['teacher_id'] = $_SESSION['userInfo']['id'];
                $data['teacher_name'] = $_SESSION['userInfo']['nick_name']?$_SESSION['userInfo']['nick_name']:$_SESSION['userInfo']['member_name'];
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
        if(!isAjax()){
            //查活动类型
            $db_cls = new Model('bbs_cls');
            $cls_data = $db_cls->select();
            Tpl::output('cls_data',$cls_data);
            Tpl::showpage('growth_record');
            exit();
        }
        $pageSize = !empty($_POST['pageSize'])?$_POST['pageSize']:6;
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $map['order_status'] = array('eq',3);
        if(!empty($_POST['type']))
            $map['activity_cls_id'] = array('eq',$_POST['type']);
        $count = $db_order->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'growRecord'));
        $order_list = $db_order->field('activity_no,activity_periods')->where($map)->order('order_time desc')->select();
        //p($order_list);
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $list = array();
        foreach ($order_list as $val) {
            $map = array();
            $map['activity_no'] = array('eq',$val['activity_no']);
            $map['activity_periods'] = array('eq',$val['activity_periods']);
            $field = 'id,activity_no,activity_periods,activity_title,activity_ptitle,activity_index_pic,
            activity_tag,activity_begin_time';
            $info = $db_activity->field($field)->where($map)->find();
            if(empty($info))
                $info = $db_activity_periods->field($field)->where($map)->find();
            $list[] = $info;
        }
        //p($list);
        if(!empty($list)){
            foreach ($list as &$val) {
                $val['activity_title'] = '【第'.$val['activity_periods'].'期】'.$val['activity_title'];
                $val['url'] = urlBBS('mine','growDetail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['time'] = date('Y-n-j',$val['activity_begin_time']);
            }
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'growRecord','list'=>$list));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'growRecord'));
        }
    }
    //记录详情
    public function growDetailOp(){
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
        //点击量加1
        $update = array();
        $update['activity_click'] = array('exp','activity_click+1');
        $db_activity->where($map)->update($update);
        $db_activity_periods->where($map)->update($update);
        //队伍
        $db_apply = new Model('bbs_apply');
        $groupInfo = calc_group($info['activity_no'],$info['activity_periods']);
        //p($groupInfo);
        $group_arr = array();
        foreach ($groupInfo['data'] as &$val) {
            $val['url'] = urlBBS('activity','member',array('activity_no'=>$info['activity_no'],'activity_periods'=>$info['activity_periods'],'group_id'=>$val['group_id']));
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
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        if($db_collect->where($map)->find())
            $info['collect'] = 1;
        //p($group_arr);
        //活动足迹
        $db_order = new Model('bbs_order');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        // $map['activity_no'] = array('neq',$info['activity_no']);
        $map['activity_periods'] = array('eq',$info['activity_periods']);
        $map['order_status'] = array('eq',3);
        $field = 'id,activity_no,activity_periods,activity_title,activity_index_pic,
            activity_tag,activity_begin_time';
        $order_list = $db_order->field($field)->where($map)->limit(2)->select();
        $db_album = new Model('bbs_album');
        foreach ($order_list as &$val) {
            $map = array();
            $map['activity_no'] = array('eq',$val['activity_no']);
            $map['activity_periods'] = array('eq',$val['activity_periods']);
            $map['upload_type'] = array('eq',1);
            //获取分组信息
            $group = get_group($val['activity_no'],$val['activity_periods'],$_SESSION['userInfo']['id']);
            $group_id_arr = array_column($group, 'group_id');
            $map['group_id'] = array('in',$group_id_arr);
            $val['count'] = $db_album->where($map)->count();
            // $val['activity_title'] = '【第'.$val['activity_periods'].'期】'.$val['activity_title'];
        }
        //点评汇总,查看自家孩子的点评
        $db_user_words = new Model('bbs_user_words');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $user_words_list = $db_user_words
                            ->field('child_id,child_name,child_pic,words_name,add_time')
                            ->where($map)
                            ->group('child_id')
                            ->select();
        // foreach ($user_words_list as &$val) {
        //     $map['child_id'] = array('eq',$val['child_id']);
        //     $val['words_list'] = $db_user_words->field('words_name')->where($map)->select();
        // }
        //推荐活动
        $map = array();
        $map['id'] = array('neq',$info['id']);
        $map['activity_end_time'] = array('gt',time());
        $field = 'id,activity_title,activity_no,activity_periods,activity_index_pic,activity_tag,address,min_age,max_age,activity_begin_time,activity_end_time,total_number,already_num,activity_price,activity_city';
        $list = $db_activity
                ->field($field)
                ->where($map)
                ->order('activity_begin_time,activity_click desc')
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
        Tpl::output('info',$info);
        Tpl::output('banner',$banner);
        Tpl::output('groupInfo',$groupInfo['data']);
        Tpl::output('group_arr',$group_arr);
        Tpl::output('order_list',$order_list);
        Tpl::output('user_words_list',$user_words_list);
        Tpl::output('list',$list);
        Tpl::showpage('grow_detail');
    }
    //活动足迹
    public function activityPugOp(){
        $activity_no = $_GET['activity_no'];
        $activity_periods = $_GET['activity_periods'];
        if(empty($activity_no) || empty($activity_periods))
            showMessage('参数错误',getenv(HTTP_REFERER));
        //成长相册详情
        $db_order = new Model('bbs_order');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $info = $db_order->where($map)->field('activity_no,activity_periods,activity_title,activity_index_pic')->find();

        /*照片数量，先查所在分组 start*/
        //获取分组信息
        $group = get_group($activity_no,$activity_periods,$_SESSION['userInfo']['id']);
        $group_id_arr = array_column($group, 'group_id');
        $db_album = new Model('bbs_album');
        $map = array();
        $map['activity_no'] = array('eq',$activity_no);
        $map['activity_periods'] = array('eq',$activity_periods);
        $map['group_id'] = array('in',$group_id_arr);
        $count = $db_album->where($map)->count();
        /*照片数量，先查所在分组 end*/

        //p($info);p($count);
        Tpl::output('info',$info);
        Tpl::output('count',$count);
        Tpl::showpage('activity_pug');
    }
    //我的收藏
    public function collectOp(){
        if(!isAjax()){
            Tpl::showpage('collect');
            exit();
        }
        $pageSize = !empty($_POST['pageSize'])?$_POST['pageSize']:3;
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
        if(empty($collect_list))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'leader'));
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
            if(!empty($info))
                $list[] = $info;
        }
        if(!empty($list)){
            foreach ($list as &$val) {
                //$val['activity_title'] = mb_substr($val['activity_title'], 0,6,'utf-8');
                $val['activity_time'] = (date('Ymd',$val['activity_begin_time'])==date('Ymd',$val['activity_end_time']))?date('n月j日',$val['activity_begin_time']).'一天':(date('n月j日',$val['activity_begin_time']).'~'.date('n月j日',$val['activity_end_time']));
                $val['url1'] = urlBBS('activity','collect',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['age'] = $val['min_age'].'-'.$val['max_age'];
                $val['city'] = getAreaName($val['activity_city']);
                $url = urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['url'] = $url;
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
    //我的领队
    public function leaderOp(){
        if(!isAjax()){
            Tpl::showpage("mine_leader");
            exit();
        }
        //查询我领队过的活动,查apply表
        $db_apply = new Model('bbs_apply');
        $pageSize = !empty($_POST['pageSize'])?$_POST['pageSize']:3;
        $map = array();
        $map['teacher_id'] = array('eq',$_SESSION['userInfo']['id']);
        $count = $db_apply->where($map)->group('activity_no,activity_periods')->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'leader'));
        $apply_list = $db_apply
                ->field('id,activity_no,activity_periods')
                ->where($map)
                ->group('activity_no,activity_periods')
                ->order('apply_time desc')
                ->page($pageSize)
                ->select();
        if(empty($apply_list))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'leader'));
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');
        $list = array();
        foreach($apply_list as $val){
            $map = array();
            $map['activity_no'] = array('eq',$val['activity_no']);
            $map['activity_periods'] = array('eq',$val['activity_periods']);
            $field = 'id,activity_no,activity_periods,activity_title,activity_ptitle,activity_index_pic,activity_tag,activity_begin_time,activity_end_time';
            $info = $db_activity->field($field)->where($map)->find();
            if(empty($info))
                $info = $db_activity_periods->field($field)->where($map)->find();
            if(!empty($info))
                $list[] = $info;
        }
        if(!empty($list)){
            foreach ($list as &$val) {
                $val['activity_time'] = date('Y-m-d',$val['activity_begin_time']);
                $val['url'] = urlBBS('activity','detail',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['url1'] = urlBBS('mine','photoLeader',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
                $val['url2'] = urlBBS('mine','reviews',array('activity_no'=>$val['activity_no'],'activity_periods'=>$val['activity_periods']));
            }
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'leader','list'=>$list));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'leader'));
        }
    }
    //点评学员
    public function reviewsOp(){
        if(!isAjax()){
            //查活动详情
            $db_activity = new Model('bbs_activity');
            $db_activity_periods = new Model('bbs_activity_periods');
            $activity_no = $_GET['activity_no'];
            $activity_periods = $_GET['activity_periods'];
            if(empty($activity_no) || empty($activity_periods))
                showMessage('参数错误',getenv(HTTP_REFERER));
            $map = array();
            $map['activity_no'] = array('eq',$activity_no);
            $map['activity_periods'] = array('eq',$activity_periods);
            $info = $db_activity_periods->where($map)->find();
            if(empty($info))
                $info = $db_activity->where($map)->find();
            if(empty($info))
                showMessage('活动不存在',getenv(HTTP_REFERER));
            //轮播图
            $db_banner = new Model('bbs_uploads');
            $banner = $db_banner->where('upload_type=1 and item_id='.$info['activity_no'])->select();
            //查询学员  
            $map['teacher_id'] = array('eq',$_SESSION['userInfo']['id']);          
            $db_apply = new Model('bbs_apply');
            $child_list = $db_apply
                        //->field('bbs_apply.child_id,bbs_child.*')
                        //->table('bbs_apply,bbs_child')
                        ->where($map)
                        //->join('left')
                        //->on('bbs_apply.child_id=bbs_child.id')
                        ->select();
            //查寻对学员的点评
            $db_user_words = new Model('bbs_user_words');
            foreach ($child_list as &$val) {
                $map = array();
                $map['teacher_id'] = array('eq',$_SESSION['userInfo']['id']);
                $map['child_id'] = array('eq',$val['child_id']);
                $val['words_list'] = $db_user_words
                                    ->field('id,words_name,teacher_id,child_id')
                                    ->order('add_time desc')
                                    ->where($map)
                                    ->find();
            }
            //p($_SESSION['userInfo']);
            //p($child_list);
            
            Tpl::output('activity_no',$activity_no);
            Tpl::output('activity_periods',$activity_periods);
            Tpl::output('info',$info);
            Tpl::output('banner',$banner);
            Tpl::output('child_list',$child_list);
            Tpl::showpage("reviews");
            exit();
        }
        $activity_no = $_POST['activity_no'];//活动id
        $activity_periods = $_POST['activity_periods'];//活动期数
        $lable = $_POST['content'];//数组，包含学员信息和标签
        if(empty($lable) || empty($activity_no) || empty($activity_periods))
            ajaxReturn(array('code'=>0,'msg'=>'参数错误','data'=>$_POST));
        //写入数据库
        $list = array();
        $db_user_words = new Model('bbs_user_words');
        
        $data = array();
        $data['member_id'] = $_POST['member_id'];
        $data['member_name'] = $_POST['member_name'];
        $data['activity_no'] = $activity_no;
        $data['activity_periods'] = $activity_periods;
        $data['child_id'] = $_POST['child_id'];
        $data['child_name'] = $_POST['child_name'];
        $data['child_pic'] = $_POST['child_pic'];
        //$data['words_id'] = 2;
        $data['words_name'] = $_POST['content'];
        $data['teacher_id'] = $_SESSION['userInfo']['id'];
        $data['teacher_name'] = $_SESSION['userInfo']['nick_name'];
        $data['add_time'] = time();
        if($_POST['id']){
            $id = $_POST['id'];
            $result = $db_user_words->where('id='.$id)->update($data);
        }else{
            $result = $db_user_words->insert($data);
            $id = $result;
        }
        if($result)
            ajaxReturn(array('code'=>200,'msg'=>'点评成功','result'=>$id));
        else
            ajaxReturn(array('code'=>0,'msg'=>'点评失败','data'=>$data));
    }
    //查询所有的评语
    public function wordsOp(){
        $db_words = new Model('bbs_words');
        $list = $db_words->order('sort')->select();
        if(!empty($list))
            ajaxReturn(array('code'=>'200','msg'=>'标签加载','list'=>$list));
        else
            ajaxReturn(array('code'=>'0','msg'=>'暂无标签'));
    }
    //退出
    public function signOutOp(){
    	//清空session
    	$_SESSION['is_user_login'] = null;
    	$_SESSION['userInfo'] = null;
    	//showMessage('退出成功',getenv(HTTP_REFERER));
    	header("Location: ".urlBBS('index','login'));
    }
    //检查登录
    public function checkLogin(){
    	if(empty($_SESSION['is_user_login'])){
    		if(isAjax())
    			ajaxReturn(array('code'=>'200','msg'=>'请先登录','control'=>'checkLogin','url'=>urlBBS('index','login')));
    		else
    			header("Location: ".urlBBS('index','login'));
    			//showDialog('请先登录',urlBBS('index','login'));
    	}
    }
}