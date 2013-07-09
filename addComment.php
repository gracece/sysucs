<?php
require_once('functions.php');
require_once('auth_head.php');
require_once('header.html');
?>
<div class="container">
<br />
<br />
<div class="alert alert-info">

<?php
$user =$_SESSION['user'];
$file =safePost('file');
$subject = safePost('subject');
$content =safePost('content');
if ($content ==NULL)
{
    echo "内容为空！";
    exit;
}
$result =db_select("resource","subject='".$subject."' and name='".$file."'");

$row = mysqli_fetch_array($result);
$uploader =$row['user'];

$dbc =newDbc();
$query = "insert into comment (subject,file,user,time,content) values ('".$subject."','".$file."','".$user."','".time()."','".$content."')";
$result =mysqli_query($dbc,$query);
if($result)
    echo "评论成功！";
else
    echo "失败！";

//$query="UPDATE ".$subject." set comment =comment +1  WHERE name = '".$file."' ";
$query="UPDATE resource set comment =comment +1  WHERE name = '".$file."' and subject ='".$subject."' ";
mysqli_query($dbc,$query) or die("add comment number failed!");

$content =$file."有新评论 ".$user."说：".$content;
addMessage($uploader,$content);

echo "<p class='alert alert-info' id='cc'>dosomething</p>";
echo "<script type='text/javascript'>
    function clock(){    
        i--;
        document.getElementById('cc').innerHTML='本窗口将在'+i+'秒后自动关闭';
        if(i>0)
            setTimeout('clock();',1000);
        else self.close(); 
        }
        var i=2;clock('cc');</script>";




?>
</div></div>




