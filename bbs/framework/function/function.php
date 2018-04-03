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
//    p($data_activity);
    /* 如果有应该已结束的活动 那么就 复制他到 activity_periods 表中 然后 结束他 start */
    if($data_activity){
        $db_activity_periods = new Model("bbs_activity_periods");
        foreach($data_activity as $key=>$val){
            $tmp_data_insert = $val;
            unset($tmp_data_insert['id']);
            @$result = $db_activity_periods->insert($tmp_data_insert);
            /* 根据相应的 activity_no 插入新的最新一期 如果没有则不删除当前这一期的 start */
            $data_activity_periods = $db_activity_periods->where(array("activity_no"=>$val['activity_no'],"activity_periods"=>array("eq",intval($val['activity_periods']+1)),"activity_end_time"=>array("gt",$now_time)))->find();
//            p($data_activity_periods);
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

