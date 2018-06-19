<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/4/26
 * Time: 15:26
 * QQ:  997823131 
 */
class admin_wordsControl extends BaseAdminControl{
    public function __construct(){
        parent::__construct();
    }
    public function words_listOp(){

        $db_bbs_words = new Model();
        /* 查询条件 start */
        $where = array("words_name"=>array('like',"%{$_GET['search']['value']}%"));
        /* 查询条件 end */
        /* 排序条件 start */
        $column = array("id","words_name","sort");
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
        $db_total = $db_bbs_words->table("bbs_words")->where($where)->count();
//        $data_bbs_user = $db_bbs_words->where($where)->order()->limit($db_limit)->select();


        $data_bbs_user = $db_bbs_words
            ->table("bbs_words")
            ->field("id,words_name,sort")

            ->where($where)
            ->order($order)
            ->limit($db_limit)
            ->select();

        ajaxReturn(array('draw'=>$db_draw,'recordsTotal'=>$db_total,'recordsFiltered'=>$db_total,'data'=>$data_bbs_user),"json");
    }

    public function add_wordsOp(){
        $db_bbs_words = new Model("bbs_words");
        $insert['words_name'] = $_POST['words_name'];
        $insert['sort'] = $_POST['sort']?$_POST['sort']:0;
        $row = $db_bbs_words->insert($insert);
        if($row){
            ajaxReturn(array('control'=>'add_wordsOp','code'=>200,'msg'=>'添加成功'),"JSON");

        }else{
            ajaxReturn(array('control'=>'add_wordsOp','code'=>0,'msg'=>'添加失败'),"JSON");

        }
    }

    public function del_wordsOp(){
        $db_bbs_words = new Model("bbs_words");
        $where['id'] = $_POST['id'];
        $result = @$db_bbs_words->where($where)->delete();

        ajaxReturn(array('control'=>'del_words','code'=>200,'msg'=>'删除成功'),"JSON");

    }

    public function mod_wordsOp(){
        $db_bbs_words = new Model("bbs_words");
        $where['id'] = $_POST['id'];
        $update['words_name'] = $_POST['words_name'];
        $update['sort'] = $_POST['sort'];
        $result = $db_bbs_words->where($where)->update($update);
        if($result){
            ajaxReturn(array('control'=>'del_words','code'=>200,'msg'=>'修改成功'),"JSON");
        }else{
            ajaxReturn(array('control'=>'del_words','code'=>200,'msg'=>'修改成功'),"JSON");
        }
    }
}