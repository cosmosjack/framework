<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2017/7/11
 * Time: 16:58
 * QQ:  997823131 
 */

$_GET['act'] = 'payment';
$_GET['op'] = 'notify';
$_GET['payment_code'] = 'app_pay';
//$log_path = BASE_DATA_PATH.DS."log".DS.$this->payment_code.DS."ES".DS.date("Y-m-d",time()).".log";
$log_path = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'app_wx_pay'.DIRECTORY_SEPARATOR.'wx_log.txt';
@file_put_contents($log_path,date("Y-m-d H:i:s",time()).PHP_EOL,FILE_APPEND);
//die;
require __DIR__ . '/../../../index.php';