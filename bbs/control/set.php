<?php
/**
 *
 *	我的个人中心设置控制器
 *	Create by :杨奇林
 *  time:201803.27
 *  qq:928944169
 */
class setControl extends BaseControl{

    public function __construct(){
        parent::__construct();
        Tpl::setLayout("common_login_layout");
        $this->checkLogin();
    }
    //设置首页
    public function setUpOp(){
        if(!isAjax()){
            Tpl::showpage("setUp");
            exit();
        }
    }
    //展示个人信息
    public function mineInfoOp(){
    	if(!isAjax()){
            $db_user = Model('bbs_user');
            $info = $db_user->where('id='.$_SESSION['userInfo']['id'])->find();
            $info['address1'] = '';
            if(!empty($info['province'])){
                //$info['address1'] = $info['province'].','.$info['city'].','.$info['area'];
                $info['address'] = getAreaName($info['province']).getAreaName($info['city']).getAreaName($info['area']).$info['address'];
            }
            Tpl::output('info',$info);
    		Tpl::showpage("mineInfo");
    		exit();
    	}
    }
    //修改个人信息
    public function editInfoOp(){
        if(!isAjax()){
            $db_user = Model('bbs_user');
            $info = $db_user->where('id='.$_SESSION['userInfo']['id'])->find();
            $info['address1'] = '';
            if(!empty($info['province'])){
                $info['address1'] = $info['province'].'-'.$info['city'].'-'.$info['area'];
                $info['address2'] = getAreaName($info['province']).'&nbsp'.getAreaName($info['city']).'&nbsp'.getAreaName($info['area']);
                //$info['address'] = getAreaName($info['province']).getAreaName($info['city']).getAreaName($info['area']).$info['address'];
            }
            Tpl::output('info',$info);
            Tpl::showpage("modify_data");
            exit();
        }
        if(empty($_POST['nick_name']))
            ajaxReturn(array('code'=>'0','msg'=>'昵称不能为空','control'=>'mineInfo'));
        // if(empty($_POST['member_birthday']))
        //     ajaxReturn(array('code'=>'0','msg'=>'出生年月','control'=>'mineInfo'));
        if(empty($_POST['address1']))
            ajaxReturn(array('code'=>'0','msg'=>'地址不能为空','control'=>'mineInfo'));
        if(empty($_POST['address']))
            ajaxReturn(array('code'=>'0','msg'=>'详细地址不能为空','control'=>'mineInfo'));
        $update = array();
        //头像上传
        if($_FILES['photo']['name'] != ''){
            $member_img_path = 'data'.DS."upload".DS;
            $upload     = new UploadFile();
            $upload->set('default_dir',$member_img_path.'member');//路径保存
            $upload->set('fprefix','parent_'.$_SESSION['userInfo']['id']);//文件名前缀
            $upload->set('allow_type',array('gif','jpg','jpeg','bmp','png'));//允许上传的文件类型
            $upload->set('max_size',1024*5);//允许的最大文件大小，单位为KB
            $result = $upload->upfile('photo',true);
            //p($result);exit();
            if (!$result)
                ajaxReturn(array('code'=>'0','msg'=>'头像上传失败','control'=>'addManage'));
            $headimgurl = 'http://haoshaonian.oss-cn-shenzhen.aliyuncs.com'.DS.$member_img_path.'member'.DS.$upload->file_name;
            $update['headimgurl'] = $headimgurl.'!product-60';
            //exit($headimgurl);
        }
        $update['nick_name'] = $_POST['nick_name'];
        //$update['member_birthday'] = $_POST['member_birthday'];
        $update['address'] = $_POST['address'];
        $arr = explode('-',$_POST['address1']);
        $update['province'] = $arr[0];
        $update['city'] = $arr[1]?$arr[1]:0;
        $update['area'] = $arr[2]?$arr[2]:0;
        // if(!empty($_POST['member_sex']))
        //     $update['member_sex'] = $_POST['member_sex'];
        $db_user = Model('bbs_user');
        $result = $db_user->where('id='.$_SESSION['userInfo']['id'])->update($update);
        //p($result);p($update);exit();
        if($result){
            //更新session
            $info = $db_user->where('id='.$_SESSION['userInfo']['id'])->find();
            $_SESSION['is_user_login'] = $info['id'];//用户登录标志
            unset($info['member_passwd']);
            $_SESSION['userInfo'] = $info;
            ajaxReturn(array('code'=>'200','msg'=>'修改成功','control'=>'mineInfo','url'=>urlBBS('set','mineInfo')));
        }
        else{
            ajaxReturn(array('code'=>'0','msg'=>'修改失败','control'=>'mineInfo'));
        }
    }
    //选择查看对象页面
    public function manageSelectOp(){
        Tpl::showpage("manager_select");
    }
    //监护人身份信息管理
    public function manageInfoOp(){
        //监护人
        if(!isAjax()){
            $db_parents = Model('bbs_parents');
            $map = array();
            $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
            $list = $db_parents->where($map)->select();
            //p($list);
            Tpl::output('list',$list);  
            Tpl::showpage("manage_info");
            exit();
        }
        $db_parents = Model('bbs_parents');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $list = $db_parents->where($map)->order('id asc')->select();
        ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'manageInfo','list'=>$list));
        // if(!empty($list))
        //     ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'manageInfo','list'=>$list));
        // else
        //     ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'manageInfo'));
    }
    //学员身份信息管理
    public function studentInfoOp(){
        if(!isAjax()){
            $db_child = Model('bbs_child');
            $map = array();
            $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
            $list = $db_child->where($map)->select();
            //p($list);
            Tpl::output('list',$list);
            Tpl::showpage("student_info"); 
            exit();
        }
        /*查该活动用户已经报名的学员 start*/
        $db_apply = new Model('bbs_apply');
        $map = array();
        $map['activity_no'] = $_POST['activity_no'];
        $map['activity_periods'] = $_POST['activity_periods'];
        $children = $db_apply->where($map)->group('child_id')->select();
        $children_arr = array_column($children, 'child_id');
        /*查该活动用户已经报名的学员 end*/
        $db_child = Model('bbs_child');
        $map = array();
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $map['id'] = array('not in',$children_arr);
        $list = $db_child->where($map)->order('id asc')->select();
        ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'studentInfo','list'=>$list,'children_arr'=>$children_arr));
        // if(!empty($list))
        //     ajaxReturn(array('code'=>'200','msg'=>'加载数据','control'=>'studentInfo','list'=>$list));
        // else
        //     ajaxReturn(array('code'=>'0','msg'=>'暂无数据','control'=>'studentInfo'));
    }
    //选择身份页面
    public function chooseOp(){
        if(!isAjax()){
            Tpl::showpage("unBind");
            exit();
        }
    }
    //添加或修改监护人身份信息
    public function addManageOp(){
        if(!isAjax()){
            if(!empty($_REQUEST['id'])){
                $info = array();
                $db_parents = Model('bbs_parents');
                $info = $db_parents->where('id='.$_REQUEST['id'])->find();
                Tpl::output('info',$info);
            }
            Tpl::showpage("add_manage");
            exit();
        }
        if(empty($_POST['u_name']))
            ajaxReturn(array('code'=>'0','msg'=>'姓名不能为空','control'=>'addManage'));
        // if(empty($_POST['u_idnum']))
        //     ajaxReturn(array('code'=>'0','msg'=>'证件号不能为空','control'=>'addManage'));
        //$reg = '/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/';
        // $reg = '/^[0-9A-Za-z]{6,24}$/';//数字或者字母的组合
        // if(!preg_match($reg,$_POST['u_idnum']))
        //     ajaxReturn(array('code'=>'0','msg'=>'证件号格式不对','control'=>'addManage'));
        // if(empty($_POST['u_born']))
        //     ajaxReturn(array('code'=>'0','msg'=>'出生年月不能为空','control'=>'addManage'));
        // if(empty($_POST['u_gender']))
        //     ajaxReturn(array('code'=>'0','msg'=>'性别不能为空','control'=>'addManage'));
        if(empty($_POST['u_relation']))
            ajaxReturn(array('code'=>'0','msg'=>'关系不能为空','control'=>'addManage'));
        if(empty($_POST['u_phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'addManage'));
        if(!isPhone($_POST['u_phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号格式不对','control'=>'addManage'));
        //出生年月与证件号是否对应
        //1979时间之前会出错
        // p(strtotime('19890120'));
        // p(strtotime($_POST['u_born']));p($_POST['u_born']);exit();
        // if($_POST['u_idtype']==1 && strtotime(substr($_POST['u_idnum'],6,8)) != strtotime($_POST['u_born']))  
        //     ajaxReturn(array('code'=>'0','msg'=>'身份证信息与出生年月不符','control'=>'addStudent'));
        $db_parents = Model('bbs_parents');
        //判断是否已经添加监护人信息
        /*if($_POST['id']){
            $map = array();
            $map['parents_papers_no'] = array('eq',$_POST['u_idnum']);
            $map['id'] = array('neq',$_POST['id']);
            if($db_parents->where($map)->find())
                ajaxReturn(array('code'=>'0','msg'=>'监护人已存在','control'=>'addManage'));
        }else{
            $map = array();
            $map['parents_papers_no'] = array('eq',$_POST['u_idnum']);
            if($db_parents->where($map)->find())
                ajaxReturn(array('code'=>'0','msg'=>'监护人已存在','control'=>'addManage'));
        }*/
        //头像上传
        if($_FILES['photo']['name'] != ''){
            $member_img_path = 'data'.DS."upload".DS;
            $upload     = new UploadFile();
            $upload->set('default_dir',$member_img_path.'member');//路径保存
            $upload->set('fprefix','parent_'.$_SESSION['userInfo']['id']);//文件名前缀
            $upload->set('allow_type',array('gif','jpg','jpeg','bmp','png'));//允许上传的文件类型
            $upload->set('max_size',1024*5);//允许的最大文件大小，单位为KB
            $result = $upload->upfile('photo',true);
            //p($result);exit();
            if (!$result)
                ajaxReturn(array('code'=>'0','msg'=>'头像上传失败','control'=>'addManage'));
            $headimgurl = 'http://haoshaonian.oss-cn-shenzhen.aliyuncs.com'.DS.$member_img_path.'member'.DS.$upload->file_name;
            $data['headimgurl'] = $headimgurl.'!product-60';
        }
        $data['member_id'] = $_SESSION['userInfo']['id'];
        $data['member_name'] = $_SESSION['userInfo']['member_name'];
        $data['parents_name'] = $_POST['u_name'];
        $data['parents_phone'] = $_POST['u_phone'];
        $data['relation'] = $_POST['u_relation'];
        // $data['parents_brithday'] = strtotime($_POST['u_born']);
        // $data['parents_papers_type'] = $_POST['u_idtype'];
        // $data['parents_papers_no'] = $_POST['u_idnum'];
        // $data['parents_sex'] = $_POST['u_gender']=='男'?1:2;
        //添加的第一个数据设为默认
        if(!$db_parents->where('member_id='.$_SESSION['userInfo']['id'])->find())
            $data['is_default'] = 1;
        if($_POST['id']){
            $result = $db_parents->where('id='.$_POST['id'])->update($data);
        }else{
            $data['headimgurl'] = $headimgurl?$headimgurl.'!product-60':BBS_SITE_URL.'/resource/bootstrap/img/logo.png';
            $result = $db_parents->insert($data);
        }
        if($result){
            ajaxReturn(array('code'=>'200','msg'=>'操作成功','control'=>'addManage','url'=>urlBBS('set','manageInfo'),'id'=>$result,'headimgurl'=>$headimgurl));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'操作失败','control'=>'addManage'));
        }
    }
    //添加或修改学员身份信息
    public function addStudentOp(){
        if(!isAjax()){
            if(!empty($_REQUEST['id'])){
                $info = array();
                $db_child = Model('bbs_child');
                $info = $db_child->where('id='.$_REQUEST['id'])->find();
                Tpl::output('info',$info);
            }
            Tpl::showpage("add_student");
            exit();
        }
        if(empty($_POST['u_name']))
            ajaxReturn(array('code'=>'0','msg'=>'姓名不能为空','control'=>'addStudent'));
        if(empty($_POST['u_idnum']))
            ajaxReturn(array('code'=>'0','msg'=>'证件号不能为空','control'=>'addStudent'));
        // $reg = '/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/';
        // $reg = '/^[0-9A-Za-z]{6,24}$/';//数字或者字母的组合
        // if(!preg_match($reg,$_POST['u_idnum']))
        //     ajaxReturn(array('code'=>'0','msg'=>'证件号格式不对','control'=>'addStudent'));
        if(empty($_POST['u_born']))
            ajaxReturn(array('code'=>'0','msg'=>'出生年月不能为空','control'=>'addStudent'));
        if(empty($_POST['u_gender']))
            ajaxReturn(array('code'=>'0','msg'=>'性别不能为空','control'=>'addStudent'));
        if(empty($_POST['u_phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'addStudent'));
        if(!isPhone($_POST['u_phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号格式不对','control'=>'addStudent'));
        if(empty($_POST['u_height']))
            ajaxReturn(array('code'=>'0','msg'=>'身高不能为空','control'=>'addStudent'));
        if(empty($_POST['u_weight']))
            ajaxReturn(array('code'=>'0','msg'=>'体重不能为空','control'=>'addStudent'));
        if(empty($_POST['u_clothes']))
            ajaxReturn(array('code'=>'0','msg'=>'衣服尺码不能为空','control'=>'addStudent'));
        if(empty($_POST['u_exhort']))
            ajaxReturn(array('code'=>'0','msg'=>'学员身体情况不能为空','control'=>'addStudent'));
        $db_child = Model('bbs_child'); 
        //出生年月与证件号是否对应
        // if($_POST['u_idtype']==1 && strtotime(substr($_POST['u_idnum'],6,8)) != strtotime($_POST['u_born']))  
        //     ajaxReturn(array('code'=>'0','msg'=>'身份证信息与出生年月不符','control'=>'addStudent'));
        //判断是否已经添加学员信息
        // if($_POST['id']){
        //     $map = array();
        //     $map['child_papers_no'] = array('eq',$_POST['u_idnum']);
        //     $map['id'] = array('neq',$_POST['id']);
        //     if($db_child->where($map)->find())
        //         ajaxReturn(array('code'=>'0','msg'=>'学员已存在','control'=>'addStudent'));
        // }else{
        //     $map = array();
        //     $map['child_papers_no'] = array('eq',$_POST['u_idnum']);
        //     if($db_child->where($map)->find())
        //         ajaxReturn(array('code'=>'0','msg'=>'学员已存在','control'=>'addStudent'));
        // }
        //头像上传
        if($_FILES['photo']['name'] != ''){
            $member_img_path = 'data'.DS."upload".DS;
            $upload     = new UploadFile();
            $upload->set('default_dir',$member_img_path.'member');//路径保存
            $upload->set('fprefix','child_'.$_SESSION['userInfo']['id']);//文件名前缀
            $upload->set('allow_type',array('gif','jpg','jpeg','bmp','png'));//允许上传的文件类型
            $upload->set('max_size',1024*5);//允许的最大文件大小，单位为KB
            $result = $upload->upfile('photo',true);
            //p($result);exit();
            if (!$result)
                ajaxReturn(array('code'=>'0','msg'=>'头像上传失败','control'=>'addStudent'));
            $headimgurl = 'http://haoshaonian.oss-cn-shenzhen.aliyuncs.com'.DS.$member_img_path.'member'.DS.$upload->file_name;
            $data['headimgurl'] = $headimgurl.'!product-60';
        }  
        // p($_POST);
        // p($_FILES);
        // exit();
        
        $data['member_id'] = $_SESSION['userInfo']['id'];
        $data['member_name'] = $_SESSION['userInfo']['member_name'];
        $data['child_name'] = $_POST['u_name'];
        $data['child_phone'] = $_POST['u_phone'];
        $data['child_brithday'] = strtotime($_POST['u_born']);
        $data['child_papers_type'] = $_POST['u_idtype'];
        $data['child_papers_no'] = $_POST['u_idnum'];
        $data['child_height'] = $_POST['u_height'];
        $data['child_weight'] = $_POST['u_weight'];
        $data['child_size'] = $_POST['u_clothes'];
        $data['child_remark'] = $_POST['u_exhort'];
        $data['child_sex'] = $_POST['u_gender']=='男'?1:2;
        //用身份证计算年龄
        // if($_POST['u_idtype']==1)
        //     $data['child_age'] = date('Y',time())-substr($_POST['u_idnum'],6,4);
        //用出生日期计算年龄
        $data['child_age'] = date('Y',time())-substr($_POST['u_born'],0,4);
        //添加的第一个数据设为默认
        if(!$db_child->where('member_id='.$_SESSION['userInfo']['id'])->find())
            $data['is_default'] = 1;
        if($_POST['id']){
            $result = $db_child->where('id='.$_POST['id'])->update($data);
        }else{
            $data['headimgurl'] = $headimgurl?$headimgurl.'!product-60':BBS_SITE_URL.'/resource/bootstrap/img/children.jpg';
            $result = $db_child->insert($data);
        }
        if($result){
            ajaxReturn(array('code'=>'200','msg'=>'操作成功','control'=>'addStudent','url'=>urlBBS('set','studentInfo'),'id'=>$result,'headimgurl'=>$headimgurl));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'操作失败','control'=>'addStudent'));
        }
    }
    //删除监护人或学员信息
    public function deletInfoOp(){
        if(!isAjax())
            ajaxReturn(array('code'=>'0','msg'=>'ajax操作','control'=>'deletInfo'));
        $id = $_POST['id'];
        if(empty($id))
            ajaxReturn(array('code'=>'0','msg'=>'id不能为空','control'=>'deletInfo'));
        $table = $_POST['table'];
        if(empty($table))
            ajaxReturn(array('code'=>'0','msg'=>'table不能为空','control'=>'deletInfo'));
        if(!in_array($table, array('bbs_parents','bbs_child')))
            ajaxReturn(array('code'=>'0','msg'=>'table错误','control'=>'deletInfo'));
        $db_table = Model($table);
        $map = array();
        $map['id'] = array('eq',$id);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $info = $db_table->where($map)->find();
        if(empty($info))
            ajaxReturn(array('code'=>'0','msg'=>'不存在此数据','control'=>'deletInfo'));
        //p($map);一直返回的是false
        $result = $db_table->where($map)->delete();
        ajaxReturn(array('code'=>'200','msg'=>'删除成功','control'=>'deletInfo'));
        // p($result);
        // if($result)
        //     ajaxReturn(array('code'=>'200','msg'=>'删除成功','control'=>'deletInfo'));
        // else
        //     ajaxReturn(array('code'=>'0','msg'=>'删除失败','control'=>'deletInfo'));
    }
    //设为默认
    public function defaultOp(){
        if(!isAjax())
            ajaxReturn(array('code'=>'0','msg'=>'ajax操作','control'=>'default'));
        $id = $_POST['id'];
        if(empty($id))
            ajaxReturn(array('code'=>'0','msg'=>'id不能为空','control'=>'default'));
        $table = $_POST['table'];
        if(empty($table))
            ajaxReturn(array('code'=>'0','msg'=>'table不能为空','control'=>'default'));
        if(!in_array($table, array('bbs_parents','bbs_child')))
            ajaxReturn(array('code'=>'0','msg'=>'table错误','control'=>'default'));
        $db_table = Model($table);
        $map = array();
        $map['id'] = array('eq',$id);
        $map['member_id'] = array('eq',$_SESSION['userInfo']['id']);
        $info = $db_table->where($map)->find();
        if(empty($info))
            ajaxReturn(array('code'=>'0','msg'=>'不存在此数据','control'=>'default'));
        $result = $db_table->where($map)->update(array('is_default'=>1));
        if($result){
            $map = array();
            $map['id'] = array('neq',$id);
            $map['is_default'] = array('eq',1);
            $db_table->where($map)->update(array('is_default'=>0));
            ajaxReturn(array('code'=>'200','msg'=>'设置成功','control'=>'default'));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'设置失败','control'=>'default'));
        }
    }
    //解绑手机
    public function unBindOp(){
        if(!isAjax()){
            Tpl::showpage("unBind");
            exit();
        }
        if(empty($_POST['phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'unBind'));
        //验证手机格式
        if(!isPhone($_POST['phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'unBind'));
        //检查手机
        if($_POST['phone'] != $_SESSION['userInfo']['member_phone'])
            ajaxReturn(array('code'=>'0','msg'=>'请输入之前绑定的手机','control'=>'unBind'));
        ///验证短信验证码
        $db_tmp = Model('bbs_tmp');
        $map = array();
        $map['phone'] = array('eq',$_POST['phone']);
        $map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
        $map['code'] = array('eq',$_POST['code']);
        $info = $db_tmp->where($map)->order('send_time desc')->find();
        if(!$info)
            ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'unBind'));
        if(time()-$info['send_time'] > 120)
            ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'unBind'));
        $db_tmp->where('id='.$info['id'])->delete();
        ajaxReturn(array('code'=>'200','msg'=>'成功，绑定新的手机号','control'=>'unBind','url'=>urlBBS('mine','bind')));
    }
    //绑定手机
    public function bindOp(){
        if(!isAjax()){
            Tpl::showpage("bind");
            exit();
        }
        if(empty($_POST['phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号不能为空','control'=>'bind'));
        //验证手机格式
        if(!isPhone($_POST['phone']))
            ajaxReturn(array('code'=>'0','msg'=>'手机号格式不正确','control'=>'bind'));
        $db_user = Model('bbs_user');
        if($db_user->where('member_phone='.$_POST['phone'])->find()){
            //$db_tmp->where(array('remote_addr'=>array('eq',$_SERVER['REMOTE_ADDR'])))->delete();
            ajaxReturn(array('code'=>'0','msg'=>'手机号已经绑定,请重新输入','control'=>'bind'));
        }
        ///验证短信验证码
        $db_tmp = Model('bbs_tmp');
        $map = array();
        $map['phone'] = array('eq',$_POST['phone']);
        $map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
        $map['code'] = array('eq',$_POST['code']);
        $info = $db_tmp->where($map)->order('send_time desc')->find();
        if(!$info)
            ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'bind'));
        if(time()-$info['send_time'] > 120)
            ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'bind'));
        $update = array();
        //$update['member_name'] = 'hsn_'.$_POST['phone'];
        $update['member_phone'] = $_POST['phone'];
        $result = $db_user->where('id='.$_SESSION['userInfo']['id'])->update($update);
        if($result){
            //删掉验证码
            $db_tmp->where('id='.$info['id'])->delete();
            //修改session
            //$_SESSION['userInfo']['member_name'] = 'hsn_'.$_POST['phone'];
            $_SESSION['userInfo']['member_phone'] = $_POST['phone'];
            ajaxReturn(array('code'=>'200','msg'=>'绑定成功','control'=>'bind','url'=>urlBBS('mine','index')));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'绑定失败','control'=>'bind','url'=>urlBBS('mine','index')));
        }
    }
    //修改密码
    public function editPwOp(){
        if(!isAjax()){
            Tpl::showpage("editPw");
            exit();
        }
        if(empty($_POST['password']))
            ajaxReturn(array('code'=>'0','msg'=>'密码不能为空','control'=>'editPw'));
        //验证短信验证码
        $db_tmp = Model('bbs_tmp');
        $map = array();
        $map['phone'] = array('eq',$_SESSION['userInfo']['member_phone']);
        $map['remote_addr'] = array('eq',$_SERVER['REMOTE_ADDR']);
        $map['code'] = array('eq',$_POST['code']);
        $data = $db_tmp->where($map)->order('send_time desc')->find();
        if(!$data)
            ajaxReturn(array('code'=>'0','msg'=>'验证码不正确','control'=>'editPw'));
        if(time()-$data['send_time'] > 120)
            ajaxReturn(array('code'=>'0','msg'=>'验证码失效','control'=>'editPw'));
        //重置密码
        $update['member_passwd'] = encrypt($_POST['password']);
        $db_user = Model('bbs_user');
        $result = $db_user->where(array('id'=>array('eq',$_SESSION['userInfo']['id'])))->update($update);
        if($result){
            $db_tmp->where(array('id'=>array('eq',$data['id'])))->delete();
            ajaxReturn(array('code'=>'200','msg'=>'修改成功','control'=>'editPw','url'=>urlBBS('mine','index')));
        }else{
            ajaxReturn(array('code'=>'0','msg'=>'修改失败','control'=>'editPw'));
        }
    }
    //关于我们
    public function aboutUsOp(){
        Tpl::showpage("aboutUs");
    }
    //检查登录
    public function checkLogin(){
    	if(empty($_SESSION['is_user_login'])){
    		if(isAjax())
    			ajaxReturn(array('code'=>'201','msg'=>'请先登录','control'=>'checkLogin','url'=>urlBBS('index','login')));
    		else
    			header("Location: ".urlBBS('index','login'));
    			//showDialog('请先登录',urlBBS('index','login'));
    	}
    }
}