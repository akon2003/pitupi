
/**
 * 理财计算器代码,创建一个理财计算器窗口
 */
licaiCalWindow = function(rate,time,max) {
	var rate		= rate? rate : 10;
	var time		= time? time : 12;
	var max			= max? max : 10000;
	var val			= max&max<10000? max : max;
	var container	= null;
	var closed		= true;
	var self		= this;
	this.item		= null;
	this.creatable	= true;

	this.show = function(rate,time,remain,event) {
		if (container == null) { create(); }

		var pos = getMousePos(event);
		container.find("input#LOANRATE").val(rate);
		container.find("input#LOANTERM").val(time);
		container.css({"left":(pos.x+20)+"px","top":(pos.y-160)+"px"});
		container.show();
		bind_event();
		closed = false;	
		container.find(".submitBtn").trigger("click");
	}

	this.hide = function() {
		close();
		$(container).hide();
	}

	function create() {
		var txt = "";
		txt += "<div class='calc_container'>";
		txt += "<div class='header' title='双击此处可关闭'>";
		txt += "<div class='title'>理财计算器</div>";
		txt += "<div class='close'>关闭</div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>投标金额：</div>";
		txt += "<div class='inp'><input type='text' id='BUSINESSSUM' maxlength='12' value='10000' /><div class='mydiv'>元</div></div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>年化收益：</div>";
		txt += "<div class='inp'><input type='text' id='LOANRATE' maxlength='5' /><div class='mydiv'>%</div></div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>投资期限：</div>";
		txt += "<div class='inp'><input type='text' id='LOANTERM' maxlength='3' /><div class='mydiv' id='term_txt'>月</div></div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>期限类型：</div>";
		txt += "<div class='int'><input type='radio' name='type' value='1' checked id='tpmonth' /><label for='tpmonth'>月</label><input type='radio' name='type' value='2' style='margin-left:36px;' id='tpday' /><label for='tpday'>天</label></div>";
		txt += "</div>";
		txt += "<div class='item'>";
		txt += "<div class='mr2'><b>*</b>本息合计：</div>";
		txt += "<div class='int'><div class='total'>￥<span class='num'></span></div></div>";
		txt += "</div>";
		txt += "<div class='submitBtn'>立即计算收益</div>";
		txt += "</div>";

		container = jQuery(txt);
		$(document.body).append(container);
		set_style();
		jqDnR_support();
		container.hide();
	}

	function close() {
		//unbind_event();
	}

	function set_style() {
		$(container).css({'width':'420px','height':'506px','background':'white','position':'absolute','z-index':'100','top':'50%','box-shadow':'rgb(40, 40, 40) 0px 0px 6px','display':'none','border':'1px solid #DDDDDD'});
		$(container).find(".header").css({'background':'#CA8B24','height':'40px','font-size':'16px','line-height':'40px','color':'white','cursor':'move','margin-bottom':'40px'});
		$(container).find(".header .title").css({'float':'left','margin-left':'8px'});
		$(container).find(".header .close").css({'float':'right','margin-right':'8px','cursor':'pointer'});
		$(container).find(".dl-comm1").css({'height':'40px'});
		$(container).find(".item").css({'height':'40px','margin-bottom':'20px'});
		$(container).find(".item > div").css({'height':'40px','line-height':'40px','float':'left'});
		$(container).find(".item .mr2").css({'float':'left','width':'137px','text-align':'right'});
		$(container).find(".item .mr2 b").css({'margin-right':'2px','color':'#CA8B24'});
		$(container).find(".item .inp").css({'width':'208px','border':'1px solid #E1DDD8'});
		$(container).find(".item .inp input").css({'height':'38px','border':'0','line-height':'38px','font-size':'16px','width':'160px'});
		$(container).find(".item .inp .mydiv").css({'float':'right','width':'37px','height':'100%','border-left':'1px solid #E1DDD8','background':'#F8F5F5','text-align':'center'});
		$(container).find(".item .int").css({'float':'left','width':'208px'});
		$(container).find(".item .int input").css({'display':'block','float':'left','width':'12px','margin-top':'15px','margin-right':'3px'});
		$(container).find(".item .int label").css({'display':'block','float':'left','height':'100%'});
		$(container).find(".item .int .total").css({'font-size':'18px','color':'#F5A811'});
		$(container).find(".submitBtn").css({'width':'200px','height':'40px','line-height':'40px','text-align':'center','font-size':'20px','color':'white','cursor':'pointer','margin-left':'105px','background':'#EFB14D','margin-top':'10px'});
	}

	function bind_event() {
		// 投资金额输入
		container.find("input#BUSINESSSUM").each(function() {
			$(this).bind("keypress", function(e) {
				// 回车事件
				var ev = window.event || e;
				if (ev.keyCode > 47 && ev.keyCode < 58) {
					container.find(".submitBtn").trigger("click");
					return true;
				} else {
					return false;
				}
			}).bind("keyup", function(e) {
				container.find(".submitBtn").trigger("click");
			}).bind("keydown", function(e) {
				var ev = window.event || e;
				if (ev.keyCode == 13) {
					container.find(".submitBtn").trigger("click");
				}
			}).bind("blur", function() {
				var val = parseInt($(this).val());
				// 判断是否为数字
				if (isNaN(val)) {
					$(this).val("请输入数字!");
					return false;
				}
				if ($(this).val() == 0) {
					$(this).val("10000");
					container.find(".submitBtn").trigger("click");
				}				
			});
		});

		// 年化收益
		$(container).find("input#LOANRATE").each(function() {
			$(this).bind("keypress", function(e) {
				// 回车事件
				var ev = window.event || e;
				if (ev.keyCode == 46 || (ev.keyCode > 47 && ev.keyCode < 58)) {
					container.find(".submitBtn").trigger("click");
					return true;
				} else {
					return false;
				}
			}).bind("keyup", function(e) {
				container.find(".submitBtn").trigger("click");
			}).bind("keydown", function(e) {
				var ev = window.event || e;
				if (ev.keyCode == 13) {
					container.find(".submitBtn").trigger("click");
				}
			}).bind("blur", function() {
				var val = $(this).val();
				// 判断是否为数字
				if (isNaN(val)) {
					$(this).val("请输入年化收益!");
				}
			});
		});
		
		// 投资期限
		$(container).find("input#LOANTERM").each(function() {
			$(this).bind("keypress", function(e) {
				// 回车事件
				var ev = window.event || e;
				if (ev.keyCode > 47 && ev.keyCode < 58) {
					container.find(".submitBtn").trigger("click");
					return true;
				} else {
					return false;
				}
			}).bind("keyup", function(e) {
				container.find(".submitBtn").trigger("click");
			}).bind("keydown", function(e) {
				var ev = window.event || e;
				if (ev.keyCode == 13) {
					container.find(".submitBtn").trigger("click");
				}
			}).bind("blur", function() {
				var val = $(this).val();
				// 判断是否为数字
				if (isNaN(val) || val == 0) {
					$(this).val("请输入投资期限!");
				}
			});
		});

		// 期限类型设置
		$(container).find("#tpmonth").bind("click", function() {
			$(container).find("#term_txt").html("月");
			container.find(".submitBtn").trigger("click");
		});
		$(container).find("#tpday").bind("click", function() {
			$(container).find("#term_txt").html("天");
			container.find(".submitBtn").trigger("click");
		});

		// 计算收益
		container.find(".submitBtn").bind("click", function() {
			// 输入金额
			var input = container.find("#BUSINESSSUM").val();
			// 年化收益
			var rate = container.find("#LOANRATE").val();
			// 投资期限
			var term = container.find("#LOANTERM").val();
			// 期限类型

			var type = container.find("#tpmonth").attr("checked") == "checked"? "month" : "day";
			
			var res = input * rate * (type=="month"? (term/12):(term/360)) / 100;
			var total = parseFloat(input) + parseFloat(res);
			total = total.toFixed(2);
			container.find(".total .num").html(total);
		});

		// 关闭计算器
		container.bind("dblclick", function() {
			container.hide();
		}).find(".close").bind("click", function() {
			container.hide();
		});
	}

	function unbind_event() {
		//
	}

	function jqDnR_support() {
		if ($.jqDnR) { $('.calc_container').jqDrag(".header"); }
	}

	function getMousePos(event) { 
		var e = event || window.event; 
		var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft; 
		var scrollY = document.documentElement.scrollTop || document.body.scrollTop; 
		var x = e.pageX || e.clientX + scrollX; 
		var y = e.pageY || e.clientY + scrollY; 
		return { 'x': x, 'y': y }; 
    }
}