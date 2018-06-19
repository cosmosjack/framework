<?php
defined('InCosmos') or exit('Access Invalid!');
$_limit =  array(
	array('name'=>'设置', 'child'=>array(
        array('name'=>"后台访问", 'op'=>"index", 'act'=>'admin'),
        array('name'=>"网站设置", 'op'=>"setting", 'act'=>'admin'),
		array('name'=>"个人资料", 'op'=>"admin_info", 'act'=>'admin'),
		array('name'=>"网站信息", 'op'=>"web_info", 'act'=>'admin'),
		))
);

/*
if (C('flea_isuse') !== NULL){
	$_limit[] = array('name'=>'闲置', 'child'=>array(
		array('name'=>'SEO设置', 'op'=>NULL, 'act'=>'flea_index'),
		array('name'=>'分类管理', 'op'=>NULL, 'act'=>'flea_class'),
		array('name'=>'首页分类管理', 'op'=>NULL, 'act'=>'flea_class_index'),
		array('name'=>'闲置管理', 'op'=>NULL, 'act'=>'flea'),
		array('name'=>'地区管理', 'op'=>NULL, 'act'=>'flea_cs')
		));
}
if (C('mobile_isuse') !== NULL){
	$_limit[] = array('name'=>$lang['nc_mobile'], 'child'=>array(
		array('name'=>'首页设置', 'op'=>NULL, 'act'=>'mb_special'),
		array('name'=>'专题设置', 'op'=>NULL, 'act'=>'mb_special'),
		array('name'=>$lang['nc_mobile_catepic'], 'op'=>NULL, 'act'=>'mb_category'),
		array('name'=>'下载设置', 'op'=>NULL, 'act'=>'mb_app'),
		array('name'=>$lang['nc_mobile_feedback'], 'op'=>NULL, 'act'=>'mb_feedback'),
		array('name'=>'手机支付', 'op'=>NULL, 'act'=>'mb_payment'),
		));
}

if (C('microshop_isuse') !== NULL){
	$_limit[] = array('name'=>$lang['nc_microshop'], 'child'=>array(
		array('name'=>$lang['nc_microshop_manage'], 'op'=>'manage', 'act'=>'microshop'),
		array('name'=>$lang['nc_microshop_goods_manage'], 'op'=>'goods|goods_manage', 'act'=>'microshop'),//op值重复(goods_manage,goodsclass_list,personal_manage...)是为了无权时，隐藏该菜单
		array('name'=>$lang['nc_microshop_goods_class'], 'op'=>'goodsclass|goodsclass_list', 'act'=>'microshop'),
		array('name'=>$lang['nc_microshop_personal_manage'], 'op'=>'personal|personal_manage', 'act'=>'microshop'),
		array('name'=>$lang['nc_microshop_personal_class'], 'op'=>'personalclass|personalclass_list', 'act'=>'microshop'),
		array('name'=>$lang['nc_microshop_store_manage'], 'op'=>'store|store_manage', 'act'=>'microshop'),
		array('name'=>$lang['nc_microshop_comment_manage'], 'op'=>'comment|comment_manage', 'act'=>'microshop'),
		array('name'=>$lang['nc_microshop_adv_manage'], 'op'=>'adv|adv_manage', 'act'=>'microshop')
		));
}

if (C('cms_isuse') !== NULL){
	$_limit[] = array('name'=>$lang['nc_cms'], 'child'=>array(
		array('name'=>$lang['nc_cms_manage'], 'op'=>null, 'act'=>'cms_manage'),
		array('name'=>$lang['nc_cms_index_manage'], 'op'=>null, 'act'=>'cms_index'),
		array('name'=>$lang['nc_cms_article_manage'], 'op'=>null, 'act'=>'cms_article|cms_article_class'),
		array('name'=>$lang['nc_cms_picture_manage'], 'op'=>null, 'act'=>'cms_picture|cms_picture_class'),
		array('name'=>$lang['nc_cms_special_manage'], 'op'=>null, 'act'=>'cms_special'),
		array('name'=>$lang['nc_cms_navigation_manage'], 'op'=>null, 'act'=>'cms_navigation'),
		array('name'=>$lang['nc_cms_tag_manage'], 'op'=>null, 'act'=>'cms_tag'),
		array('name'=>$lang['nc_cms_comment_manage'], 'op'=>null, 'act'=>'cms_comment')
		));
}

if (C('circle_isuse') !== NULL){
	$_limit[] = array('name'=>$lang['nc_circle'], 'child'=>array(
		array('name'=>$lang['nc_circle_setting'], 'op'=>null, 'act'=>'circle_setting'),
		array('name'=>'成员头衔设置', 'op'=>null, 'act'=>'circle_memberlevel'),
		array('name'=>$lang['nc_circle_classmanage'], 'op'=>null, 'act'=>'circle_class'),
		array('name'=>$lang['nc_circle_manage'], 'op'=>null, 'act'=>'circle_manage'),
		array('name'=>$lang['nc_circle_thememanage'], 'op'=>null, 'act'=>'circle_theme'),
		array('name'=>$lang['nc_circle_membermanage'], 'op'=>null, 'act'=>'circle_member'),
		array('name'=>'圈子举报管理', 'op'=>null, 'act'=>'circle_inform'),
		array('name'=>$lang['nc_circle_advmanage'],'op'=>'adv_manage', 'act'=>'circle_setting')
		));
}*/

return $_limit;
