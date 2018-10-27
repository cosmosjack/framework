<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/26
 * Time: 11:14
 * QQ:  997823131 
 */
class admin_activityControl extends BaseAdminControl{
    public $img_pre_url ;
    private $bbs_upload_path;
    public function __construct(){
        $this->img_pre_url = "http://".C("oss.img_url").DS;
        $this->bbs_upload_path = "data/upload/bbs";
        parent::__construct();
    }

    //后台活动添加功能
    public function activity_addOp(){
        // 先判断 两个类型的图片是否 有 上传   封面图  详情图
        if(!empty($_FILES['cover_img']['name']) && !empty($_FILES['detail_img']['name'][0])){
            // 有值则 插入数据
            /* 整理要插入的数据 start */
//            $insert = $_POST;
            $insert['activity_title'] = $_POST['activity_title'];
            $insert['activity_ptitle'] = $_POST['activity_ptitle'];
            $insert['min_age'] = $_POST['min_age'];
            $insert['max_age'] = $_POST['max_age'];
            $insert['address'] = $_POST['address'];
            $insert['start_from'] = $_POST['start_from'];
            $insert['transportation'] = $_POST['transportation'];
            $insert['total_number'] = $_POST['total_number'];
            $insert['group_number'] = $_POST['group_number'];
            $insert['activity_click'] = $_POST['activity_click'];
            $insert['activity_price'] = $_POST['activity_price'];


            $insert['activity_province'] = $_POST['province'];
            $insert['activity_city'] = $_POST['city'];
            $insert['activity_area'] = $_POST['position'];

            $insert['activity_begin_time'] = strtotime($_POST['start_time']);
            $insert['activity_end_time'] = strtotime($_POST['end_time']." 23:59:59");
            $insert['every_group_num'] = ceil($_POST['total_number']/$_POST['group_number']);
            $insert['activity_add_time'] = time();

            $insert['activity_desc'] = $_POST['activity_body'];

            $insert['activity_no'] = "bbs_".time();

            /* 分类功能 start */
            $insert['cls_id'] = $_POST['cls_id'];
            /* 分类功能 end */


            $db_bbs_activity = new Model("bbs_activity");

//            $db_bbs_activity = new Dpdo();
//            $db_bbs_activity->setTable("bbs_activity");

//            p($db_bbs_activity);

            $row = $db_bbs_activity->insert($insert);
            if(!$row){
                Tpl::output("form_data",$_POST);
                Tpl::output("error_message",array("title"=>"信息有误",'desc'=>"请确认信息填写完整,或活动已存在!"));
                Tpl::showpage("activity_add");
            }else{
//                echo '插入成功';
                /* 上传封面图 start */
                $upload_file = new UploadFile();
                $upload_file->set('default_dir',$this->bbs_upload_path);
                $upload_file->set('max_size',1024);
                $cover_img_result = $upload_file->upfile("cover_img",true);
//                p($cover_img_result); // 新的封面图
                if($cover_img_result){

                    $cover_img_url = $this->img_pre_url.$this->bbs_upload_path.DS.$upload_file->file_name;
//                    p($cover_img_url);
                }else{
                    $img_error = $upload_file->error;
                    // 删除 插入的数据  $row
                    Tpl::output("form_data",$_POST);

                    Tpl::output("error_message",array("title"=>"封面图有问题",'desc'=>$img_error));
                    @$db_bbs_activity->where(array("id"=>$row))->delete();
                    Tpl::showpage("activity_add");

                    die();
                }
                /* 上传封面图 end */

                /* 上传轮播图 start */
                $banner_file = new UploadFile();
                $banner_file->set('default_dir',$this->bbs_upload_path);
                $banner_file->set('max_size',1024);
                // 先判断 $_FILES['detail_img']['name']  有多少个
                $detail_img_file = "detail_img";
                $detail_img_arr = $this->change_file($detail_img_file);
                $detail_img_url = array();
                foreach($detail_img_arr as $key=>$val){

                    $result_detail = $banner_file->upfile($detail_img_file.$key,true);
                    if($result_detail){
                        $detail_img_url[] = $this->img_pre_url.$this->bbs_upload_path.DS.$banner_file->file_name;
                        $tmp_img_url = $this->img_pre_url.$this->bbs_upload_path.DS.$banner_file->file_name;

                        /* 同时一次性整理好 下一步要插入的数据 start */
                        $tmp_upload['file_name'] = $tmp_img_url;
                        $tmp_upload['file_size'] = $_FILES[$detail_img_file.$key]['size'];
                        $tmp_upload['upload_type'] = 1;
                        $tmp_upload['upload_time'] = time();
                        $tmp_upload['item_id'] = $row;
                        $tmp_upload['periods'] = 1;
                        $insert_upload[] =$tmp_upload;
                        /* 同时一次性整理好 下一步要插入的数据 end */
                        unset($banner_file->file_name);

                    }else{
                        $img_error = $banner_file->error;
                        //删除 插入的数据  $row 退出 程序
                        $num = intval($key+1);
                        Tpl::output("form_data",$_POST);
                        Tpl::output("error_message",array("title"=>"详情轮播图第{$num}张有误",'desc'=>$img_error));
                        @$db_bbs_activity->where(array("id"=>$row))->delete();
                        Tpl::showpage("activity_add");

                        die();
                    }
                }

//                p($detail_img_url); // 跟新后的轮播图 数组
                /* 上传轮播图 end */


                // 图片上传成功则修改 刚才插入成功的值  不成功则 删除刚才上传的值  start
                $db_bbs_upload = new Model("bbs_uploads");
                @$result_bbs_upload = $db_bbs_upload->insertAll($insert_upload);
                $result_update_bbs = $db_bbs_activity->where(array("id"=>$row))->update(array("activity_index_pic"=>$cover_img_url,'activity_no'=>$row));

//                $sql = $db_bbs_upload->where(array("id"=>$row))->get_now_sql(array("activity_index_pic"=>$cover_img_url,'activity_no'=>$row));
//                p($sql);
//                die();
//                echo '图片上传';
//                p($result_bbs_upload);
//                echo '跟新';
//                p($result_update_bbs);
                if($result_update_bbs){
                    // TODO 跳转到活动列表页面
                    showMessage("活动添加成功",BBS_SITE_URL.DS."index.php?act=admin&op=activity_list");
                }else{
                    Tpl::output("form_data",$_POST);
                    Tpl::output("error_message",array("title"=>"封面图更新有误",'desc'=>"请重新选择封面图上传"));
                    @$db_bbs_activity->where(array("id"=>$row))->delete();
                    Tpl::showpage("activity_add");
                }
                // 图片上传成功则修改 刚才插入成功的值  不成功则 删除刚才上传的值  end


            }
            /* 整理要插入的数据 end */


}else{
            Tpl::output("form_data",$_POST);
            Tpl::output("error_message",array("title"=>"缺少图片",'desc'=>"请选择重新选择封面图,和轮播图!"));
            Tpl::showpage("activity_add");

        }

    }

