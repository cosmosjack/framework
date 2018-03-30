<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/28
 * Time: 11:26
 * QQ:  997823131 
 */

class member_flea_listControl extends BaseControl{
    public function __construct(){
        parent::__construct();
    }

    /*
         * 获取地区信息 默认 获取省级信息
         */
    public function get_areaOp(){
        $_GET['area_id'] = $_GET['area_id']?$_GET['area_id']:'0';
        ajaxReturn(array('data'=>$this->get_area_data($_GET['area_id'])),'JSON');
    }

    /*
     * 直接通过mysqi 获取信息
     */
    private function get_area_data($where){
        $where = $where?$where:'0';
        $param = array();
        $param['table'] = 'flea_area';
        $param['where'] =  " and flea_area_parent_id = '".$where."'";;
        if( !empty($order) )
        {
            $param['order'] = $order;
        }
        $result = Db::select($param);
        return $result;
    }
}