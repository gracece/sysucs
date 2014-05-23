<?php
require_once("functions.php");
require_once("auth_head.php");
$ip= get_user_ip();

$dbc =newDbc();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>计科一班-HOME</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="sysucs.org">
    <meta name="author" content="gavin & grace">
    <!-- Le styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/scrolltop.js?v=6.2"></script>
<link media="all" rel="stylesheet" href="css/index_new.css?v=6" type="text/css" />
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<script type="text/javascript" src="js/ajax.js"></script>

<!--[if lte IE 7]> 
<style type="text/css"> .icon-chevron-right { display:none; } </style>
<![endif]--> 
  <!--[if lte IE 6]>
  <link rel="stylesheet" type="text/css" href="css/bootstrap-ie6.css">
  <link rel="stylesheet" type="text/css" href="css/ie.css?v=620">
  <![endif]-->

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body  style="background:url('img/dianbg.jpg')">

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="?">SYSUCS.ORG</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
<?php
$user =$_SESSION['user'];
echo '<a href="setting" class="navbar-link"><i style="margin-top:3px" class="icon-user icon-white"></i>'.$user.'</a>';
echo" <a href='?userout=1' class='navbar-link' ><i style='margin-top:3px' class='icon-off icon-white'></i>登出</a>  ";
?>
            </p>
            <ul class="nav">
              <li class="active"><a href="?">Home</a></li>
              <li><a href="setting">个人中心</a></li>
              <li><a href="setting/message.php">消息</a></li>
              <li><a href="setting/rank.php">排行榜</a></li>
         <?php if ($_SESSION['addInfo'] == 1) echo ' <li><a href="admin">后台管理</a></li>'; ?>
            </ul>
<form action="search.php"  class="navbar-search">
<input  name="q" type="text" placeholder="搜索通知或资源..." class="search-query" />
</form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div id="fileinfo" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 评论在这里
</div>

    <div class="container-fluid">
    <div class="visible-phone"> 
    <?php showMissionBtn($_SESSION['user']); ?>
</div>

      <div class="row-fluid">
        <div class="span1" style="width:3%;min-height:3px"></div>
        <div class="span2" >
          <div class=" sidebar-nav";>
            <ul class="nav nav-tabs nav-stacked">
              <li class="nav-li" style=" border-top-left-radius: 5px; border-top-right-radius: 5px;" id="index"> <a href="?"><i class="icon-home"></i>首页</a> </li>

<li class="nav-li" id="major_1"> <i class="icon-chevron-right icon-margintop"></i> <a href="#"  >计算机科学与技术</a></li>

<div class="sub-dev" id="sub_1" > 

<ul class="nav nav-pills nav-stacked">
             <?php
$sub_index=1;
$query = "select * from setting where `show`=1 AND major&4=4  order by CONVERT(name USING GBK)";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_array($result))
{
?>
  <li class="nav-li" id="<?php echo $row['subject'];?>" name= "<?php echo $row['subject'];?>" >
<i class="icon-chevron-right"></i>
<a href="#detail"  onclick='loadXML("ajax/ls-inner.php","<?php echo $row['subject'] ?>")'><?php echo $row['name'] ?></a></li>
    <?php } ?>

    </ul>
    </div>




<li class="nav-li" id="major_2"> <i class="icon-chevron-right icon-margintop"></i> <a href="#"  >网络工程</a></li>


<div class="sub-dev" id="sub_2"> 
<ul class="nav nav-pills nav-stacked">
             <?php
$query = "select * from setting where `show`=1 AND major&2=2  order by CONVERT(name USING GBK)";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_array($result))
{
?>
  <li class="nav-li" id="<?php echo $row['subject'];?>" name= "<?php echo $row['subject'];?>" >
<i class="icon-chevron-right"></i>
<a href="#detail"  onclick='loadXML("ajax/ls-inner.php","<?php echo $row['subject'] ?>")'><?php echo $row['name'] ?></a></li>
    <?php } ?>

    </ul>

</div>


<li class="nav-li" id="major_3"> <i class="icon-chevron-right icon-margintop"></i> <a href="#"  >信息安全</a></li>

<div class="sub-dev" id="sub_3" > 
<ul class="nav nav-pills nav-stacked">
             <?php
$query = "select * from setting where `show`=1 AND major&1=1 order by CONVERT(name USING GBK)";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_array($result))
{
?>
  <li class="nav-li" id="<?php echo $row['subject'];?>" name= "<?php echo $row['subject'];?>" >
<i class="icon-chevron-right"></i>
<a href="#detail"  onclick='loadXML("ajax/ls-inner.php","<?php echo $row['subject'] ?>")'><?php echo $row['name'] ?></a></li>
    <?php } ?>

</ul>
</div>