        /*
         *  改变$_FILE的格式
         *  把name  为 数组的转成单个的
         *
         *  $_FILE['img']['name'][0]  $_FILE['img']['name'][1]  =>  $_FILE['img0']['name']  $_FILE['img1']['name']
         */

    private function change_file($file){
        $result_arr = array();
        for($i=0;$i<count($_FILES[$file]['name']);$i++){
                if(!empty($_FILES[$file]['name'][$i])){
                    $_FILES[$file.$i]['name'] = $_FILES[$file]['name'][$i];
                    $_FILES[$file.$i]['type'] = $_FILES[$file]['type'][$i];
                    $_FILES[$file.$i]['tmp_name'] = $_FILES[$file]['tmp_name'][$i];
                    $_FILES[$file.$i]['error'] = $_FILES[$file]['error'][$i];
                    $_FILES[$file.$i]['size'] = $_FILES[$file]['size'][$i];
                    $result_arr[$i] = $_FILES[$file.$i];
                }
        }
        return $result_arr;
    }

    /* 整理小组的详情 start */
    public function calc_groupOp(){
        if(empty($_GET['activity_no'])){
            ajaxReturn(array('control'=>'calc_group','code'=>0,'msg'=>'非法请求'),"JSON");
            die();
        }
        // 根据活动的no 和 期数  来查找 申请通过的 儿童信息  并分组
        $db_bbs_apply = new Model();
        // 第一次先按 分组 查询出 所有小组
        $data_group_info = $db_bbs_apply->query("SELECT COUNT(*) AS total_num,33hao_bbs_apply.activity_no,33hao_bbs_apply.teacher_id,33hao_bbs_apply.teacher_name,33hao_bbs_apply.group_id,33hao_bbs_apply.id,33hao_bbs_user.member_phone as teacher_phone ,33hao_bbs_apply.activity_periods FROM 33hao_bbs_apply LEFT JOIN 33hao_bbs_user ON 33hao_bbs_user.id = 33hao_bbs_apply.teacher_id WHERE `activity_no`='".$_GET['activity_no']."' AND `activity_periods`={$_GET['periods']} GROUP BY `group_id`");
        if(!$data_group_info){
            ajaxReturn(array('control'=>'calc_group','code'=>0,'msg'=>'暂无任何报名信息'),"JSON");
            die();
        }
        ajaxReturn(array('control'=>'calc_group','code'=>200,'msg'=>'成功','data'=>$data_group_info),"JSON");

    }
    /* 整理小组的详情 end */

