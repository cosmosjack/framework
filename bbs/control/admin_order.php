<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/4/26
 * Time: 11:39
 * QQ:  997823131 
 */
class admin_orderControl extends BaseAdminControl{
    public function __construct(){
        parent::__construct();
    }
    public function mod_orderOp(){
        //根据订单ID 改变订单的金额
        $db_bbs_order = new Model('bbs_order');
        $where['id'] = $_POST['order_id'];
        $update['order_amount'] = $_POST['order_amount'];
        $result = $db_bbs_order->where($where)->update($update);
        if($result){
            showMessage("修改成功");
        }else{
            showMessage("修改失败",'',',','error');
        }
    }

    /* 订单导出 start */
    public function order_excelOp(){
        // 1 已付款  2 未付款  3 已取消  4已退款
        // 1.未付款 2.已付款未参加 3.已付款已参加 4.退款中 5.已退款6已取消
        $where = array();
        /* 是否有限制订单状态 start */
        if(isset($_GET['order_state']) && is_numeric($_GET['order_state'])){
            $where['order_status'] = $_GET['order_state'];
        }
        /* 是否有限制订单状态 end */
        if(!empty($_GET['activity_title'])){
            $where['activity_title'] = array("like","%".$_GET['activity_title']."%");
        }
        $order = "order_time desc";
        $db_bbs_order = new Model("bbs_order");
        $data_bbs_order = $db_bbs_order
            ->where($where)
            ->order($order)
//            ->page(6)
            ->select();
        $data = array();
        foreach($data_bbs_order as $key=>$val){
            $data_bbs_order[$key]['child_info'] = unserialize($val['childs_arr']);
            $data_bbs_order[$key]['parent_info'] = unserialize($val['parents_arr']);
            $data_bbs_order[$key]['activity_price'] = floatval($val['order_amount']/$val['order_num']); // 单价

            foreach($data_bbs_order[$key]['child_info'] as $k=>$v){
                $db_child = new Model('bbs_child');
                $info = $db_child->where(array('id'=>$v['id']))->find();
                if(!empty($info)){
                    if($info['child_sex'] ==1){
                        $sex = '男';
                    }elseif($info['child_sex']==2){
                        $sex = '女';
                    }else{
                        $sex = '保密';
                    }
                    $data_bbs_order[$key]['child_name'] = $info['child_name'];
                    $data_bbs_order[$key]['child_sex'] = $sex;
                    $data_bbs_order[$key]['child_age'] = $info['child_age'];
                    $data_bbs_order[$key]['papers_no'] = $info['child_papers_no'];
                    $data_bbs_order[$key]['child_height'] = $info['child_height'];
                    $data_bbs_order[$key]['child_weight'] = $info['child_weight'];
                    $data_bbs_order[$key]['child_size'] = $info['child_size'];
                    $data_bbs_order[$key]['child_remark'] = $info['child_remark'];
                    $data_bbs_order[$key]['staff'] = $info['staff'];
                }else{
                    if($v['sex'] ==1){
                        $sex = '男';
                    }elseif($v['sex']==2){
                        $sex = '女';
                    }else{
                        $sex = '保密';
                    }
                    $data_bbs_order[$key]['child_name'] = $v['name'];
                    $data_bbs_order[$key]['child_sex'] = $sex;
                    $data_bbs_order[$key]['child_age'] = $v['age'];
                    $data_bbs_order[$key]['child_size'] = $v['size'];
                    $data_bbs_order[$key]['child_remark'] = $v['remark'];
                    $data_bbs_order[$key]['papers_no'] = $v['papers_no'];
                    $data_bbs_order[$key]['staff'] = $v['staff'];

                    $data_bbs_order[$key]['child_height'] = $v['height'];
                    $data_bbs_order[$key]['child_weight'] = $v['weight'];
                }

                

                $data_bbs_order[$key]['parent_name'] = $data_bbs_order[$key]['parent_info'][0]['name'];
                $data_bbs_order[$key]['parent_phone'] = $data_bbs_order[$key]['parent_info'][0]['phone'];
                $data_bbs_order[$key]['parent_relation'] = $data_bbs_order[$key]['parent_info'][0]['relation'];
                $data_temp = $data_bbs_order[$key];
                array_push($data,$data_temp);
            }
        }
        if($data && !empty($data)){
//            p($data);
//            die();
            $this->createExcel($data);
        }else{
            showMessage("没有任何数据,不能导出Excel");
        }
    }
    /* 订单导出 end */

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()){
        // 1 已付款  2 未付款  3 已取消  4已退款
        // 1.未付款 2.已付款未参加 3.已付款已参加 4.退款中 5.已退款 6.已取消

        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单码');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'活动ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'活动标题');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'活动时间');

        $excel_data[0][] = array('styleid'=>'s_title','data'=>'活动期数');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'活动地址');
