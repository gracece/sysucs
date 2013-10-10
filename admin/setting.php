<?php
require_once('auth_admin.php');
require_once('../functions.php');
require_once('../header.html');

if($_SESSION['admin'] !=1)
{
  header("Location:index.php");
  exit;
}

?>
<div style="padding: 0px 0px 50px; margin: 0px; border-width: 0px; height: 0px; display: block;" id="yass_top_edge_padding"></div>
  <div class="navbar  navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="../">SYSUCS.ORG</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
<li> <a href="./">Home</a> </li>
<li> <a href="wadmin.php" >文件管理</a> </li>
<li > <a href="viewUsers.php">用户管理</a> </li>
<li> <a href="viewip.php" >访问统计</a> </li>
<li> <a href="todayCoin.php" >今日金币</a> </li>
<li> <a href="viewdown.php" >下载统计</a> </li>
            </ul>
          </div><!--/.nav-collapse -->

<a href="?logout=1" class="btn btn-danger pull-right">Log out</a>
        </div>
      </div>
    </div>

<div class="container">

<h3>修改banner</h3>
<table class="table">
<?php
$dbc =newDbc();
$query = "select * from banner ";
$result = mysqli_query($dbc,$query);
while($row =mysqli_fetch_array($result))
{
?>
  <tr>
    <td><form style="margin:0 0 0" method="post" class="form-inline" action="action.php?type=banner">
    <input name="ID" type="hidden" value='<?php echo $row['ID'] ?>' />
<input  name="title" type="text" class="input" value='<?php echo $row['title'] ?>'/>
<input  name="content" type="text" class="input" value='<?php echo $row['content'] ?>'/>
<input  name="imgUrl" type="text" class="input-xlarge" value='<?php echo $row['imgUrl'] ?>'/>
<input type="submit" class='btn btn-primary' value="更改" />
</form>
</td>
  </tr>

  <?php

}


?>

</table>
<h3>修改科目信息</h3>
<table class="table">
<?php
$dbc =newDbc();
$query = "select * from setting ";
$result = mysqli_query($dbc,$query);
while($row =mysqli_fetch_array($result))
{
?>
  <tr>
    <td> <?php echo $row['subject'] ?> </td>
    <td><form style="margin:0 0 0" method="post" class="form-inline" action="action.php?type=change">
    <input name="subject" type="hidden" value='<?php echo $row['subject'] ?>' />
<input  name="name" type="text" class="input" value='<?php echo $row['name'] ?>'/>
<input  name="remark" type="text" class="input-xxlarge" value='<?php echo $row['remark'] ?>'/>
<input type="submit" class='btn btn-primary' value="更改" />
</form>
</td>
  </tr>

  <?php

}


?>

</table>
<h3>增加科目</h3>
<form method="post" class="form-inline" action="./action.php?type=add">
<p>英文名称</p>
<input  name="subject" type="text" />
<p>中文名称</p>
<input  name="name" type="text" />
<p>备注</p>
<textarea  name="remark" rows="5" cols="50">none</textarea>
<br />
<input class='btn btn-primary' type="submit" value="ADD" />


</form>


