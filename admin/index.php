<?php 
require_once('auth_admin.php');
require('../functions.php');
?>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>计科一班--后台管理</title>
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
<script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap.js"></script>
<script type="text/javascript" src="../js/bootstrap-wysiwyg.js"></script>
<style type="text/css">
#editor {
max-height: 250px;
height: 250px;
background-color: white;
border-collapse: separate;
border: 1px solid rgb(204, 204, 204);
padding: 4px;
box-sizing: content-box;
-webkit-box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
border-top-right-radius: 3px;
border-bottom-right-radius: 3px;
border-bottom-left-radius: 3px;
border-top-left-radius: 3px;
overflow: scroll;
outline: none;
}
</style>
</head>


     <script type="text/javascript">
       function reloadPage(){
           window.location.reload();
       }
       function checkForm(){
           if(window.confirm("删除后不可恢复，确定删除？")){
               return true;
           }
        return false;
       }
       function addList(){
          document.getElementById('content').value += "<ul></ul>"; 
       }
       function addItem(){
          document.getElementById('content').value += "<li></li>"; 
       }
</script>

<body>
<div style="padding: 0px 0px 50px; margin: 0px; border-width: 0px; height: 0px; display: block;" id="yass_top_edge_padding"></div>
  <div class="navbar  navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="../">SYSUCS.ORG</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
<li class="active"> <a href="#" >HOME</a> </li>
<?php
if($_SESSION['admin'] ==1)
{
    echo '
    <li> <a href="wadmin.php" >文件管理</a> </li>
<li> <a href="viewUsers.php">用户管理</a> </li>
<li> <a href="setting.php"> 科目设置</a> </li>
';
}

?>

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

<form action="insert_info.php" method="post">
<p>输入通知内容(可以使用下列按钮以获得更好的格式):</p>
<div class="alert"> 图床：<a href="http://tuchuang.duapp.com">baidu</a> <a href="http://weibotuchuang.sinaapp.com/">sina</a> </div>
<p>懒得搞编辑器了，凑合着用吧XD </p>
<textarea id="content" name="content" style="width: 900px; height: 200px"> </textarea>
<br />
<input type="submit" class ="btn btn-large" style="margin-right:3px;" value="发布" />

</form>
<?php
        error_reporting(E_ALL);
$dbc =newDbc();
          if(mysqli_connect_error()){
          echo "failed";
          }
          else{
          echo "<p>数据库连接成功，下面是历史消息：</p>";
          }
          mysqli_query($dbc,"set names utf-8");
          date_default_timezone_set('PRC');

$query = "SELECT * FROM info ORDER BY date DESC;";
          $result =mysqli_query($dbc,$query);
          $num_results = $result->num_rows;

          echo"
              <table class='table table-striped table-bordered'>
              <thead>
                  <tr>
                      <th>#</th>
                      <th>date</th>
                      <th width='60%'>content</th>
                      <th>ip</th>
                      <th>option</th>
                  </tr>
              </thead>
              <tbody> ";

          for($i=0;$i<$num_results;$i++)
          {
              $row = mysqli_fetch_array($result);
              echo "<tr>
                  <td>".($i+1)."</td>  ";
              echo "<td>".date("Y/m/d H:i",$row['date'])."</td>";
              echo "<td>".$row['content']."</td>";
              echo "<td>".$row['ip']."</td>";
              echo "
                  <td>
                  <form style='margin:0 0 0; ' onsubmit='return checkForm()' target='_blank' action='delete-info.php' method='post'>
                  <input name='deleteInfo' type='hidden' value='".$row['date']."' />
                  <input name='deleteContent' type='hidden' value='".$row['content']."' />
                  <input type='submit'class='btn btn-danger' value='delete' />
                  </form>
                  </td> ";
          }

?>
    </div>
</body>
</html>