    /* 查出小组人数大于1 的数组 start */
    public function list_group_infoOp(){

       /* if(!is_numeric($_GET['id'])){
            ajaxReturn(array('control'=>'calc_group','code'=>0,'msg'=>'非法请求'),"JSON");
            die();
        }*/
        // 根据活动的id 来查找 申请通过的 儿童信息  并分组
        $db_bbs_apply = new Model();
        // 第一次先按 分组 查询出 所有小组
        $data_group_info = $db_bbs_apply->query("SELECT COUNT(*) AS total_num,33hao_bbs_apply.activity_no,33hao_bbs_apply.teacher_id,33hao_bbs_apply.teacher_name,33hao_bbs_apply.group_id,33hao_bbs_apply.id,33hao_bbs_user.member_phone as teacher_phone  FROM 33hao_bbs_apply LEFT JOIN 33hao_bbs_user ON 33hao_bbs_user.id = 33hao_bbs_apply.teacher_id WHERE `activity_no`='".$_GET['id']."' GROUP BY `group_id`");
        if(!$data_group_info){
            ajaxReturn(array('control'=>'list_group_infoOp','code'=>0,'msg'=>'暂无任何报名信息'),"JSON");
            die();
        }
        $apply_id_arr = array();
        foreach($data_group_info as $k=>$v){
            if($v['total_num'] > 1){
                $apply_id_arr[] = $v['group_id'];
            }
        }
        if(empty($apply_id_arr)){
            ajaxReturn(array('control'=>'list_group_infoOp','code'=>0,'msg'=>'没有任何一个小组人数大于1的'),"JSON");
            die();
        }
        $data_apply = $db_bbs_apply->table('bbs_apply')->where(array("activity_no"=>$_GET['id'],'group_id'=>array("in",$apply_id_arr)))->select();
        ajaxReturn(array('control'=>'list_group_infoOp','code'=>200,'msg'=>'成功','data'=>$data_apply),"JSON");

    }
    /* 查出小组人数大于1 的数组 end */

    /* 根据group_id 和 activity_no  periods  查询出 报名参加的儿童列表 start */
    public function get_team_detailOp(){
        $db_bbs_apply = new Model("bbs_apply");
        $where = array('group_id'=>$_GET['group_id'],'activity_no'=>$_GET['activity_no'],'activity_periods'=>$_GET['activity_periods']);
        $data_bbs_apply = $db_bbs_apply->where($where)->select();
        if(!$data_bbs_apply){
            ajaxReturn(array('control'=>'get_team_detailOp','code'=>0,'msg'=>'此小组无报名信息'),"JSON");
            die();
        }
        ajaxReturn(array('control'=>'get_team_detailOp','code'=>200,'msg'=>'成功','data'=>$data_bbs_apply),"JSON");
    }
    /* 根据group_id 和 activity_id  查询出 报名参加的儿童列表 end */

    /* 查出所有的老师信息 默认一个老师可以带领多个队伍 start */
    public function get_teacher_listOp(){
        $db_bbs_user = new Model("bbs_user");
        $data_bbs_user = $db_bbs_user->where(array("is_teacher"=>1))->select();
        if(!$data_bbs_user){
            ajaxReturn(array('control'=>'get_teacher_list','code'=>0,'msg'=>'当前没有任何老师,请任命'),"JSON");
            die();
        }
        ajaxReturn(array('control'=>'get_teacher_list','code'=>200,'msg'=>'成功','data'=>$data_bbs_user),"JSON");

    }
    /* 查出所有的老师信息 end */


