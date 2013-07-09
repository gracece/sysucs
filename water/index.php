<?php
require_once('../functions.php');
require_once('../auth_head.php');
html_header("计科一班--水水水");
$user =$_SESSION['user'];
$dbc =newDbc();
$query ="UPDATE `message` SET `read` = '1' WHERE `user` = '".$user."'  and `fromuser`='@提醒' ";
mysqli_query($dbc,$query) or die ("read failed!");
?>
<div style="padding: 0px 0px 50px; margin: 0px; border-width: 0px; height: 0px; display: block;" id="yass_top_edge_padding"></div>
  <div class="navbar  navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="../">SYSUCS.ORG</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="../setting">个人中心</a></li>
              <li><a href="../setting/message.php">消息</a></li>
              <li><a href="../setting/rank.php">排行榜</a></li>
              <li><a href="../mission.php">签到</a></li>
              <li><a href="../setting/dandan.php">辉宇蛋蛋店</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


<div class="container">
<h3>说点什么吧:-)</h3>
<form id='send' >
<textarea  name="content" onkeyup="ajax_remind();" id="con" rows="3" style="width:70%"></textarea>
<p style="width:71.5%" id="show"></p>
<a href="#" class='btn btn-primary' onclick ="sendform()">发布</a>
<span class="muted"><small>Ctrl+Enter 也可以发送</small></span>

</form>
<script type="text/javascript">
var pre="";
function reply(name)
{
    var str = $("#con").val();
    var str =str.concat('@'+name);
    $("#con").focus();
    $("#con").val(str+' ');

}


function ajax_remind()
{
    var str = $("#con").val();
    var lastchar=str.substr(str.length-1);
    if(lastchar =='@')
        return false;
    var re=/@\w{0,}[\u4e00-\u9fa5]{0,}$/;
    var username =str.match(re);
    if(username !=null)
    {
        var at_name =username[0].substr(1);
        $.post("../ajax/at_show.php",{at_name:at_name},function(data){
            $("#show").html(data);
        });
    }

}

function set_remind(name)
{
    var str = $("#con").val();
    var pos =str.lastIndexOf('@');
    var str =str.substr(0,pos+1);
    var str =str.concat(name);

    $("#con").focus();
    $("#con").val(str+' ');
    $("#show").html('');
    
}
function sendform()
{
    var now = $("#con").val();
    if (now =="")
    {
        alert("空消息吗。。。");
    }
    else if(now ==pre)
    {
        alert("跟刚才那条一样的哎");
    }
    else
    {
        pre =now;
    $.post("sendMessage.php", $("#send").serialize(), function(data) {
        $("#change").html(data);
        $("#con").val("");
        $("#con").focus();
        
     }); 
    }
}

$('#con').keydown(function (e) {
      if (e.ctrlKey && e.keyCode == 13) {
          sendform();
      }
    });

</script>

<div id="change">
<?php
require_once('show.php');
?>
</div>

