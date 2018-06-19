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
      <h3><?php echo $lang['nc_limit_manage'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="admin_form" method="post" action='index.php?act=admin&op=admin_edit&admin_id=<?php echo $output['admininfo']['admin_id'];?>'>
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_index_username'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['admininfo']['admin_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="new_pw"><?php echo $lang['admin_edit_admin_pw']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="new_pw" name="new_pw" class="txt" type="password"></td>
           <td class="vatop tips"><?php echo $lang['admin_edit_pwd_tip1'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="new_pw2"><?php echo $lang['admin_edit_admin_pw2']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="new_pw2" name="new_pw2" class="txt" type="password"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="gadmin_name"><?php echo $lang['gadmin_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          <select name="gid">
          <?php foreach((array)$output['gadmin'] as $v){?>
          <option <?php if ($v['gid'] == $output['admininfo']['admin_gid']) echo 'selected';?> value="<?php echo $v['gid'];?>"><?php echo $v['gname'];?></option>
          <?php }?>
          </select>
          </td>
          <td class="vatop tips"><?php echo $lang['admin_add_gid_tip'];?></td>
        </tr>        
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    $("#admin_form").submit();

//    if($("#admin_form").valid()){
//     $("#admin_form").submit();
//	}
	});
});
$(document).ready(function(){
	/*$("#admin_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	new_pw : {
				minlength: 6,
				maxlength: 20
            },
            new_pw2 : {
				minlength: 6,
				maxlength: 20,
				equalTo: '#new_pw'
            },
            gid : {
                required : true
            }
        },
        messages : {
        	new_pw : {
				minlength: '<?php echo $lang['admin_add_password_max'];?>',
				maxlength: '<?php echo $lang['admin_add_password_max'];?>'
            },
            new_pw2 : {
				minlength: '<?php echo $lang['admin_add_password_max'];?>',
				maxlength: '<?php echo $lang['admin_add_password_max'];?>',
				equalTo:   '<?php echo $lang['admin_edit_repeat_error'];?>'
            },
            gid : {
                required : '<?php echo $lang['admin_add_gid_null'];?>'
            }
        }
	});*/
});
</script>