    /* 根据 活动ID 活动小组 老师ID 替换老师 start */
    public function change_teacherOp(){
        $db_bbs_apply = new Model('bbs_apply');
        $where = array('group_id'=>$_GET['group_id'],'activity_no'=>$_GET['activity_no'],'activity_periods'=>$_GET['periods']);
        $db_bbs_uer = new Model("bbs_user");
        $data_bbs_user = $db_bbs_uer->where(array("id"=>$_GET['teacher_id']))->find();
        if(!$data_bbs_user){
            ajaxReturn(array('control'=>'change_teacherOp','code'=>0,'msg'=>'没有此老师'),"JSON");
            die();
        }
        $teacher_name = $data_bbs_user['nick_name']  ? $data_bbs_user['nick_name'] : $data_bbs_user['member_name'];
        $update = array("teacher_id"=>$_GET['teacher_id'],"teacher_name"=>$teacher_name);
        $result = $db_bbs_apply->where($where)->update($update);
        if($result){
            ajaxReturn(array('control'=>'change_teacherOp','code'=>200,'msg'=>'修改成功'),"JSON");
        }else{
            ajaxReturn(array('control'=>'change_teacherOp','code'=>0,'msg'=>'无任何修改'),"JSON");
            die();
        }
    }
    /* 根据 活动ID 活动小组 老师ID 替换老师 end */


    /* 根据活动ID 活动小组 查出 不是这个小组的 所有儿童信息 start */
    public function get_other_childOp(){
        $db_bbs_apply = new Model("bbs_apply");
        $where = array('group_id'=>array("neq",$_GET['group_id']),'activity_no'=>$_GET['activity_no']);
        $data_bbs_apply = $db_bbs_apply->where($where)->select();
        if(!$data_bbs_apply){
            ajaxReturn(array('control'=>'get_other_childOp','code'=>0,'msg'=>'无更多小伙伴'),"JSON");
            die();
        }
        ajaxReturn(array('control'=>'get_other_childOp','code'=>200,'msg'=>'成功','data'=>$data_bbs_apply),"JSON");
    }
    /* 根据活动ID 活动小组 查出 不是这个小组的 所有儿童信息 end */

    /* 将其他儿童添加到 相应的小组中去 start */
    public function mod_child_groupOp(){
        $db_bbs_apply = new Model("bbs_apply");
        $data_bbs_apply = $db_bbs_apply->where(array("activity_no"=>$_GET['activity_no'],"group_id"=>$_GET['group_id']))->find();
        if(!$data_bbs_apply){
            ajaxReturn(array('control'=>'mod_child_groupOp','code'=>0,'msg'=>'没有此小组'),"JSON");
            die();
        }

        $where = array("id"=>array("in",$_GET['child_arr']));
        $update['group_id'] = $_GET['group_id'];
        $update['teacher_id'] = $data_bbs_apply['teacher_id'];
        $update['teacher_name'] = $data_bbs_apply['teacher_name'];
        $result = $db_bbs_apply->where($where)->update($update);
        if($result){
            ajaxReturn(array('control'=>'mod_child_groupOp','code'=>200,'msg'=>'成功','update'=>$update),"JSON");
        }else{
            ajaxReturn(array('control'=>'mod_child_groupOp','code'=>0,'msg'=>'修改失败'),"JSON");

        }


    }
    /* 将其他儿童添加到 相应的小组中去 end */

    /* 添加一个新的小组 start */
    public function add_new_groupOp(){
        //根据 传过来的 apply_id 添加一个新的小组
        $db_apply = new Model("bbs_apply");
        $data_apply = $db_apply->where(array("id"=>$_GET['apply_id']))->find();
        if(!$data_apply){
            ajaxReturn(array('control'=>'add_new_groupOp','code'=>0,'msg'=>'非法请求'),"JSON");
            die();
        }
        $data_last = $db_apply->where(array("activity_no"=>$data_apply['activity_no']))->order("group_id desc")->find();
        if(!$data_last){
            ajaxReturn(array('control'=>'add_new_groupOp','code'=>0,'msg'=>'非法请求'),"JSON");
            die();
        }
        $update['group_id'] = intval($data_last['group_id']+1);
        $result = $db_apply->where(array("id"=>$_GET['apply_id']))->update($update);
        if($result){
            ajaxReturn(array('control'=>'add_new_groupOp','code'=>200,'msg'=>'新增小组成功','data'=>$data_last),"JSON");
        }else{
            ajaxReturn(array('control'=>'add_new_groupOp','code'=>0,'msg'=>'新增小组不成功','data'=>$data_last),"JSON");
        }
    }
    /* 添加一个新的小组 end */

