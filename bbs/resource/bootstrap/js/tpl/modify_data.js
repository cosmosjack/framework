$(function(){
    var data_form = new FormData();
	var modify_data = {
		//上传图片
        Up_img:function(){

           $("#up_img").change(function(){   
                var file = this.files[0];
                if (window.FileReader) {  
                    var rFilter = /^(image\/bmp|image\/gif|image\/jpeg|image\/png|image\/tiff)$/i; //控制格式
                    var iMaxFilesize = 1024*1024*5; //控制大小2M  
                    //var html = $('<h4>提示</h4><h5 class="point_txt"></h5><button class="btn btn-primary down col-xs-10 col-xs-offset-1">确定</button>');
                    //$('.point').html(html);
                    if (!rFilter.test(file.type)) {
                        //alert("文件格式必须为图片");
                        $('.point_txt').html('文件格式必须为图片');
                        $('.modal').modal('show');
                        return;
                    }
                    if (file.size > iMaxFilesize) {
                        // alert("图片大小不能超过2M");
                        $('.point_txt').html('图片大小不能超过5M');
                        $('.modal').modal('show');
                        return;
                    }  
                    var reader = new FileReader();    
                    reader.readAsDataURL(file);    
                    //监听文件读取结束后事件    
                    reader.onloadend = function (e) {
                        // console.log(e.target.result)
                        $('#userImg').attr("src",e.target.result);
                    };    
                    data_form.append('photo',file); 
                } 
            });
        },
        //跳转页面
    	Url_click:function(){
            $('.management').click(function(){
                Href(SITEURL+'/index.php?act=set&op=manageSelect');
            })
    	},
		//完成按钮
        Btn_click:function(){
            $('.mo_btn').click(function(){
                var u_img = $('.avatar>img').attr('src');
                var u_name = $('.u_name').val();//昵称
                var u_phone = $('.u_phone').val();//手机号码
                var u_city = $('.u_city').val();//城市
                var u_cityData = $('.u_cityData').val();//详细地址
                var phone_reg = /(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/;
                if(u_name == ''){
                    $('.point_txt').html('请填写昵称');
                    $('.modal').modal('show');
                }else if(u_phone == ''){
                    $('.point_txt').html('请填写手机号码');
                    $('.modal').modal('show');
                }else if(!phone_reg.test(u_phone)){
                    $('.point_txt').html('手机格式不正确');
                    $('.modal').modal('show');
                }else if(u_city == ''){
                    $('.point_txt').html('请选择城市');
                    $('.modal').modal('show');
                }else{
                    // console.log(u_img,u_name,u_phone,u_city,u_cityData);
                    //$('#address1').val($('#myAddrs').attr('data-key'));
                     //发送请求
                    // var data_form = new FormData(document.getElementById("submitForm"));
                    
                    data_form.append('nick_name',u_name);
                    data_form.append('member_phone',u_phone); 
                    data_form.append('address1',$('#address1').val());
                    data_form.append('address',u_cityData);

                    //此处的请求太慢了
                    //console.log(data_form);return false;
                    $.ajax({
                        type:"POST", 
                        processData:false,
                        contentType:false,     
                        url:SITEURL+"/index.php?act=set&op=editInfo",  //请求路径，接口地址
                        data:data_form, 
                        success: function(data){
                            //重置form,避免重复上传  
                            data_form = new FormData();
                            $('.point_txt').html(data.msg);
                            $('.modal').modal('show');
                            if(data.code == '200')
                                HrefOprev();
                        },
                        error:function(e){
                            //重置form,避免重复上传  
                            data_form = new FormData();
                            $('.point_txt').html('错误');
                            $('.modal').modal('show');
                        }
                    });  
                }
            })
        },
        //选择地址
        City:function(){
            function getAddrsArrayById(id) {
                var results = [];
                if (addr_arr[id] != undefined)
                    addr_arr[id].forEach(function(subArr) {
                        results.push({
                            key: subArr[0],
                            val: subArr[1]
                        });
                    });
                else {
                    return;
                }
                return results;
            }
      
            function getStartIndexByKeyFromStartArr(startArr, key) {
                var result = 0;
                if (startArr != undefined)
                    startArr.forEach(function(obj, index) {
                        if (obj.key == key) {
                            result = index;
                            return false;
                        }
                    });
                return result;
            }

            //bind the click event for 'input' element
            $("#myAddrs").click(function() {
                var PROVINCES = [],
                    startCities = [],
                    startDists = [];
                //Province data，shall never change.
                addr_arr[0].forEach(function(prov) {
                    PROVINCES.push({
                        key: prov[0],
                        val: prov[1]
                    });
                });
                //init other data.
                var $input = $(this),
                    dataKey = $input.attr("data-key"),
                    provKey = 1, //default province 北京
                    cityKey = 36, //default city 北京
                    distKey = 37, //default district 北京东城区
                    distStartIndex = 0, //default 0
                    cityStartIndex = 0, //default 0
                    provStartIndex = 0; //default 0

                if (dataKey != "" && dataKey != undefined) {
                    var sArr = dataKey.split("-");
                    if (sArr.length == 3) {
                        provKey = sArr[0];
                        cityKey = sArr[1];
                        distKey = sArr[2];

                    } else if (sArr.length == 2) { //such as 台湾，香港 and the like.
                        provKey = sArr[0];
                        cityKey = sArr[1];
                    }
                    startCities = getAddrsArrayById(provKey);
                    startDists = getAddrsArrayById(cityKey);
                    provStartIndex = getStartIndexByKeyFromStartArr(PROVINCES, provKey);
                    cityStartIndex = getStartIndexByKeyFromStartArr(startCities, cityKey);
                    distStartIndex = getStartIndexByKeyFromStartArr(startDists, distKey);
                }
                var navArr = [{//3 scrollers, and the title and id will be as follows:
                    title: "省",
                    id: "scs_items_prov"
                }, {
                    title: "市",
                    id: "scs_items_city"
                }, {
                    title: "区",
                    id: "scs_items_dist"
                }];
                SCS.init({
                    navArr: navArr,
                    onOk: function(selectedKey, selectedValue) {
                        $input.val(selectedValue).attr("data-key", selectedKey);
                        $('#address1').val($('#myAddrs').attr('data-key'));
                    }
                });
                var distScroller = new SCS.scrollCascadeSelect({
                    el: "#" + navArr[2].id,
                    dataArr: startDists,
                    startIndex: distStartIndex
                });
                var cityScroller = new SCS.scrollCascadeSelect({
                    el: "#" + navArr[1].id,
                    dataArr: startCities,
                    startIndex: cityStartIndex,
                    onChange: function(selectedItem, selectedIndex) {
                        distScroller.render(getAddrsArrayById(selectedItem.key), 0); //re-render distScroller when cityScroller change
                    }
                });
                var provScroller = new SCS.scrollCascadeSelect({
                    el: "#" + navArr[0].id,
                    dataArr: PROVINCES,
                    startIndex: provStartIndex,
                    onChange: function(selectedItem, selectedIndex) { //re-render both cityScroller and distScroller when provScroller change
                        cityScroller.render(getAddrsArrayById(selectedItem.key), 0);
                        distScroller.render(getAddrsArrayById(cityScroller.getSelectedItem().key), 0);
                    }
                });
            });
        },
		event:function(){
			this.Btn_click();
			this.Up_img();
			this.Url_click();
            this.City();
		}
	};
	modify_data.event();
})