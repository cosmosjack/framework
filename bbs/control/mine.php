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
    }
    //首页
    public function indexOp(){
        Tpl::setLayout("common_layout");
    	$this->checkLogin();
    	//查询最新的用户信息
    	$db_user = Model('bbs_user');
    	$info = $db_user->where('id='.$_SESSION['is_login'])->find();
    	//p($info);
        Tpl::output("info",$info);
        //查询成长记录总数,查参加活动的订单总数
        $db_order = Model('bbs_order');
        $count = $db_order->where('member_id='.$info['id'].' and order_status=3')->count();
        Tpl::output("count",$count);
        Tpl::showpage("mine");
    }
    //成长相册
    public function xiangceOp(){

    }
    //我的相册
    public function albumOp(){
        if(!isAjax()){
            Tpl::showpage('my_album');
            exit();
        }
        //参加的活动,查bbs_order
        $pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:6;
        $db_activity = new Model('bbs_activity');
        $map = array();
        //$map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $count = $db_activity->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'album'));
        $list = $db_activity
                ->field('id,activity_title,activity_add_time')
                ->where($map)
                ->order('activity_add_time desc')
                ->page($pageSize)
                ->select();
        if(!empty($list)){
            $db_uploads = new Model('bbs_uploads');
            foreach ($list as &$val) {
                $val['count'] = $db_uploads->where('upload_type=2 and item_id='.$val['id'])->count();
                $val['url'] = urlBBS('mine','photo',array('id'=>$val['id']));
                $val['time'] = date('Y-m-d',$val['activity_add_time']);
                $info = $db_uploads
                        ->where('upload_type=2 and item_id='.$val['id'])
                        ->field('file_name')
                        ->order('upload_time desc')
                        ->find();
                $val['img'] = $info['file_name'];
            }
            ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'album','list'=>$list));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'album'));
        }

    }
    //相片
    public function photoOp(){
        if(!isAjax()){
            $id = $_GET['id'];
            $db_activity = new Model('bbs_activity');
            $info = $db_activity->where('id='.$id)->field('id,activity_title')->find();
            Tpl::output('info',$info);
            Tpl::showpage('photo_album');
            exit();
        }
        $activityId = $_GET['activityId'];
        if(empty($activityId))
            ajaxReturn(array('code'=>'0','msg'=>'参数错误','control'=>'photo'));
        $pageSize = !empty($_GET['pageSize'])?$_GET['pageSize']:10;
        $db_uploads = new Model('bbs_uploads');
        $map = array();
        $map['upload_type'] = array('eq',2);
        $map['item_id'] = array('eq',$activityId);
        $count = $db_uploads->where($map)->count();
        if($_GET['curpage'] > ceil($count/$pageSize))
            ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'photo'));
        $list = $db_uploads
                ->field('file_name,item_id,upload_time')
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
        $db_activity = new Model('bbs_activity');
        //当前的活动
        $activityId = !empty($_GET['id'])?$_GET['id']:0;
        $info = $db_activity->field('id,activity_title')->where('id='.$activityId)->find();
        //参加的活动,查bbs_order
        $map = array();
        //$map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $list = $db_activity->field('id,activity_title')->where($map)->select();
        Tpl::output('activityId',$info['id']);
        Tpl::output('info',$info);
        Tpl::output('list',$list);
        Tpl::showpage('upload_img');
        exit();
    }
    //上传动作
    public function uploadsOp(){
        $activityId = $_POST['activityId'];
        if(empty($activityId))
            ajaxReturn(array('code'=>'0','msg'=>'请选择活动','control'=>'uploads'));
        if(empty($_FILES['photo']['name']))
            ajaxReturn(array('code'=>'0','msg'=>'请选择图片','control'=>'uploads'));
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
                $db_uploads = new Model('bbs_uploads');
                $data = array();
                $data['file_name'] = $headimgurl;
                $data['file_size'] = $val['size'];
                $data['upload_type'] = 2;
                $data['upload_time'] =time();
                $data['item_id'] = $activityId;
                $result = $db_uploads->insert($data);
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
        Tpl::showpage('collect');
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