    /* 添加新的期数 根据传进来的 activity_no start */
    public function add_new_periodsOp(){
        if(isset($_POST['sub']) && $_POST['sub'] == 'ok'){
//            p($_POST);
            //根据传过来的 activity_no  查询 最近的一期  先查出 当前正在 activity 表里的数据  再 对比 activity_periods 表里的数据 期数 取最大值 然后插入 periods表
            $db_activity = new Model("bbs_activity");
            $db_activity_periods = new Model("bbs_activity_periods");
            $where = array("activity_no"=>$_POST['activity_no']);
            $data_activity = $db_activity->where($where)->find();

            if(!$data_activity){
                showMessage("非法请求");
                die();
            }

            $now_periods = $data_activity['activity_periods'];// 当前期数
            $data_activity_periods = $db_activity_periods->where($where)->order("activity_periods asc")->select();
            $insert = $data_activity;

            if($data_activity_periods){
                foreach($data_activity_periods as $val){
                    if($now_periods > $val['activity_periods']){
                        $insert['activity_periods'] = $now_periods;
                    }else{
                        $insert['activity_periods'] = $val['activity_periods'];
                    }
                }
            }

            // 如果当前选择的时间  小于 或等于 原有时间 则 不成功
            if(strtotime($_POST['start_time']) <= $insert['activity_begin_time'] || strtotime($_POST['end_time']." 23:59:59")<=$insert['activity_end_time']){
                showMessage("请确认时间选择正确",'','','error');
                exit;
            }

          /*  p($insert);
            die();*/
            /* 整理要插入的数据 start */
            $insert['activity_periods']++;
            $insert['min_age'] = $_POST['min_age'];
            $insert['max_age'] = $_POST['max_age'];
            $insert['activity_begin_time'] = strtotime($_POST['start_time']);
            $insert['activity_end_time'] = strtotime($_POST['end_time']." 23:59:59");
            $insert['transportation'] = $_POST['transportation'];
            $insert['total_number'] = $_POST['total_number'];
            $insert['group_number'] = $_POST['group_number'];
            $insert['activity_click'] = $_POST['activity_click'];
            $insert['activity_price'] = $_POST['activity_price'];
            $insert['activity_no'] = $_POST['activity_no'];
            $insert['activity_add_time'] = time();
            unset($insert['id']);// 消除 ID
            //消除报名人数
            unset($insert['already_num']);
            /* 整理要插入的数据 end */

            $result = $db_activity_periods->insert($insert);
            if($result){
                showMessage("新增成功",BBS_SITE_URL.DS."index.php?act=admin&op=activity_list&is_periods=true&activity_no=".$insert['activity_no']);
            }else{
                showMessage("请确认这一期的活动时间与限制有所改变",'','','error');
                exit;
            }
        }else{
            if(!is_numeric($_GET['activity_no'])){
                showMessage("请选择正确的活动");
                die();
            }
            $db_activity = new Model("bbs_activity");
            $data_activity = $db_activity->where(array('activity_no'=>$_GET["activity_no"],'activity_periods'=>$_GET['periods']))->find();
            if(!$data_activity){
                $db_activity_periods = new Model("bbs_activity_periods");
                $data_activity = $db_activity_periods->where(array('activity_no'=>$_GET["activity_no"],'activity_periods'=>$_GET['periods']))->find();
                if(!$data_activity){
                    showMessage("无此活动");
                    die();
                }
            }
//            p($data_activity);
            Tpl::output("data_activity",$data_activity);
            Tpl::showpage("add_new_periods");
        }
    }
    /* 添加新的期数 根据传进来的 activity_no end */

    /* 展示期数的列表 start */
    public function show_periodsOp(){
        //根据传递过来的 activity_no   展示 activity_periods 表里的相应数据
        $db_periods = new Model("bbs_activity_periods");
        $where = array("activity_no"=>$_GET['activity_no']);
        $order = "";
        $data_periods = $db_periods->where($where)->order($order)->select();
//        p($data_periods);
        Tpl::showpage("activity_list");
    }
    /* 展示期数的列表 end */