//        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家会员手机号');

        $excel_data[0][] = array('styleid'=>'s_title','data'=>'活动类别ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'会员ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'会员名字');

        $excel_data[0][] = array('styleid'=>'s_title','data'=>'票数');

        $excel_data[0][] = array('styleid'=>'s_title','data'=>'儿童');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'儿童性别');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'儿童年龄');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'儿童尺码');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'儿童身高');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'儿童体型');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'儿童身体情况');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'证件号码');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'业务员');
        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'监护人');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'监护人电话');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'监护人关系');

//        $excel_data[0][] = array('styleid'=>'s_title','data'=>'参加人员');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'活动价格');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单状态');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付码');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'备注');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单时间');
        //data
        foreach ((array)$data as $k=>$v){
            $tmp = array();
            $tmp[] = array('data'=>$v['id']);
            $tmp[] = array('data'=>$v['code']);
            $tmp[] = array('data'=>$v['activity_no']);//发布者ID
            $tmp[] = array('data'=>$v['activity_title']);//却单人
            $tmp[] = array('data'=>$v['activity_time']);//发布者ID
            $tmp[] = array('data'=>$v['activity_periods']);
            $tmp[] = array('data'=>$v['activity_address']);//买家电话
//            $tmp[] = array('data'=>$v['user_member_phone']);//买家会员手机号

            $tmp[] = array('data'=>$v['activity_cls_id']);//活动开始时间
            $tmp[] = array('data'=>$v['member_id']);//活动结束时间
            $tmp[] = array('data'=>$v['member_name']);//活动地点
            // $tmp[] = array('data'=>$v['order_num']);//票数
            $tmp[] = array('data'=>1);//票数

            $tmp[] = array('data'=>$v['child_name']);//儿童
            $tmp[] = array('data'=>$v['child_sex']);//儿童性别
            $tmp[] = array('data'=>$v['child_age']);//年龄
            $tmp[] = array('data'=>$v['child_size']);//尺寸
            $tmp[] = array('data'=>$v['child_height']);// 学员身高
            $tmp[] = array('data'=>$v['child_weight']);// 学员体型
            $tmp[] = array('data'=>$v['child_remark']);//身体情况
            $tmp[] = array('data'=>$v['papers_no']);//证件号码
            $tmp[] = array('data'=>$v['staff']);// 员工
            
            $tmp[] = array('data'=>$v['parent_name']);//监护人
            $tmp[] = array('data'=>$v['parent_phone']);//监护人电话
            $tmp[] = array('data'=>$v['parent_relation']);//关系


            $tmp[] = array('data'=>$v['activity_price']);//单价
//            $tmp[] = array('data'=>$v['confirm_arr']);//参加人员
            // 1.未付款 2.已付款未参加 3.已付款已参加 4.退款中 5.已退款 6.已取消
            switch($v['order_status']){
                case "1":
                    $tmp[] = array('data'=>'未付款');//echo '已付款';
                    break;
                case "2":
                    $tmp[] = array('data'=>'未参加');//echo '已退款';
                    break;
                case "3":
                    $tmp[] = array('data'=>'已参加');//echo '已取消';
                    break;
                case "4":
                    $tmp[] = array('data'=>'退款中');//echo '已取消';
                    break;
                case "5":
                    $tmp[] = array('data'=>'已退款');//echo '已取消';
                    break;
                case "6":
                    $tmp[] = array('data'=>'已取消');//echo '已取消';
                    break;

            };
            $tmp[] = array('data'=>$v['pay_no']);//支付码
            $tmp[] = array('data'=>$v['remark']);//备注
            $tmp[] = array('data'=>substr($v['pay_no'], 4,8));//支付时间
            $tmp[] = array('data'=>date('Y-m-d',$v['order_time']));//下单时间

            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset('活动订单',CHARSET));
        $excel_obj->generateXML($excel_obj->charset('活动订单',CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }

}