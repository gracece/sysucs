<?php
require_once('functions.php');
require_once('auth_head.php');
html_header("计科一班--搜索");
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
              <li><a href="setting/dandan.php">辉宇蛋蛋店</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="container" >
<br />

<form class="form-search" >
  <input type="text" name="q" placeholder="搜索..." class="input-medium search-query">
  <button type="submit" class="btn">Search</button>

</form>
<?php
$q =safeGet("q");
$all = safeGet("all");
$num =safeGet("num");
if ($q ==NULL)
{
    echo "请输入查询关键词！";
    exit;
}
?>
<div class="alert alert-info">
下面是关于<i><?php echo $q ?> </i>的搜索结果.
</div>
<div class="row">
<div class="span7">
<?php
if($all ==true)
    $result =db_select("info"," subject='info' order by date desc");
else
    $result =db_select("info","content like '%".$q."%' and subject='info' order by date desc");
if($result ->num_rows ==0)
    echo "无相关通知！";
else
{
    $showNum = $result->num_rows;
    echo "共".$showNum."条相关通知：";
    echo" <table class='table table-hover' > <tbody>";
    if ($num !=NULL)
    {
        if($num < $showNum)
            $showNum =$num;
    }
    for($i =0;$i<$showNum;$i++)
    {
        $row =mysqli_fetch_array($result);
        echo "<tr >
            <td width='530px'><p>".date("m/d H:i",$row['date'])."</p>".nl2br(trim($row['content']))."</td>
            </tr>

            ";
    }
    echo " </tbody>
        </table>";
}

?>
</div>
<div class="span5">
<table class="table table-striped">
<?php 

$result =db_select("resource","name like '%".$q."%' order by date desc");
if($result ->num_rows ==0)
    echo "无相关资源！";
else
{
    echo "共".$result->num_rows."个相关资源";
    for($i =0;$i<$result->num_rows;$i++)
    {
        $row =mysqli_fetch_array($result);
        echo "<tr><td> <a href=\"download.php?subject=".$row['subject']."&file=".$row['date']."\">".$row['name']."</a></td></tr>";
    }
}
?>
</table>
</div>
</div>
</div>