    /* 活动的修改 start */
    public function mod_activityOp(){
        // 根据传递过来的 activity_no  和 periods   修改 activity 表 和 periods 表里的数据    如果有  mod_type == all  则将所有activity_no 都修改了  并且只有 未开始的才可以修改
        if(isset($_POST['sub']) && $_POST['sub'] == 'ok'){
            //先查询 activity表
            $db_activity = new Model("bbs_activity");
            $db_activity_periods = new Model("bbs_activity_periods");
            if($_POST['mod_type'] == 'all'){
                $where['activity_no'] = $_POST['activity_no'];
            }else{
                $where['activity_no'] = $_POST['activity_no'];
                $where['activity_periods'] = $_POST['activity_periods'];
            }

            /* 整理要修改的数据 start */
            $update['activity_title'] = $_POST['activity_title'];  //标题
            $update['activity_ptitle'] = $_POST['activity_ptitle']; //副标题
            $update['min_age'] = $_POST['min_age'];  //最小年龄
            $update['max_age'] = $_POST['max_age'];  //最大年龄
            $update['address'] = $_POST['address'];  //详细地址
            $update['start_from'] = $_POST['start_from']; //出发地点
            $update['transportation'] = $_POST['transportation']; //交通工具
            $update['total_number'] = $_POST['total_number']; //总人数
            $update['group_number'] = $_POST['group_number']; //小组数量
            $update['activity_click'] = $_POST['activity_click']; //点击量
            $update['activity_price'] = $_POST['activity_price']; //活动价格


            $update['activity_province'] = $_POST['province']; //省份
            $update['activity_city'] = $_POST['city']; //市
            $update['activity_area'] = $_POST['position']; //区域

            $update['activity_begin_time'] = strtotime($_POST['start_time']); //开始时间

            $update['activity_end_time'] = strtotime($_POST['end_time']." 23:59:59"); //结束时间
            $update['every_group_num'] = ceil($_POST['total_number']/$_POST['group_number']);  //默认小组数量

            $update['activity_desc'] = $_POST['activity_body'];
            $update['cls_id'] = $_POST['cls_id'];


            /* 查出这个活动的信息 start */

            /* 查出这个活动的信息 end */

            /* 根据 file[cover_img][name]判断 封面图是否修改 start */
            if(!empty($_FILES['cover_img']['name'])){
                // 上传  如果失败 则退出 程序 并返回错误
                /* 上传封面图 start */
                $upload_file = new UploadFile();
                $upload_file->set('default_dir',$this->bbs_upload_path);
                $upload_file->set('max_size',1024);
                $cover_img_result = $upload_file->upfile("cover_img",true);
//                p($cover_img_result); // 新的封面图
                if($cover_img_result){

                    $cover_img_url = $this->img_pre_url.$this->bbs_upload_path.DS.$upload_file->file_name;
//                    p($cover_img_url);
                }else{
                    $img_error = $upload_file->error;
                    // 删除 插入的数据  $row
                    Tpl::output("form_data",$_POST);
                    Tpl::output("data_bbs_uploads",$_POST['data_bbs_uploads']);

                    Tpl::output("error_message",array("title"=>"封面图有问题",'desc'=>$img_error));
                    Tpl::showpage("activity_mod");

                    die();
                }
                /* 上传封面图 end */
                $update['activity_index_pic']  = $cover_img_url; // 封面图

            }
            /* 根据 file[cover_img][name]判断 封面图是否修改 end */
            /* 整理要修改的数据 end */

            $data_activity = $db_activity->where($where)->count();
            if($data_activity > 0){
//                echo 'activity表里有<br>';
                $result = @$db_activity->where($where)->update($update);
            }
            $data_activity_periods = $db_activity_periods->where($where)->count();
            if($data_activity_periods > 0){
//                echo 'periods 表里有';
                $result_periods = @$db_activity_periods->where($where)->update($update);
            }

            if($result || $result_periods){
                /* 根据改变图片 start */
                // 先查出当前 uploads 表里有多少个 图片  最多四张
                $db_bbs_uploads = new Model("bbs_uploads");
                $data_bbs_uploads = $db_bbs_uploads->where(array("item_id"=>$_POST['activity_no']))->limit(4)->select();

                for($i=0;$i<4;$i++){
                    //如果有传值过来 则 改变相应的 data_bbs_uplaods 里边的数据  如果 bbs_uploads 里边原来没有 则需要添加
                    if(!empty($_FILES['detail_img']['name'][$i])){


                        // 整理详情图 start
                        $_FILES['banner_img']['name'] = $_FILES['detail_img']['name'][$i];
                        $_FILES['banner_img']['type'] = $_FILES['detail_img']['type'][$i];
                        $_FILES['banner_img']['tmp_name'] = $_FILES['detail_img']['tmp_name'][$i];
                        $_FILES['banner_img']['error'] = $_FILES['detail_img']['error'][$i];
                        $_FILES['banner_img']['size'] = $_FILES['detail_img']['size'][$i];
                        // 整理详情图 end
                        /* 上传轮播图 start */
                        $upload_banner = new UploadFile();
                        $upload_banner->set('default_dir',$this->bbs_upload_path);
                        $upload_banner->set('max_size',1024);
                        $banner_img_result = $upload_banner->upfile("banner_img",true);
//                p($cover_img_result); // 新的封面图
                        if($banner_img_result){

                            $banner_img_url = $this->img_pre_url.$this->bbs_upload_path.DS.$upload_banner->file_name;
//                    p($cover_img_url);
                        }else{
                            $img_error = $upload_banner->error;
                            // 删除 插入的数据  $row
                            Tpl::output("form_data",$_POST);
                            Tpl::output("data_bbs_uploads",$_POST['data_bbs_uploads']);
                            Tpl::output("error_message",array("title"=>"详情图图有问题",'desc'=>$img_error));
                            Tpl::showpage("activity_mod");

                            die();
                        }
                        /* 上传轮播图 end */
                        if(isset($data_bbs_uploads[$i]['id'])){
                            // 修改
                            $update_uploads['file_name'] = $banner_img_url;
                            $update_uploads['file_size'] = $_FILES['banner_img']['size'];
                            $update_uploads['upload_time'] = time();
                            $result_uploads = @$db_bbs_uploads->where(array("id"=>$data_bbs_uploads[$i]['id']))->update($update_uploads);
                        }else{
                            //添加
                            $insert_uploads['file_name'] = $banner_img_url;
                            $insert_uploads['file_size'] = $_FILES['banner_img']['size'];
                            $insert_uploads['upload_time'] = time();
                            $insert_uploads['item_id'] = $_POST['activity_no'];
                            $insert_uploads['periods'] = $_POST['activity_periods'];
                            $insert_uploads['upload_type'] = 1;

                            $result_uploads = @$db_bbs_uploads->insert($insert_uploads);
                        }
                    }
                }
                /* 根据改变图片 end */

                showMessage("修改成功",BBS_SITE_URL.DS."index.php?act=admin&op=activity_list");
            }else{
                showMessage("无任何修改",BBS_SITE_URL.DS."index.php?act=admin_activity&op=mod_activity&activity_no=".$_POST['activity_no']."&periods=".$_POST['activity_periods']);
            }

        }else{
            $db_activity = new Model("bbs_activity");
            $db_activity_periods = new Model("bbs_activity_periods");
            $where['activity_no'] = $_GET['activity_no'];
            $where['activity_periods'] = $_GET['periods'];
            $data_activity = $db_activity->where($where)->find();
//            p($data_activity);
            if(!$data_activity){
                $data_activity = $db_activity_periods->where($where)->find();
            }
            if(!$data_activity){
                showMessage("没有此活动");
                die();
            }

            $data_activity['province'] = $data_activity['activity_province'];
            $data_activity['city'] = $data_activity['activity_city'];
            $data_activity['start_time'] = date("Y-m-d",$data_activity['activity_begin_time']);
            $data_activity['end_time'] = date("Y-m-d",$data_activity['activity_end_time']);
            /* 查出活动介绍的图片 最多四张 start */
            $db_bbs_uploads = new Model("bbs_uploads");
            $data_bbs_uploads = $db_bbs_uploads->where(array("item_id"=>$where['activity_no']))->limit(4)->select();
//            p($data_bbs_uploads);
            /* 查出活动介绍的图片 最多四张 end */

            Tpl::output("data_bbs_uploads",$data_bbs_uploads);
            Tpl::output("form_data",$data_activity);
            Tpl::showpage("activity_mod");

        }


    }
    /* 活动的修改 end */

