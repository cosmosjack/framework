<?php defined('InCosmos') or exit('Access Invalid!');?>
<style>
    /*内容页面样式
------------------------------------------------------------------- */
    .page { padding: 9px 20px 20px; text-align: left;}
    .fixed-bar {background: #FFF url(<?php echo BBS_RESOURCE_SITE_URL.DS.'images'.DS.'sky';?>/fixed_bg.png) repeat-x scroll center bottom; width: 99%; padding: 8px 20px 8px 0; margin-left: 20px; position: fixed; top: 0; left: 0; z-index: 99;}
    * html .fixedbar { width: 100%; margin-top: -10px; position: relative; left: -20px;}

    .fixed-empty { height: 50px !important;}
    .item-title { line-height: 20px; margin-bottom: 0 !important; clear: both; overflow: hidden; _padding-bottom: 10px; +padding-bottom: 10px;}
    .item-title h3 { float: left; margin-right:20px; }
    .tab-base {float: left; overflow: hidden; padding-top:16px; }
    .tab-base li { float: left;list-style-type: none;}
    .tab-base a { font-weight: 700; line-height: 20px; background: #FFF url(<?php echo BBS_RESOURCE_SITE_URL.DS.'images'.DS.'sky';?>/bg_position.gif) no-repeat 0px -200px; height: 20px; float: left; padding-left: 9px; margin-right:2px;  cursor: pointer;}
    .tab-base a:hover { color: #09C; background-position: 0 -220px; }
    .tab-base a span { color: #555; background: url(<?php echo BBS_RESOURCE_SITE_URL.DS.'images'.DS.'sky';?>/bg_position.gif) no-repeat 9999px 9999px; float: left; padding-right: 9px; }
    .tab-base a:hover span {  background-position: 100% -220px;}
    .tab-base a.current, .tab-base a:hover.current { background-position: 0 -240px; cursor: default;}
    .tab-base a.current span, .tab-base a:hover.current span{ color: #FFF; background-position: 100% -240px;}
    /* table
    ------------------------------------------------------------------- */
    .table { clear:both; width:100%; margin-top: 8px}
    .table th, .table td{ padding:6px !important; height:26px; }
    .nohover td { background:#FFF !important;}

    .tb-type1{}
    .tb-type1 th{ padding:5px 5px 3px 0; line-height:21px; color: #333;}
    .tb-type1 td{ padding:5px 5px 3px 0;}
    .tb-type1 td input[type="text"], .tb-type1 td select{ margin-right:4px; _margin-right:2px; margin-left:4px; _margin-left:2px; }
    .tb-type1 td select { width:auto;}
    .tb-type1 .txt-short { width:80px;}
    .tb-type1 .txt { width:140px;}
    .tb-type1 .txt2 { width:220px;}
    .tb-type1 .date , .tb-type1 .date:hover { background: url(<?php echo BBS_RESOURCE_SITE_URL.DS.'images'.DS;?>input_date.gif) no-repeat 0 0; padding-left: 25px; width:70px;}
    .tb-type1 .date { background-color: #FAFAFA; }
    .tb-type1 .date:hover { background-color: #FFF;}
    #gcategory select{ margin-right:3px;}
    .tb-type1 strong{ margin-right:5px; color:#F60; }


    /* tb */
    .tb-type2{}
    .tb-type2 tr.hover:hover .tips2{ color:#333; }
    .tb-type2 td, tb-type2 th.td{ padding:5px 5px 3px 0; border-top: 1px dotted #CBE9F3; }
    .tb-type2 .tfoot td {padding:5px 5px 3px 0; border-top: 1px solid #CBE9F3;}
    .tb-type2 th{ padding:5px 5px 3px 0; line-height:21px; font-size: 12px; }
    .tb-type2 .txt, .tb-type2 .txtnobd{ width:100px; margin-right:10px; }
    .tb-type2 .smtxt { margin-right: 5px; width: 25px; }
    .nowrap { white-space: nowrap; }
    .tb-type2 .required { padding:3px 0 3px 5px; font-weight:700; }
    .tb-type2 .required span { line-height: 20px; font-weight: normal; color: #777; margin-left: 16px;}
    .tb-type2 .required span .checkbox { vertical-align: middle; margin-right: 4px;}
    .tb-type2 .rowform{ padding-left:5px; vertical-align: middle;}
</style>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_admin_log'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_admin_log'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="admin_log">
    <input type="hidden" name="op" value="list">
    <input type="hidden" name="delago" id="delago" value="">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['admin_log_man'];?></th>
          <td><input class="txt" name="admin_name" value="<?php echo $_GET['admin_name'];?>" type="text"></td>
          <th><?php echo $lang['admin_log_dotime'];?></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['time_from'];?>" id="time_from" name="time_from">
            <label for="time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['time_to'];?>" id="time_to" name="time_to"/></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['admin_log_tips1'];?></li>
            <li><?php echo $lang['admin_log_tips2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>   
  <form method="post" id='form_list' action="index.php?act=admin_log&op=list_del">
    <input type="hidden" name="form_submit" value="ok" />
    <div style="text-align:right;"><a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?>Excel</span></a></div>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['admin_log_man'];?></th>
          <th><?php echo $lang['admin_log_do'];?></th>
          
          <th class="align-center"><?php echo $lang['admin_log_dotime'];?></th>
          <th class="align-center">IP</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover">
          <td class="w24">
            <input name="del_id[]" type="checkbox" class="checkitem" value="<?php echo $v['id']; ?>">
          </td>
          <td><?php echo $v['admin_name']; ?></td>
          <td><?php echo $v['content'];?></td>
          <td class="align-center"><?php echo date('Y-m-d H:i:s',$v['createtime']); ?></td>
          <td class="align-center"><?php echo $v['ip']; ?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom" name="chkVal"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){$('#form_list').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
<?php echo $lang['nc_del'];?>
<select name="delago1" id="delago1">
<option value="<?php echo 3600*24*7;?>"><?php echo $lang['admin_log_ago_1zhou'];?></option>
<option value="<?php echo 3600*24*30;?>"><?php echo $lang['admin_log_ago_1month'];?></option>
<option value="<?php echo 3600*24*60;?>"><?php echo $lang['admin_log_ago_2month'];?></option>
<option value="<?php echo 3600*24*90;?>"><?php echo $lang['admin_log_ago_3month'];?></option>
<option value="<?php echo 3600*24*180;?>"><?php echo $lang['admin_log_ago_6month'];?></option>
<option value="all"><?php echo $lang['nc_all'];?></option>
</select><?php echo $lang['nc_record'];?>
<a class="btn" href="javascript:void(0);" id="ncdelete"><span><?php echo $lang['nc_del'];?></span></a>
            
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncexport').click(function(){
    	$('input[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('list');
    	$('#formSearch').submit();
    });
    $('#ncdelete').click(function(){
        $('#delago').val($('#delago1').val());
    	$('input[name="op"]').val('list_del');$('#formSearch').submit();
    });
});
</script>
