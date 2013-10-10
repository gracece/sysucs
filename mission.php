<?php

require("functions.php");
require("auth_head.php");
html_header("计科一班--签到");

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
              <li class="active"><a href="#">签到</a></li>
              <li><a href="setting/dandan.php">辉宇蛋蛋店</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="container">
<br />
<div class="alert alert-info">
<?php
if((date("H") == 23 && date("i")>55) || (date("H") ==0 && date("i") <5))
{
    if(isset($_SESSION['preTime']))
    {

        $ip =get_user_ip();
        $dbc =newDbc();
        if(time()-$_SESSION['preTime'] <mt_rand(3,5))
        {
            $_SESSION['preTime'] = time();
            $ua = $_SERVER['HTTP_USER_AGENT'];
            $visitDate = date('U');
            $query = "INSERT INTO visitors values ('".$visitDate."','M".$ip."','".$ua." ','".$_SESSION['user']."')";
            mysqli_query($dbc,$query);
        }
    }
    $_SESSION['preTime'] = time();
}


$dbc =newDbc();
//mysqli_query($dbc,"LOCK TABLES coin READ");
//mysqli_query($dbc,"LOCK TABLES coin WRITE");
$today = date("Y/m/d");
$user =$_SESSION['user'];
$date_second = strtotime($today);

$query = "SELECT * FROM coin WHERE date >=".$date_second." AND type ='签到' ORDER BY date DESC ";
$checkedUser = mysqli_query($dbc,$query);
$n = $checkedUser->num_rows; 
//今日总人数

$query = "SELECT * FROM coin WHERE date >=".$date_second." AND user ='".$user."' AND type ='签到' ORDER BY date DESC ";
$todayResult =mysqli_query($dbc,$query);
$todaycheck = $todayResult->num_rows;


if($n == 0)
    $num = 15; 
else if($n <2)
    $num =1;
else
    $num =mt_rand(1,8);

if($todaycheck == 0)
{
    $t = safeGet('t');
    if($t == md5(md5(strtotime('today'))."sysucs"))
    {

        $query = "select * from coin where user='".$user."' and type ='签到' order by date desc";
        $result =mysqli_query($dbc,$query);
        $row =mysqli_fetch_array($result);
        $lastcheckday = $row['date'];

        if(date("m/d",$lastcheckday) == date("m/d",strtotime("-1 day")))
        {
            //昨天已经签到，连续签到日期加一
            echo "昨日已经签到，连续签到日期+1。";
            $query ="update user set checkdays = checkdays +1 where name ='".$user."'";
        }
        else
        {
            echo "上次签到：".date("m/d",$lastcheckday).",连续签到日期置为1!";
            $query ="update user set `checkdays` =1 where `name` ='".$user."'";
        }
        mysqli_query($dbc,$query) or die("check day failed ");

        coinChange($user,$num,"签到");
        echo "今日你是第".($n+1)."个签到，已经获得<code>".$num."</code>计科币。";
        //数据库解锁
        //    mysqli_query($dbc,"unlock tables");

        if (date("H") ==7 &&date("i") <40)
        {
            $randomNum =mt_rand(3,5);
            coinChange($user,$randomNum,"早起奖励");
            echo "早起奖励<code>+".$randomNum."</code>!";
        }

        $query ="select * from user where name ='".$user."'";
        $user_info =mysqli_query($dbc,$query);
        $row=mysqli_fetch_array($user_info);
        $days =$row['checkdays'];
        if($days %10 ==0)
        {
            echo "连续".$days."天签到,计科币<code>+15</code>";
            coinChange($user,15,"连续".$days."天签到奖励");
        }
        else
        {
            echo "再连续签到".(10-($days %10))."天即可获取<code>15</code>计科币奖励！";
        }

    }
    else
        echo "请点击首页签到按钮进行签到 ";

}
else
    echo "今日已经签到,查看<a href='setting/rank.php'>计科币排行榜</a>";
?>
</div>
<div class="row">
<div class="span5">
<h3>已经签到<?php echo $n ?>人:</h3>
<table class="table table-bordered">
<tbody>
<?php

$chartNum =array(0,0,0,0,0,0,0,0);
$sum =0;


$checkResult = DB::query("SELECT coin.user,coin.date,coin.num,user.checkdays
    FROM coin,user WHERE user.name=coin.user
    And coin.date >=%s And coin.type ='签到' ORDER BY coin.date DESC",$date_second);
foreach($checkResult as $row)
{
    $t = $row['date'];
    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
    $d = new DateTime( date('Y-m-d H:i:s.'.$micro,$t) );
    echo "<tr><td>".$d->format("H:i:s.u")."</td><td>".$row['user']."</td><td><b> <code>".$row['num']."</code></b></td><td>连续签到".$row['checkdays']."天</td></tr>";
    $number = (int)$row['num'];
    if($number != 15)
    {
        $sum +=$number;
        $chartNum[$number -1] ++;
    }

}
?>
</table>
</div>
<?php 
if($n ==1)
    exit;
?>
<div class="span6">
<h3>今日统计 平均<?php echo round($sum/($n-1),2) ?></h3>
<canvas id="myChart"  width="500" height="400">出门左拐chrome,右拐firefox</canvas>

<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript">
var ctx = $("#myChart").get(0).getContext("2d");
var myNewChart = new Chart(ctx);
var data = {
    labels : ["1","2","3","4","5","6","7","8"],
        datasets : [
{
    fillColor : "rgba(151,187,205,0.5)",
        strokeColor : "rgba(151,187,205,1)",
        data : [ <?php

foreach($chartNum as $out) echo $out.',';

?> ]
}
]
};

var options = {
    scaleOverlay : true,
        scaleOverride : true,
        scaleSteps : 10,
        scaleStepWidth : 1,
        scaleStartValue : 0,
};
new Chart(ctx).Bar(data,options);

</script>

    <h3><?php 
//if($user =='grace')
//    $user='';

echo $user ?>最近统计</h3>
<canvas id="myChart2"  width="500" height="400"></canvas>
    <script type="text/javascript">
    var ctx2 = $("#myChart2").get(0).getContext("2d");
var myNewChart2 = new Chart(ctx2);
<?php
    $query ="select * from coin where type='签到' and user ='".$user."' order by date desc limit 10 ";
$result =mysqli_query($dbc,$query);
$i=0;
while ($row =mysqli_fetch_array($result))
{
    $temp[$i]['date'] = $row['date'];
    $temp[$i]['num'] = $row['num'];
    $i++;
}
$tempCount = count($temp) -1;
?>

var data2 = {
    labels : [ <?php 
for ($i=$tempCount;$i>=0;$i--)
    echo '"'.date("m/d",$temp[$i]['date']).'",'; 
?> ],
    datasets : [
{
    fillColor : "rgba(151,187,205,0.5)",
        strokeColor : "rgba(151,187,205,1)",
        pointStrokeColor : "#bbb",
        data : [ <?php 
for ($i=$tempCount;$i>=0;$i--)
    echo (int)$temp[$i]['num'].','; 
?> ]
}
]
};

var options2 = {
    scaleOverlay : true,
        scaleOverride : true,
        scaleSteps : 15,
        scaleStepWidth : 1,
        scaleStartValue : 0,
};
new Chart(ctx2).Line(data2,options2);

</script>

</div>
</div>
<?php 

echo @$_SERVER['HTTP_REFERER'];