    /* 活动的删除功能 start */
    // 删除后 订单不删除  activity 和activity_periods 表 都删除
    public function activity_delOp(){
        $db_activity = new Model('bbs_activity');
        $db_activity_periods = new Model('bbs_activity_periods');

        $where['activity_no'] = $_GET['activity_no'];
        $where['activity_periods'] = $_GET['periods'];
        $result = $db_activity_periods->where($where)->delete();

        /*删除所选期数，若还有其他期数，则同步到activity表 start*/
        $info = $db_activity_periods->where(array('activity_no'=>$where['activity_no']))->order('activity_periods desc')->find();
        if(!empty($info)){
            unset($info['id']);
            $result = $db_activity->where($where)->update($info);
            // if(!empty($periods_info)){
            //     unset($periods_info['id']);
            //     $db_activity->insert($periods_info);
            // }
        }else{
            $result = $db_activity->where($where)->delete();
        }
        /*删除所选期数，若还有其他期数，则同步到activity表 end*/

        showMessage("删除成功");
    }

    /* 活动的删除功能 end */

    /* 活动类别列表 start */
    public function cls_listOp(){

        Tpl::showpage("cls_list");
    }
    /* 活动类别列表 end */

    /* 活动类别列表 ajax start */
    public function cls_listAjaxOp(){
        $db_cls = new Model('bbs_cls');
        /* 查询条件 start */
        $where = array("cls_name"=>array('like',"%{$_GET['search']['value']}%"));
        /* 查询条件 end */
        /* 排序条件 start */
        $column = array("id","cls_name","cls_desc","level","pid");
        $column_key = intval($_GET['order'][0]['column']);
        $choose_column = $column[$column_key];
        $choose_sort = $_GET['order'][0]['dir'];
        $order = $choose_column." ".$choose_sort;
//        $order = "";
//        p($order);
        /* 排序条件 end */

        $db_draw = intval($_GET['draw']);
        $db_start = $_GET['start'] ? $_GET['start'] : 0;
        $db_length = $_GET['length'] ? $_GET['length'] : 10;
        $db_limit = $db_start.",".$db_length;
        $db_total = $db_cls->where($where)->count();

        $data_bbs_user = $db_cls
//            ->table("bbs_user,area")
//            ->field("bbs_user.id,bbs_user.member_name,bbs_user.city,bbs_user.add_time,bbs_user.integral,bbs_user.last_login_ip,bbs_user.is_teacher,bbs_user.member_phone,area.area_id,area.area_name")
//            ->join("left")
//            ->on($on)
            ->where($where)
            ->order($order)
            ->limit($db_limit)
            ->select();

        ajaxReturn(array('draw'=>$db_draw,'recordsTotal'=>$db_total,'recordsFiltered'=>$db_total,'data'=>$data_bbs_user),"json");

    }
    /* 活动类别列表 ajax end */

