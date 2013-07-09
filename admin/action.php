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
<div class="container">
<br />
<br />
<br />

<div class="alert alert-info">

  <?php
$type = safeGet('type');
$dbc = newDbc();
if($type == "add")
{
  $subject = safePost('subject');
  $name = safePost('name');
  $remark = safePost('remark');

  $query = "insert into setting (subject,name,remark) values('".$subject."','".$name."','".$remark."') ";
  mysqli_query($dbc, $query) or die ("add subject failed". $query);
  $stucture = "../upload/".$subject."/";
  if(!mkdir($stucture,0777))
  {
    die("创建文件夹失败，请手动创建<code>".$stucture."</code>,并更改权限为可写入！");
  }
}

else if($type=="change")
{
  $subject = safePost('subject');
  $name = safePost('name');
  $remark = safePost('remark');
  $query = "update setting set name='".$name."',remark='".$remark."' where subject ='".$subject."'";
  mysqli_query($dbc,$query) or die ("update failed ". $query);
  echo "更改成功！";
}
else if($type=="banner")
{
  $ID = safePost('ID');
  $imgUrl = safePost('imgUrl');
  $title = safePost('title');
  $content = safePost('content');
  $query = "update banner set title='".$title."',content='".$content."',imgUrl='".$imgUrl."' where ID ='".$ID."'";
  mysqli_query($dbc,$query) or die ("update failed ". $query);
  echo "更改成功！";
}

else
{
  echo "无任何操作！";
  exit;
}


