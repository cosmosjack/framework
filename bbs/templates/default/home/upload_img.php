<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--上传相册-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>少年宫-图片上传</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/upload_img.css" />
<body>
    <div class="upload_img">
    	<!--头部-->
    	<div class="reg_top overflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	          取消
	        </button>
	        <span class="col-xs-12">
	        	<span class="pull-right Upload" id="Upload">上传</span>
	        </span>
    	</div>
    	<div class="overflow">
    		<div class="col-xs-12 upload_select">
    			<span>上传到</span>
    			<span class="pull-right" id="up_select"><?php echo $output['info']['activity_title']?mb_substr($output['info']['activity_title'],0,12,'utf-8'):'选择活动'?> ></span>
    		</div>
    		<div class="col-xs-12 push_img">
    		    <ul></ul>
    		    <form enctype="multipart/form-data" method="post" id="submitForm">
    		    	<div class="uppush_btn">
	    		    	<div class="file-box pull-right" >
	                    <input type="file" class="file-btn upPushImg" name="photo" multiple accept="image/*" />
		                    <img src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/img/push_img.png"  />
		                </div>
	    		    </div>
    		    </form>
    		</div>
    	</div>
        <input type="hidden" id="token" value="1">
        <!--相关联的活动begin-->
        <div id="activity" style="display: none">
            <?php foreach($output['list'] as $val):?>
            <li>
                <span><?php echo mb_substr($val['activity_title'],0,12,'utf-8')?></span>
                <span class="my_ra pull-right" data-id="<?php echo $val['id']?>">
                    <?php if($val['id'] == $output['activityId']):?>
                        <span style="background: rgb(241, 153, 49);"></span>
                    <?php else:?>
                        <span></span>
                    <?php endif;?>
                </span>
            </li>
            <? endforeach;?>
        </div>
        <input type="hidden" id="activityId" value="<?php echo $output['activityId']?>">
        <!--相关联的活动end-->
    	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  <div class="modal-dialog modal-sm row" role="document">
		    <div class="modal-content col-xs-10 point col-xs-offset-1">
		         
		    </div>
		  </div>
		</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/upload_img.js"></script>
</body>
</html>