<li class="nav-li" name="history">
<i class="icon-chevron-right icon-margintop"></i>
<a href="#detail" onclick="loadXML('ajax/subject.php','history')">历史科目</a></li>

              <?php
$query = "select * from setting where `show`=1 AND major=8 order by CONVERT(name USING GBK)";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_array($result))
{
?>
  <li class="nav-li" id="<?php echo $row['subject'];?>" name= "<?php echo $row['subject'];?>" >
<i class="icon-chevron-right icon-margintop"></i>
<a href="#detail"  onclick='loadXML("ajax/ls-inner.php","<?php echo $row['subject'] ?>")'><?php echo $row['name'] ?></a></li>
    <?php } ?>

              <li class="nav-li" style=" border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; " id="upload"> <i class="icon-chevron-right icon-margintop"></i><a href="#"  onclick='loadXML("ajax/ls-inner.php","upload")'>我要上传</a> </li>
            </ul>
          </div><!--/.sidebar-nav -->
        </div><!--/span-->
<a name="detail" class="target-fix"></a>
        <div class="span9" id="more" >
            <div class="row" style="background:white;box-shadow:3px 3px #ddd;margin-left:0.1%;border-radius:5px;border:1px solid #d3d3d3;">
               <div class="span9" style="border-right:1px solid #d3d3d3">
                <div style="margin:20px;"> 

<?php 

$query ="SELECT *
    FROM `message`
    WHERE `user` = '".$user."' AND `read` = '0' order by time desc";
$result = mysqli_query($dbc,$query);
$num = $result->num_rows;
if($num >0)
{
    $row =mysqli_fetch_array($result);
    echo "
        <div class=\"alert \">
        <a class=\"close\" onclick=\"readMessage('".$row['time']."')\" data-dismiss=\"alert\">×</a>
        <p>  您有$num 条未读消息, <a href='setting/message.php'>点击查看所有</a> </p>
        ";
    echo date("m/d H:i",$row['time'])." ".$row['content']."";
    if ($row['fromuser'] !='system' && $row['fromuser'] !='@提醒' )
        echo " <a href='setting/message.php?to=".$row['fromuser']."'>进入对话</a> ";

    echo" </div> ";
}

?>
<?php
$newInfo = db_select("info"," 1 order by date desc limit 1");
$row =mysqli_fetch_array($newInfo);
if (time() -$row['date'] < 24*60*60)
{
    echo '<div class="alert alert-info" id="info-alert" style="font-size:15px;color:black">
        <a class="close" data-dismiss="alert">×</a>';
    if ($row['type'] == "资源更新")
    {
        $id = $row['content'];
        $resource = getResource($id);
        echo getNameBySubject($resource['subject'])." 新资源！by ".$resource['user'] ;
        showFileinfo($id);
    }
    else
        echo nl2br($row['content']);

echo " </div>";
}

?>
<div class="banner hidden-phone">
    <ul>

    <?php
$query = "select * from banner";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_array($result))
{
    echo ' 
        <li style="background-image: url('.$row['imgUrl'].')">
         <div class="inner">
         <h2> '.$row['title'].' </h2>
         <p>'.$row['content'].'</p>
         </div>
        </li>';


}
?>
           </ul>
</div><!-- end .banner -->

                    <h3>班级通知</h3>
                    <?php show5info(); ?>

                </div>

               </div> <!-- end .span9 __-->
               <div class="span3 hidden-phone" style="margin-left:0px;width:25.5%">
                  <div style="margin:16px">
<?php
$query ="select coin,rank from user where name ='$user'";
$result =mysqli_query($dbc,$query);
$row = mysqli_fetch_array($result);
echo "<div><h3>计科币:<code style='font-size:large'>".$row[0]."</code>  <small>排名".$row[1]."</small></h3></div>";

//记录访问信息
$today = date("Y/m/d");
$date_second = strtotime($today);
$query = "SELECT * FROM visitors WHERE date >=".$date_second." AND user ='".$_SESSION['user']."' ORDER BY date DESC ";
$todayResult =mysqli_query($dbc,$query);
$todayVisit = $todayResult->num_rows;
$row = mysqli_fetch_array($todayResult);
$lastVisitTime = $row['date'];
$ua = $_SERVER['HTTP_USER_AGENT'];
$visitDate = date('U');
$query = "INSERT INTO visitors values ('".$visitDate."','".$ip."','".$ua." ','".$_SESSION['user']."')";
if($visitDate - $lastVisitTime >120) //和上次访问相差2分钟才写入数据库
{
    mysqli_query($dbc,$query);
    $todayVisit ++;
}

