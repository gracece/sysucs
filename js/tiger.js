(function($) {
    if(!document.defaultView || !document.defaultView.getComputedStyle){
        var oldcss = jQuery.css;
        jQuery.css = function(elem, name, force){
            if(name === 'background-position'){
                name = 'backgroundPosition';
            }
            if(name !== 'backgroundPosition' || !elem.currentStyle || elem.currentStyle[ name ]){
                return oldcss.apply(this, arguments);
            }
            var style = elem.style;
            if ( !force && style && style[ name ] ){
                return style[ name ];
            }
            return oldcss(elem, 'backgroundPositionX', force) +' '+ oldcss(elem, 'backgroundPositionY', force);
        };
    }

    var oldAnim = $.fn.animate;
    $.fn.animate = function(prop){
        if('background-position' in prop){
            prop.backgroundPosition = prop['background-position'];
            delete prop['background-position'];
        }
        if('backgroundPosition' in prop){
            prop.backgroundPosition = '('+ prop.backgroundPosition + ')';
        }
        return oldAnim.apply(this, arguments);
    };

    function toArray(strg){
        strg = strg.replace(/left|top/g,'0px');
        strg = strg.replace(/right|bottom/g,'100%');
        strg = strg.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2");
        var res = strg.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/);
        return [parseFloat(res[1],10),res[2],parseFloat(res[3],10),res[4]];
    }

    $.fx.step.backgroundPosition = function(fx) {
        if (!fx.bgPosReady) {
            var start = $.css(fx.elem,'backgroundPosition');

            if(!start){//FF2 no inline-style fallback
                start = '0px 0px';
            }

            start = toArray(start);

            fx.start = [start[0],start[2]];

            var end = toArray(fx.end);
            fx.end = [end[0],end[2]];

            fx.unit = [end[1],end[3]];
            fx.bgPosReady = true;
        }

        var nowPosX = [];
        nowPosX[0] = ((fx.end[0] - fx.start[0]) * fx.pos) + fx.start[0] + fx.unit[0];
        nowPosX[1] = ((fx.end[1] - fx.start[1]) * fx.pos) + fx.start[1] + fx.unit[1];
        fx.elem.style.backgroundPosition = nowPosX[0]+' '+nowPosX[1];
    };
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
				backgroundPosition: "0px "+ u*n_dig+"px"
			},{
				duration: 6000,
				easing: "easeInOutCirc"
			});
		},100);
		setTimeout(function(){
			$("#n2").stop(1,1).animate({
				backgroundPosition: "0px "+u*n_decade+"px"
			},{
				duration: 8000,
				easing: "easeInOutCirc"
			});
		},200);
		setTimeout(function(){
			$("#n1").stop(1,1).animate({
				backgroundPosition: "0px "+u*n_sign+"px"
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

  $("#layout").click(function(){
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
    var url;
    if($('#twice').is(":checked"))
      {
      if($('#twice_more').is(":checked"))
        url = "ajax/random.php?twice=2";
      else
        url = "ajax/random.php?twice=1";
      }
      else
        {
        url = "ajax/random.php";
        }
    $.get(url,function(data){
      runWithNum(data);
    });
  });
});
