<?php
/**
 * Created by 大师兄
 * 派系: 神秘剑派
 * 技能: zxc秒杀
 * Date: 2018/3/9
 * Time: 15:49
 * QQ:  997823131 
 */

/*
 *  前端顶部控制器
 */
class BaseControl{
    public function __construct(){
        calc_activity();
        Tpl::setLayout("common_layout");
        Tpl::setDir('home');
    }
}

/*
 *  后台主控制器
 */
class BaseAdminControl{
    /**
     * 权限内容
     */
    protected $permission;

    public function __construct(){
        Language::read('common,layout');
        /* 判断是否有权限请求控制器 start */
        //需要登录时 返回 用户的信息及权限小组信息
        $is_login = $_SESSION['is_login'];
        if(!$is_login){
            showMessage("请登录",BBS_SITE_URL.DS.'index.php?act=admin_login');
            die();
        }
        $this->checkPermission();
//        p($permission);
        //获取权限列表 start

        //获取权限列表 end
        /* 判断是否有权限请求控制器 end */

        calc_activity();// 自动计算 活动是否已过期
        Tpl::setLayout("admin_layout");
        Tpl::setDir("admin");
    }

    /**
     * 验证当前管理员权限是否可以进行操作
     *
     * @param string $link_nav
     * @return
     */
    protected final function checkPermission($link_nav = null){
        if ($_SESSION['admin_info']['admin_id'] == 1) return true;

        $act = $_GET['act']?$_GET['act']:$_POST['act'];
        $op = $_GET['op']?$_GET['op']:$_POST['op'];
        if (empty($this->permission)){
            $gadmin = Model('gadmin')->getby_gid($_SESSION['admin_info']['admin_gid']);
            $permission = decrypt($gadmin['limits'],MD5_KEY.md5($gadmin['gname']));
            $this->permission = $permission = explode('|',$permission);
        }else{
            $permission = $this->permission;
        }
        //显示隐藏小导航，成功与否都直接返回
        if (is_array($link_nav)){
            if (!in_array("{$link_nav['act']}.{$link_nav['op']}",$permission) && !in_array($link_nav['act'],$permission)){
                return false;
            }else{
                return true;
            }
        }

        //以下几项不需要验证
        $tmp = array('index','dashboard','login','common','cms_base','admin_login');
        if (in_array($act,$tmp)) return true;
        if (in_array($act,$permission) || in_array("$act.$op",$permission)){
            return true;
        }else{
            $extlimit = array('ajax','export_step1');
            if (in_array($op,$extlimit) && (in_array($act,$permission) || strpos(serialize($permission),'"'.$act.'.'))){
                return true;
            }
            //带前缀的都通过
            foreach ($permission as $v) {
                if (!empty($v) && strpos("$act.$op",$v.'_') !== false) {
                    return true;break;
                }
            }
        }
        showMessage(Language::get('nc_assign_right'),'','html','succ',0);
    }

    /**
     * 过滤掉无权查看的菜单
     *
     * @param array $menu
     * @return array
     */
    private final function parseMenu($menu = array()){
        if ($_SESSION['admin_info']['admin_id'] == 1) return $menu;
        foreach ($menu['left'] as $k=>$v) {
            foreach ($v['list'] as $xk=>$xv) {
                $tmp = explode(',',$xv['args']);
                //以下几项不需要验证
                $except = array('index','dashboard','login','common');
                if (in_array($tmp[1],$except)) continue;
                if (!in_array($tmp[1],$this->permission) && !in_array($tmp[1].'.'.$tmp[0],$this->permission)){
                    unset($menu['left'][$k]['list'][$xk]);
                }
            }
            if (empty($menu['left'][$k]['list'])) {
                unset($menu['top'][$k]);unset($menu['left'][$k]);
            }
        }
        return $menu;
    }

    /**
     * 取得顶部小导航
     *
     * @param array $links
     * @param 当前页 $actived
     */
    protected final function sublink($links = array(), $actived = '', $file='index.php'){
        $linkstr = '';
        foreach ($links as $k=>$v) {
            parse_str($v['url'],$array);
            if (!$this->checkPermission($array)) continue;
            $href = ($array['op'] == $actived ? null : "href=\"{$file}?{$v['url']}\"");
            $class = ($array['op'] == $actived ? "class=\"current\"" : null);
            $lang = L($v['lang']);
            $linkstr .= sprintf('<li><a %s %s><span>%s</span></a></li>',$href,$class,$lang);
        }
        return "<ul class=\"tab-base\">{$linkstr}</ul>";
    }

    /**
     * 记录系统日志
     *
     * @param $lang 日志语言包
     * @param $state 1成功0失败null不出现成功失败提示
     * @param $admin_name
     * @param $admin_id
     */
    protected final function log($lang = '', $state = 1, $admin_name = '', $admin_id = 0){
        if (!C('sys_log') || !is_string($lang)) return;
        if ($admin_name == ''){
            $admin = unserialize(decrypt(cookie('sys_key'),MD5_KEY));
            $admin_name = $admin['name'];
            $admin_id = $admin['id'];
        }
        $data = array();
        if (is_null($state)){
            $state = null;
        }else{
//			$state = $state ? L('nc_succ') : L('nc_fail');
            $state = $state ? '' : L('nc_fail');
        }
        $data['content'] 	= $lang.$state;
        $data['admin_name'] = $admin_name;
        $data['createtime'] = TIMESTAMP;
        $data['admin_id'] 	= $admin_id;
        $data['ip']			= getIp();
        $data['url']		= $_REQUEST['act'].'&'.$_REQUEST['op'];
        return Model('admin_log')->insert($data);
    }
}
