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
                $result_update_bbs = $db_bbs_activity->where(array("id"=>$row))->update(array("activity_index_pic"=>$cover_img_url));
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
        $data_group_info = $db_bbs_apply->query("SELECT COUNT(*) AS total_num,33hao_bbs_apply.activity_id,33hao_bbs_apply.teacher_id,33hao_bbs_apply.teacher_name,33hao_bbs_apply.group_id,33hao_bbs_apply.id,33hao_bbs_user.member_phone as teacher_phone  FROM 33hao_bbs_apply LEFT JOIN 33hao_bbs_user ON 33hao_bbs_user.id = 33hao_bbs_apply.teacher_id WHERE `activity_no`={$_GET['activity_no']} AND `activity_periods`={$_GET['periods']} GROUP BY `group_id`");
        if(!$data_group_info){
            ajaxReturn(array('control'=>'calc_group','code'=>0,'msg'=>'暂无任何报名信息'),"JSON");
            die();
        }
        ajaxReturn(array('control'=>'calc_group','code'=>200,'msg'=>'成功','data'=>$data_group_info),"JSON");

    }
    /* 整理小组的详情 end */

    /* 查出小组人数大于1 的数组 start */
    public function list_group_infoOp(){
        if(!is_numeric($_GET['id'])){
            ajaxReturn(array('control'=>'calc_group','code'=>0,'msg'=>'非法请求'),"JSON");
            die();
        }
        // 根据活动的id 来查找 申请通过的 儿童信息  并分组
        $db_bbs_apply = new Model();
        // 第一次先按 分组 查询出 所有小组
        $data_group_info = $db_bbs_apply->query("SELECT COUNT(*) AS total_num,33hao_bbs_apply.activity_id,33hao_bbs_apply.teacher_id,33hao_bbs_apply.teacher_name,33hao_bbs_apply.group_id,33hao_bbs_apply.id,33hao_bbs_user.member_phone as teacher_phone  FROM 33hao_bbs_apply LEFT JOIN 33hao_bbs_user ON 33hao_bbs_user.id = 33hao_bbs_apply.teacher_id WHERE `activity_id`={$_GET['id']} GROUP BY `group_id`");
        if(!$data_group_info){
            ajaxReturn(array('control'=>'calc_group','code'=>0,'msg'=>'暂无任何报名信息'),"JSON");
            die();
        }
        $apply_id_arr = array();
        foreach($data_group_info as $k=>$v){
            if($v['total_num'] > 1){
                $apply_id_arr[] = $v['group_id'];
            }
        }
        if(empty($apply_id_arr)){
            ajaxReturn(array('control'=>'calc_group','code'=>0,'msg'=>'没有任何一个小组人数大于1的'),"JSON");
            die();
        }
        $data_apply = $db_bbs_apply->table('bbs_apply')->where(array("activity_id"=>$_GET['id'],'group_id'=>array("in",$apply_id_arr)))->select();
        ajaxReturn(array('control'=>'calc_group','code'=>200,'msg'=>'成功','data'=>$data_apply),"JSON");

    }
    /* 查出小组人数大于1 的数组 end */

    /* 根据group_id 和 activity_id  查询出 报名参加的儿童列表 start */
    public function get_team_detailOp(){
        $db_bbs_apply = new Model("bbs_apply");
        $where = array('group_id'=>$_GET['group_id'],'activity_id'=>$_GET['activity_id']);
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
        $where = array('group_id'=>$_GET['group_id'],'activity_id'=>$_GET['activity_id']);
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
        $where = array('group_id'=>array("neq",$_GET['group_id']),'activity_id'=>$_GET['activity_id']);
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
        $where = array("activity_id"=>$_GET['activity_id']);
        $update = array("group_id"=>$_GET['group_id']);

    }
    /* 将其他儿童添加到 相应的小组中去 end */

}