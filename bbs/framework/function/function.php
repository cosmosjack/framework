<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/9
 * Time: 15:52
 * QQ:  997823131 
 */

/*
 * 发短信接口
 * $number  手机号码
 * $type 类型  1 短信验证码  2 活动开始提醒  3 订单支付成功提醒  4 最新活动提醒  5 找回密码提醒  6 绑定微信提醒
 */
function yunpian_sms($number,$type='1',$code){
    $message = "【时刻需】您的验证码是".$code;
    $sms = new Sms();
    $result = $sms->send($number, $message);
    if($result['code'] == 0){
        return true;
    }else{
        return false;
    }
}
/**
 * 是否是AJAx提交的
 * @return bool
 */
function isAjax(){
  if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    return true;
  }else{
    return false;
  }
}
/**
 * 手机号验证
 * @param $phone 手机号
 * @return bool
 */
function isPhone($phone){
	$reg = '/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/';
	return preg_match($reg,$phone);
}
/**
 * 检测字符串是否是电子邮件地址格式
 * @param  $email    待检测字符串
 */
function isEmail($email){
    $reg = '/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/';
    return preg_match($reg,$email);
}
/**
 * bbs使用的URL链接函数，强制使用动态传参数模式
 *
 * @param string $act control文件名
 * @param string $op op方法名
 * @param array $args URL其它参数
 * @return string
 */
function urlBBS($act = '', $op = '', $args = array()){
    return url($act, $op, $args, false, BBS_SITE_URL);
}
/**
 * 手机号用-连接
 * @param  $phone    手机号
 * @return string
 */
function phoneLink($phone){
	return substr($phone, 0,3).'-'.substr($phone, 3,4).'-'.substr($phone, 7);
}
/**
 * 根据区域id获取区域名称
 * @param  $area_id    区域id
 * @return string
 */
function getAreaName($area_id){
    $db_area = Model('area');
    $info = $db_area->field('area_name')->where('area_id='.$area_id)->find();
    return $info['area_name'];
}
/* 计算当前活动是否有结束的 start */
function calc_activity(){
    $now_time = time();
    $where = array("activity_end_time"=>array("lt",$now_time));
    $db_activity = new Model("bbs_activity");
    $data_activity = $db_activity->where($where)->select();
    /* 如果有应该已结束的活动 那么就 复制他到 activity_periods 表中 然后 结束他 start */
    if($data_activity){
        $db_activity_periods = new Model("bbs_activity_periods");
        foreach($data_activity as $key=>$val){
            $tmp_data_insert = $val;
            unset($tmp_data_insert['id']);
            @$result = $db_activity_periods->insert($tmp_data_insert);
            /* 根据相应的 activity_no 插入新的最新一期 如果没有则不删除当前这一期的 start */
            $data_activity_periods = $db_activity_periods->where(array("activity_no"=>$val['activity_no'],"activity_periods"=>array("gt",intval($val['activity_periods'])),"activity_end_time"=>array("gt",$now_time)))->order("activity_periods asc")->find();
            if($data_activity_periods){
                unset($data_activity_periods['id']);
                @$result_new_insert = $db_activity->insert($data_activity_periods);
                if($result_new_insert){
                    @$result_old_del = $db_activity->where(array("id"=>$val['id']))->delete();// 删除 activity表的已过期的活动

                }
            }
            /* 根据相应的 activity_no 插入新的最新一期 如果没有则不删除当前这一期的 end */
        }
    }
    /* 如果有应该已结束的活动 那么就 复制他到 activity_periods 表中 然后 结束他 end */



}
/* 计算当前活动是否有结束的 end */

/**
 * 取得随机数,大写字母
 *
 * @param int $length 生成随机数的长度
 * @param int $numeric 是否只产生数字随机数 1是0否
 * @return string
 */
function randomUp($length, $numeric = 0) {
    $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', strtoupper($seed)).'012340567890') : (strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $seed{mt_rand(0, $max)};
    }
    return $hash;
}

/* 整理小组的详情 start */
 function calc_group($activity_no,$periods){
    if(empty($activity_no)){
        return array('code'=>0,'msg'=>'非法请求');
        die();
    }
    // 根据活动的no 和 期数  来查找 申请通过的 儿童信息  并分组
    $db_bbs_apply = new Model();
    // 第一次先按 分组 查询出 所有小组
    $data_group_info = $db_bbs_apply->query("SELECT COUNT(*) AS total_num,33hao_bbs_apply.activity_no,33hao_bbs_apply.teacher_id,33hao_bbs_apply.teacher_name,33hao_bbs_apply.group_id,33hao_bbs_apply.id,33hao_bbs_user.member_phone as teacher_phone ,33hao_bbs_apply.activity_periods FROM 33hao_bbs_apply LEFT JOIN 33hao_bbs_user ON 33hao_bbs_user.id = 33hao_bbs_apply.teacher_id WHERE `activity_no`='".$activity_no."' AND `activity_periods`={$periods} GROUP BY `group_id`");
    if(!$data_group_info){
        return array('code'=>0,'msg'=>'暂无任何报名信息');
        die();
    }
     return array('code'=>200,'msg'=>'成功','data'=>$data_group_info);

}
/* 整理小组的详情 end */