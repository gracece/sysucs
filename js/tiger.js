/** jquery.bgpos.js
 * v. 1.02
 */
(function($) {
    $.extend($.fx.step,{
        backgroundPosition: function(fx) {
            if (fx.state === 0 && typeof fx.end == 'string') {
                var start = $.curCSS(fx.elem,'backgroundPosition');
                start = toArray(start);
                fx.start = [start[0],start[2]];
                var end = toArray(fx.end);
                fx.end = [end[0],end[2]];
                fx.unit = [end[1],end[3]];
            }
            var nowPosX = [];
            nowPosX[0] = ((fx.end[0] - fx.start[0]) * fx.pos) + fx.start[0] + fx.unit[0];
            nowPosX[1] = ((fx.end[1] - fx.start[1]) * fx.pos) + fx.start[1] + fx.unit[1];
            fx.elem.style.backgroundPosition = nowPosX[0]+' '+nowPosX[1];

           function toArray(strg){
               strg = strg.replace(/left|top/g,'0px');
               strg = strg.replace(/right|bottom/g,'100%');
               strg = strg.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2");
               var res = strg.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/);
               return [parseFloat(res[1],10),res[2],parseFloat(res[3],10),res[4]];
           }
        }
    });
})(jQuery);
var isBegin=1;
// 数字转动结束的回调函数，可选
function callback(){
	  console.log("done");
    isBegin = 3;
    $('#stbtn').css("background","url(/img/btn_fresh.png)");
    $('#my_score').show(500);
}

function showTiger(){
	$("#layout").fadeIn();
	if($("#chuang").height()>$(window).height()){
		$("#chuang").fadeIn().css({"top":$(window).scrollTop(),"left":($(window).width()-$("#chuang").width())/2+$(window).scrollLeft()});
	}else{
		$("#chuang").fadeIn().css({"top":($(window).height()-$("#chuang").height())/2+$(window).scrollTop(),"left":($(window).width()-$("#chuang").width())/2+$(window).scrollLeft()});
	}
}
function closeTiger(){
	$("#chuang").fadeOut();
	$("#layout").fadeOut();
        $('#my_score').show();
}
function runWithNum(data){
		var u = -173;
		var rush = 60;
    var res =data;
		var n_sign = rush + (res>=0?0:1);
		res = res>=0?res:-res;
		var n_decade = Math.floor(res/10) + rush;
		var n_dig = res % 10 + rush;
		setTimeout(function(){
			$("#n3").stop(1,1).animate({
				backgroundPositionY: u*n_dig
			},{
				duration: 6000,
				easing: "easeInOutCirc"
			});
		},100);
		setTimeout(function(){
			$("#n2").stop(1,1).animate({
				backgroundPositionY: u*n_decade
			},{
				duration: 8000,
				easing: "easeInOutCirc"
			});
		},200);
		setTimeout(function(){
			$("#n1").stop(1,1).animate({
				backgroundPositionY: u*n_sign
			},{
				duration: 10000,
				easing: "easeInOutCirc",
				complete: function(){
					callback();
				}
			});
		},300);
}

$(document).ready(function(){
  $('#tiger_button').click(function(){
    showTiger();
  });
  $("#close_btn").click(function(){
    closeTiger();
  });
	isBegin = 1;
	$("#stbtn").click(function(){
		if(isBegin == 3){
      window.location.reload();
      return;
    };
    if(isBegin == 2){
      return;
    }
		isBegin = 2;
		var u = -173;
		var rush = 60;
    $.get("ajax/random.php",function(data){
      runWithNum(data);
    });
  });
});
