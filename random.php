<?php
require("functions.php");
require("auth_head.php");
html_header("计科一班--Random");

?>
<div style="padding: 0px 0px 50px; margin: 0px; border-width: 0px; height: 0px; display: block;" id="yass_top_edge_padding"></div>
  <div class="navbar  navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="../">SYSUCS.ORG</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="setting">个人中心</a></li>
              <li><a href="setting/message.php">消息</a></li>
              <li><a href="setting/rank.php">排行榜</a></li>
              <li><a href="mission.php">签到</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="container">
<br />
<div class="alert alert-info">
试试手气,有增有减，看人品。每人每小时可尝试5次。刷新即可。小赌怡情，大赌伤肾啊
</div>
<?php
$user = $_SESSION['user'];
$account = DB::queryFirstRow("SELECT * FROM user WHERE name=%s",$user);
echo "<h3>计科币 <code>".$account['coin']."</code></h3>";
if ($account['coin']<50)
{
    echo "余额小于50,请稍后再来";
}
else
{
    DB::query("SELECT * FROM coin WHERE user=%s and type='试试手气' AND date>%i",$user,strtotime("today")+date("H")*3600);
    $count = DB::count();
    if ($count >= 5)
    {
        echo "本小时段的5次机会已用完，请下一时段再来！如果嫌总是扣钱,请反思人品问题或积极签到上传资源，可稳定增长。╮(╯_╰)╭";
    }
    else
    {
?>
<a class="btn"  id="tiger_button" href="#">试试手气</a>
<script >

$(document).ready(function(){
showTiger();
});
    </script>
        <?
    }
}

?>
<hr/>
<div class="row" id="my_score">
<div class="span5" >
<h3>我的战绩</h3>
<?php
$show = DB::query("SELECT *  FROM coin WHERE user=%s and type='试试手气'
    AND date>%i order by date desc",$user,strtotime("today")+date("H")*3600);
?>
<table class="table">
<?php 
foreach($show as $row)
{
    echo "<tr> <td>".date("H:i:s",$row['date'])." <code><b>".($row['num'])."</b></code> </td> </tr>";
}
?>
</table>

   </div>

<div class="span1"></div>
<div class="span6">

<h3>本时段战绩</h3>
<?php
$show = DB::query("SELECT user,sum(num) as get,count(num) as try_times, max(num)
    as maxx,min(num) as minn FROM (
        SELECT user,CAST(num as SIGNED) as num FROM coin WHERE type='试试手气' 
    AND date>%i  ) as XXX group by user order by get",strtotime("today")+date("H")*3600);
?>
<table class="table table-striped table-hover">
<thead>
<tr>
    <th></th>
    <th>最终</th>
    <th>次数</th>
    <th>最高</th>
    <th>最低</th>
</tr>
</thead>
<?php 
$i = 1;
$allnum = count($show);
foreach($show as $row)
{
    echo "<tr ";
    if($row['user'] == $user)
        echo "class='error'";
    echo"> <td title='".$row['user']."' width=100>".getNickname($row['user'])."</td><td>
        <code><b>".sign($row['get'])."</b></code> ";
    if($i == 1 && $row['get']<0)
        echo "<small class='muted'>人品不太好哎</small>";
    elseif($i == $allnum && $row['get'] >0)
        echo "<small class='muted'>人品爆棚!</small>";

    echo" </td><td><span class='label label-info'>".$row['try_times']."次</span> </td>
        <td><span class='label label-success'>".sign($row['maxx'])."</span></td>
        <td><span class='label label-warning'>".sign($row['minn'])."</span></td>
        </tr>";
    $i++;
}
?>
</table>
</div>
</div>

	<div id="layout"></div>
	<div id="chuang">
		<div id="mask"></div>
		<div id="close_btn"></div>
		<div id="rotator">
			<div id='n1' class="num"></div>
			<div id='n2' class="num"></div>
			<div id='n3' class="num"></div>
		</div>
		<div id="stbtn"></div>
	</div>


<?php
if($user=='grace' or $user=='gavin')
{
    $data['this hour'] = DB::queryFirstField("SELECT sum(num) FROM coin WHERE type='试试手气' 
    AND date>%i ",strtotime("today")+date("H")*3600);
    $data['sum(all)'] = DB::queryFirstField("SELECT sum(num)  FROM coin WHERE type='试试手气'");
    $data['avg(all)'] = DB::queryFirstField("SELECT avg(num)  FROM coin WHERE type='试试手气'");
    $rank = DB::query("SELECT user,sum(num) as num FROM coin WHERE type='试试手气' group by user order by sum(num)");
    echo "<pre>";
    print_r ($data);
    echo "</pre>
    <table class='table table-striped table-hover'>";
    foreach ($rank as $row)
    {
        echo "<tr> <td>";
        echo $row['user'].sign($row['num']);
        echo "</td> </tr>";
    }
    echo " </table>";

}
 ?>
