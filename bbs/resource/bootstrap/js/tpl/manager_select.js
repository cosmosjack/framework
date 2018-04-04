$(function(){
	var manager_select = {
		//说明弹框
		Explain:function(){
			$('.explain').click(function(){
                var e_html = $('<div class="col-xs-12 explain_txt text-left"><p class="col-xs-12">1.为什么要儿童证件及身高体重信息？</p><span class="col-xs-12">答：一为儿童购买旅游保险；二为儿童选择合适尺码的衣服。</span><p class="col-xs-12">2.为什么要监护人的证件信息？</p><span class="col-xs-12">答：因为要签订电子旅游合同，儿童是未成年人，必须由监护人签订，需要签订人(即监护人)的有效证件号码。</span><button class="aHide">确定</button></div>');
                $('.point').children().remove();
                $('.point').append(e_html);
				$('.modal').modal('show');
			})
		},
		//页面跳转
		Url_click:function(){
			$(document).on('click','.manager>div',function(){
				Href($(this).attr('href_url'));
			})
		},
		event:function(){
			this.Explain();
			this.Url_click();
		}
	};
	manager_select.event();
})