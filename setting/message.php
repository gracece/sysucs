<?php
require_once('../functions.php');
require_once('../auth_head.php');
html_header("计科一班--消息");
$to =safeGet('to');
?>
<div style="padding: 0px 0px 50px; margin: 0px; border-width: 0px; height: 0px; display: block;" id="yass_top_edge_padding"></div>
  <div class="navbar  navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="../">SYSUCS.ORG</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php">个人中心</a></li>
              <li class="active"><a href="message.php">消息</a></li>
              <li><a href="rank.php">排行榜</a></li>
              <li><a href="../mission.php">签到</a></li>
              <li><a href="dandan.php">辉宇蛋蛋店</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


<div class="container">
<form id='send' >
<p>用户名</p>
<input  name="toUser" type="text" value=<?php echo $to ?> />
<p>内容</p>
<textarea  name="content" id="con" rows="3" style="width:70%"></textarea>
<br />

<a href="#" class='btn btn-primary' onclick ="sendform()">发送</a>
<span class="muted"><small>Ctrl+Enter 也可以发送</small></span>
</form>
<script type="text/javascript">
var pre="";
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
$dbc =newDbc();
$user =$_SESSION['user'];
if($to !=  NULL)
{
    $result =db_select("user","name='".$to."'");
    if($to!='system' && $to !='@提醒' &&$result->num_rows ==0)
    {
        echo $to."不存在！";
        exit;
    }
    $talk =db_select("message","(`user`='".$user."' and `fromuser` ='".$to."') or (`user`='".$to."' and `fromuser`='".$user."') order by time desc");
    $num = $talk->num_rows;
    echo "<h3>总共".$num."条信息</h3>";
    echo " <table class='table'> <tbody> ";
    for ($i=0;$i<$num;$i++)
    {
        $row=mysqli_fetch_array($talk);
        if($row['fromuser'] ==$user)
            echo "<tr class='success'>";
        else
            echo "<tr class='info'>";

        echo "<td width='20%'><big>".$row['fromuser']."</big>
            <small>(".date("m/d H:i",$row['time']).")</small>
            </td><td>".nl2br($row['content'])."</td>
            </tr>";
    }

echo "</tbody> </table> ";
$query ="UPDATE `message` SET `read` = '1' WHERE `user` = '".$user."' and `fromuser`='".$to."'";
mysqli_query($dbc,$query) or die ("read failed!");


}
else
{

    //数据库没设计好就只能这样暴力sql！
    $query ="
        select name,sum(num),t as time,content from (
            (select `user` as name,count(*)  as num,time as t,content from `message` where `fromuser`='".$user."' group by name order by t desc ) 
            union 
            (SELECT `fromuser` as name ,count(*) as num ,time as t,content from `message`    where `user`='".$user."' group by name order by t desc ) 
        )as temp group by name order by time desc
";
$result = mysqli_query($dbc,$query);
    $num =$result->num_rows;

    echo "<h3>总共".$num."个会话";
    echo " <small class='muted'>时间排序有点问题，将就着看吧</small> ";
    echo "<a class='btn btn-large pull-right' id='all' href='#' onclick=\"readMessage('all')\">标记所有</a></h3>";
    echo "
        <table  id='mytable' class='table table-hover tablesorter '>
        <thead>
        <tr>
            <td>time</td>
            <td>user</td>
            <td>num</td>
            <td>content</td>
        </tr>
        
        </thead>
        <tbody>
        ";

    for($i=0;$i<$num;$i++)
    {
        $row=mysqli_fetch_array($result);
        $talk =db_select("message","(`user`='".$user."' and `fromuser` ='".$row['name']."') or (`user`='".$row['name']."' and `fromuser`='".$user."') order by time desc");
        $r=mysqli_fetch_array($talk);
        echo "<tr><td>".date("m/d H:i", $r['time'])."</td><td>";
        echo "<a href='?to=".$row['name']."'>".$row['name']."</a></td><td>".$row['sum(num)']."</td><td>";
         echo $r['content'];
        //如果直接用子查询得到的content，会出问题，输出的是对方发过来的最新信息。无奈再查一次
    //   echo $row['content'] ;
        echo  "</td> <td>";
        $read = db_select("message","`user` ='".$user."' and `fromuser`='".$row['name']."' and `read` =0");
        $numOfNoneRead = $read->num_rows;
        if($numOfNoneRead >0)
            echo "<a href='?to=".$row['name']."'>".$numOfNoneRead."条未读消息</a>";
        
        "</td></tr>";
    }

    echo " </tbody> </table> ";
?>
<script type="text/javascript" src="jquery.tablesorter.js"></script>
    <script type="text/javascript">
    $(document).ready(function() 
        { 
        $("#mytable").tablesorter(); 
    } 
);  
</script>
<?php

}
?>
</div>

