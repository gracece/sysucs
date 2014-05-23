<?php
require_once('auth_admin.php');
require_once('../functions.php');
require_once('../header.html');

if($_SESSION['admin'] !=1)
{
    header("Location:index.php");
    exit;
}

$user = 'ALL_USERS_LIST';
$theCoin = 0;
$dbc = newDbc();
$isSet = isset($_GET['user']);
if($isSet){
    $user = $_GET['user'];
    $query = "SELECT * FROM coin WHERE user='".$user."' ORDER BY date DESC";
}else{
    $query = "SELECT * FROM user ORDER BY coin desc  ";
}

$result = mysqli_query($dbc,$query);
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
<li class="active"> <a href="viewUsers.php">用户管理</a> </li>
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

<a href="./invite_code.php" class="btn pull-right">邀请码管理</a>
<h2>
<?php 
if($user == 'ALL_USERS_LIST')
     echo '用户列表';
else
{
    echo $user;
    $query ="select * from user where name ='".$user."'";
    $user_info= mysqli_query($dbc,$query);
    $r = mysqli_fetch_array($user_info);
    echo "(".$r['coin'].")";

}
?>
</h2>
<h3 id="change"></h3>
<div class='row'>
<div class='span8'>
<table class='table table-bordered table-striped'>
<thead>
<?php
if($isSet) echo "<tr><th width='86px'>Time</th><th>Type</th><th>Num</th></tr>";
else echo "<tr><th>Name</th>
    <th>IP</th>
    <th>上次登录</th>
    <th>学号</th>
    <th>Coin</th></tr>";
?>
</thead>
<tbody>
<?php
if($isSet){
    while($row = mysqli_fetch_array($result)){
        echo "<tr><td>".date('m/d H:i',$row['date'])."</td><td>".$row['type']."</td><td>".$row['num']."</td></tr>";
    }
}else{
    while($row = mysqli_fetch_array($result)){
        echo "<tr><td><a href='./viewUsers.php?user=".$row['name']."'>".$row['name']."</a></td>
            <td>".$row['ip']."</td>
            <td>".$row['last_login']."</td>
            <td>".$row['number']."</td>
            <td>".$row['coin']."</td></tr>";
    }
}
?>
</tbody>
</table>
</div><!-- end left span -->
<script type="text/javascript">
function sendform()
{
    $.post("userContral.php", $("#send").serialize(), function(data) {
        $("#change").html(data);
 }); 
}
</script>

<div class='span4'>
<form class='well' id='send'  >
<h4>用户 Id:</h4>
 <input name='userId' type="text" style='text-align:center' <?php if($isSet)echo"value='".$user."'";?> />
<h4>计科币修改: </h4>
<div class='form-inline'>
<input type='radio' value='add' name='upOrDown' checked='checked'/>增加
<input type='radio' value='dec' name='upOrDown'/>减少
</div>
<input name='coin' style='margin-top:5px' type="number" /> 
<h4>操作描述<small>（可为空）</small>: </h4>
<input name='descr' type='text' style="text-align:center" />
<a href="#" class='btn btn-primary' onclick ="sendform()">执行</a>
</form>

<form  class="well" method="post" action="./userContral.php">
 <input name='userId' type="hidden" style='text-align:center' <?php if($isSet)echo"value='".$user."'";?> />
<input name="reset" value="true" type="hidden" />
<p>操作密码</p>
<input  name="admin-code" type="text" />
<input type="submit" class="btn btn-danger" value="重置密码" />

</form>
<div><!-- end right span-->
</div><!-- end row -->
</div><!-- container -->