//显示签到按钮
showMissionBtn($_SESSION['user']);
//time ,23点后显示
if (date("H") ==23)
{
?>
<div>
<p style='align:center;margin:9px;'>
                      <code id='tH'><?php echo date('H');?></code> :
                      <code id='ti'><?php echo date("i"); ?></code> :
                      <code id='ts'><?php
if(date("i") == 59)
    echo "hehe不告诉你";
else 
    echo date('s');
?></code></p>
    <script type='text/javascript'>
    setTimeout(setTime,600);
    </script>
</div>

<?php
}
?>
<hr />
 <h3><a href='water'>水水水</a></h3>
                <div  style="word-break:break-all; word-wrap:break-word">
    <table class='table  table-striped '>
    <tbody>
<?php
//$query = "SELECT * FROM water ORDER BY time DESC;";
$query = "select water.content,water.time,user.nickname from water,user where user.name =water.user order by water.time desc";
$result =mysqli_query($dbc,$query);
$num_results = $result->num_rows;
$total_results = $num_results;
//只显示最近3条
if($num_results >3)  $num_results =3;
$i = 0;
while($i<$num_results)
{
    $row = mysqli_fetch_array($result);
    echo "<tr><td>";
    echo "<big>".$row['nickname']."</big> <small>".date("m/d H:i",$row['time'])."</small>";
    $len =mb_strlen($row['content'],"UTF-8");
    if ($len > 26)
        echo "<p> ".mb_substr($row['content'],0,26,"UTF-8")."……</p>";
    else
        echo "<p> ".$row['content']."</p>";

    echo "</td></tr>";
    $i++;
}
?> 
</tbody></table>
</div>

                <h3>最新资源</h3>
                <div  style="word-break:break-all; word-wrap:break-word">
    <table class='table table-hover table-striped '>
    <tbody>
<?php
$query = "SELECT * FROM info where type='资源更新' ORDER BY date DESC;";
$result =mysqli_query($dbc,$query);
$num_results = $result->num_rows;
$total_results = $num_results;
//只显示最近五条
if($num_results >5)  $num_results =5;
$i = 0;
while($i<$num_results)
{
    $row = mysqli_fetch_array($result);
    $id = $row['content'];
    $resource = getResource($id);
    $name =  getNameBySubject($resource['subject']);
    echo "<tr><td>";
    echo $name."<small>".date("m/d H:i",$row['date'])."</small><p>";
    showFileinfo($id);
    echo "</p></td></tr>";
    $i++;
}
?> 
</tbody></table>
</div>
            <h3>最新评论</h3>
                <div  style="word-break:break-all; word-wrap:break-word">
    <table class='table table-hover '>
    <tbody>
<?php
$query = "SELECT comment.subject,comment.file,comment.time,comment.content,user.nickname FROM comment,user where comment.user=user.name  ORDER BY comment.time DESC;";
$result =mysqli_query($dbc,$query);
$num_results = $result->num_rows;
$total_results = $num_results;
//只显示最近五条
if($num_results >5)  $num_results =5;
$i = 0;
while($i<$num_results)
{
    $row = mysqli_fetch_array($result);
    $subject =$row['subject'];
    $fileName = $row['file'];
    echo "<tr><td><p>
        <a href='#fileinfo' onclick=\"loadComment('fileinfo.php?subject=".$subject."&fileName=".urlencode($fileName)."')\" role='button' data-toggle='modal'>
        " .$fileName.  " </a></p>" ;
    echo "<big>".$row['nickname']."</big> <small>".date("m/d H:i",$row['time']).
        "</small><br />".$row['content']."</td></tr>";
    $i++;
}
?> 
</tbody></table>
</div>


                  </div>
               </div>
            </div>
        </div><!--/span-->

      </div><!--/row-->


      <hr>
      <footer>
<p class="text-center">
<strong>友情链接：</strong>
  <a href="http://weibo.com/sysucs2011" target="_blank">@中大11级计科一班</a>
  &nbsp<a href="http://dwz.cn/cs-tb" target="_blank">中大计科一班吧</a>
</p>

        <p class="text-center muted">Copyright &copy; SYSUCS.ORG 2012-2013</p>
      </footer>

    </div><!--/.fluid-container-->

<div id="gotopbtn" title="回到顶部" style="display:none;">
  <img src="../img/gototop.png">
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/menu.js"></script>
    <script type="text/javascript" src="js/unslider.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/keyEvents.js"></script>
    <script type="text/javascript" src="js/jquery.pin.js"></script>
<script type="text/javascript">
$(".sidebar-nav").pin({ minWidth: 1000});

$('.banner').unslider({
    arrows: false,
        fluid: true,
        key:false,
        dots: true
});

goTopEx();


</script>

  <!--[if lte IE 6]>
  <script type="text/javascript" src="js/bootstrap-ie.js"></script>
  <![endif]-->
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F0a37f369f66ef3c1841dcc3320ec316a' type='text/javascript'%3E%3C/script%3E"));
</script>

  </body>
</html>
