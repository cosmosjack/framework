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
        if($data_bbs_order){
            $this->createExcel($data_bbs_order);
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
//        $excel_data[0][] = array('styleid'=>'s_title','data'=>'参加人员');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单金额');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单状态');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付码');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'备注');

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
            $tmp[] = array('data'=>$v['order_num']);//活动地点

            $tmp[] = array('data'=>$v['order_amount']);//备注
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


            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset('活动订单',CHARSET));
        $excel_obj->generateXML($excel_obj->charset('活动订单',CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }

}