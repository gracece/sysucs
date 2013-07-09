<?php
require("../functions.php");
require("../auth_head.php");
html_header("计科一班--排行榜");
?>
<div style="padding: 0px 0px 50px; margin: 0px; border-width: 0px; height: 0px; display: block;" id="yass_top_edge_padding"></div>
  <div class="navbar  navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="../">SYSUCS.ORG</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="./">个人中心</a></li>
              <li><a href="message.php">消息</a></li>
              <li class="active"><a href="#">排行榜</a></li>
              <li><a href="../mission.php">签到</a></li>
              <li><a href="dandan.php">辉宇蛋蛋店</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


<div class="container">
<div class="span12">
<h3>计科币排行榜 <small><?php
$dbc =newDBC();
$query ="select sum(coin) from user order by coin desc";
$result = mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result);
echo "截至".date("m/d H:i") ;
echo "  总资产<code>".$row['sum(coin)']."</code>  ";

?></small></h3>
<div class="alert alert-info">温馨提示,每周日排行第一的同学(周日23:50截止),可凭100个计科币换取鸡蛋一个(何辉宇蛋蛋店赞助==)</div>
<div class="alert alert-danger">同志们没有特殊需求就不要浪费手续费转账啦，看着都心疼。。</div>

<?php
$user =$_SESSION['user'];
$query ="select * from user order by coin desc";
$result = mysqli_query($dbc,$query);
$n = $result->num_rows;
?>
 <table  style="table-layout:fixed;overflow:hidden" class="table table-striped table-bordered">
           <thead>
<tr>
    <td width="16px">#</td>
    <td width="110px">name</td>
    <td width="40px">计科币</td>
    <td width="640px">签名档</td>
</tr>
</thead>
<tbody>
<?php
for($i=0;$i<$n;$i++)
{
    $row =mysqli_fetch_array($result);
    if($row['name'] ==$user)
        echo" <tr class='error'>";
    else
        echo" <tr >";

    echo "
        <td>".($i+1)."</td>
        <td title='".$row['name']."'><a href='message.php?to=".$row['name']."'>";
    if($row['nickname'] !='')
        echo $row['nickname'];
    else 
        echo $row['name'];
   echo "</td>
        <td>".$row['coin']."</td>
        <td>".$row['signature']."</td>
        </tr> ";

        if ($row['rank'] !=($i+1))
        {
            $update_query ="update user set rank='".($i+1)."' where name='".$row['name']."'";
            mysqli_query($dbc,$update_query) or die("update rank failed!");
        }
}


?>
</tbody>
</table>
<div class="alert alert-info">垫底的同学要加把劲了。。。楼上的，说的就是你！</div>
<br />
</div>

</div>

