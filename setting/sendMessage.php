<?php
require_once('../functions.php');
require_once('../auth_head.php');
?>

<div class="alert alert-info">
<?php
$toUser = safePost('toUser');
$to =$toUser;
$content = safePost('content');
$from = $_SESSION['user'];
$user =$from;

if($toUser =='system' || $toUser=='@提醒')
{
    echo "无法向system/@提醒发送消息，如果有bug反馈，请直接联系grace";
    exit;
}
$result =db_select("user","name='".$toUser."'");
if($result -> num_rows < 1)
{
    echo "没有该用户！";
    exit;
}

if($content =='')
{
    echo "空消息！";
    exit;
}
addMessage($toUser,$content,$from);
echo "<i>".$content."</i> 发送成功";
echo "</div>";

 $talk =db_select("message","(`user`='".$user."' and `fromuser` ='".$to."') or (`user`='".$to."' and `fromuser`='".$user."') order by time desc");
    $num = $talk->num_rows;
    echo "<h3>总共".$num."条信息</h3>";
    echo " <table class='table'> <tbody> ";
    for ($i=0;$i<$num;$i++)
    {
        $row=mysqli_fetch_array($talk);
        if($row['fromuser'] ==$user)
            echo "<tr class='success'>";
        else
            echo "<tr class='info'>";

        echo "<td width='20%'><big>".$row['fromuser']."</big>
            <small>(".date("m/d H:i",$row['time']).")</small>
            </td><td>".nl2br($row['content'])."</td>
            </tr>";
    }

echo "</tbody> </table> ";
$query ="UPDATE `message` SET `read` = '1' WHERE `user` = '".$user."' COLLATE utf8_bin and `fromuser`='".$to."' COLLATE utf8_bin ";
$dbc =newDbc();
mysqli_query($dbc,$query) or die ("read failed!");

?>