    /* 活动类别添加 start */
    public function cls_addOp(){
        if(isset($_POST['sub']) && $_POST['sub'] == 'ok'){
            $db_cls = new Model('bbs_cls');
            $insert['cls_name'] = $_POST['cls_name'];
            $insert['cls_desc'] = $_POST['cls_desc'];
            $insert['pid'] = $_POST['pid'];

            if($insert['pid'] != "0"){
                // 查出父级cls 的level
                $data_cls = $db_cls->field("level")->where(array('id'=>$insert['pid']))->find();
                $insert['level'] = intval($data_cls['level']+1);
            }
            $row =  $db_cls->insert($insert);
            if($row){
                /* 上传封面图 start */
                $upload_file = new UploadFile();
                $upload_file->set('default_dir',$this->bbs_upload_path);
                $upload_file->set('max_size',1024);
                $cover_img_result = $upload_file->upfile("cls_img",true);
//                p($cover_img_result); // 新的封面图
                if($cover_img_result){
                    $cover_img_url = $this->img_pre_url.$this->bbs_upload_path.DS.$upload_file->file_name;
//                    p($cover_img_url);
                    $update['pic'] = $cover_img_url;
                    $result = @$db_cls->where(array("id"=>$row))->update($update);
                }
                /* 上传封面图 end */
                showMessage("添加成功",BBS_SITE_URL.DS.'index.php?act=admin_activity&op=cls_list');
            }else{
                showMessage("添加失败",'','','error');
            }
        }else{

            Tpl::showpage("cls_add");
        }
    }
    /* 活动类别列表 end */

    /* 类别删除 start */
    public function cls_delOp(){
        $db_cls = new Model('bbs_cls');
        $where['id'] = $_GET['id'];
        /* 判断是否有下级没有则可以删除 start */
        $data_cls = $db_cls->where(array('pid'=>$_GET['id']))->select();
        if($data_cls){
            showMessage("请先删除下级");
            die();
        }
        /* 判断是否有下级没有则可以删除 end */
        $result = $db_cls->where($where)->delete();
        showMessage("删除成功");

    }
    /* 类别删除 end */

    /* 类别类别的ajax 返回 start */
    public function cls_ajaxOp(){
        $db_cls = new Model('bbs_cls');

        $where['level'] = 1;
        $data_cls = $db_cls->where($where)->select();

        ajaxReturn(array('control'=>'cls_ajax','code'=>200,'msg'=>'成功','data'=>$data_cls),"JSON");
    }
    /* 类别类别的ajax 返回 end */

    /* 获取分类列表 start */
    public function get_cls_listOp(){
        $db_cls = new Model('bbs_cls');
        $data_first = $db_cls
            ->where(array('level'=>1))
            ->order('id asc')
            ->select();
        $data = array();
        for($i=0;$i<count($data_first);$i++){
            array_push($data,$data_first[$i]);
            $data_second = $db_cls->where(array('level'=>2,'pid'=>$data_first[$i]['id']))->order('id asc')->select();
            if($data_second){
                for($j=0;$j<count($data_second);$j++){
                    array_push($data,$data_second[$j]);
                }
            }
        }
//        P($data);
        ajaxReturn(array('control'=>'get_cls_listOp','code'=>200,'msg'=>'成功','data'=>$data),"JSON");
    }
    /* 获取分类列表 end */
}