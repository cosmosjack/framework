<!--我的相册-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>少年宫-我的相册</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
</head>
    <link rel="stylesheet" type="text/css" href="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/css/tpl/my_album.css" />
<body>
    <div class="my_album">
    	<!--头部-->
    	<div class="reg_top overflow">
    		<button type="button" class="btn my_oprev">
	          <span class="glyphicon glyphicon-chevron-left"></span>
	          我的相册
	        </button>
	        <span class="col-xs-12">
	        	<span class="pull-right Upload" onclick="Href('<?php echo urlBBS('mine','uploadImg')?>')">上传照片</span>
	        </span>
    	</div>
    	<div class="my_content overflow">
            
    	</div>
    </div>
    <script type="text/javascript" src="<?php echo BBS_RESOURCE_SITE_URL;?>/bootstrap/js/tpl/my_album.js"></script>
</body>
</html>