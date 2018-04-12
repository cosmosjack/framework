function Href(url){
	window.location.href = url;
}
//延时跳转
function HrefDelay(url){
	setInterval(function(){
		console.log(url);
		window.location.href = url;
	},1000);
}
$('.Hide').click(function(){
	$('.modal').modal('hide');
})
$(document).on('click','.aHide',function(){
	$('.modal').modal('hide');
})
//轮播图跳转
$(document).on('click','.banner_url',function(){
	console.log(1)
	Href($(this).attr('href_url'));
})
//返回上一步
$(document).on('click','.oprev',function(){
	history.back(-1);
})
$(function(){
	$('.footer>div').click(function(){
		console.log($(this).attr('href_url'));
		window.location.href = $(this).attr('href_url');
		// var footer = ['../../img/icon0.png','../../img/icon1.png','../../img/icon2.png','../../img/icon3.png'];
		// var footer_active = ['../../img/icon0-1.png','../../img/icon0-2.png','../../img/icon0-3.png','../../img/icon0-4.png'];
  //    	for(let i=0;i<footer.length;i++){
  //    		$('.footer>div:eq('+ i +')').find('img').attr('src',footer[i]);
  //    	}
  //    	$(this).find('img').attr('src',footer_active[$(this).index()]);
	})
})
