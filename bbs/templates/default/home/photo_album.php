<?php defined('InCosmos') or exit('Access Invalid!');?>
<!--成长相册-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>少年宫</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/photo_album.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/swiper-3.4.2.min.css" />
<body>
    <div class="photo_album">
        <!--头部-->
    	<div class="reg_top overflow">
    		<button type="button" class="btn oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	         <?php echo $output['info']['activity_title']?>
            </button>
            <span class="col-xs-12">
                <span class="pull-right Upload" id="UpBtn" onclick="Href('<?php echo urlBBS('mine','uploadImg',array('activity_no'=>$output['info']['activity_no'],'activity_periods'=>$output['info']['activity_periods']))?>')">上传图片</span>
            </span>
    	</div>
    	
        <input type="hidden" id="no" value="<?php echo $output['info']['activity_no']?>">
        <input type="hidden" id="periods" value="<?php echo $output['info']['activity_periods']?>">
    </div>
    <div class="ph_mask overflow">
      <div><span class="glyphicon glyphicon-chevron-left ph_out"></span></div>
       <div class="swiper-container">
            <div class="swiper-wrapper ph_img">
                
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/photo_album.js"></script>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/swiper-3.4.2.min.js"></script>
</body>
</html>