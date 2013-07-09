<?php
require_once('../functions.php');
require_once('../header.html');
require_once('../auth_head.php');
$user =$_SESSION['user'];
?>
<div class="container">
<br />
<br />
<div class="alert alert-info">
<h4>
停止服务！

<?php
exit;
if ($user =="湛江下暴雨")
{
    $time =safePost('time');
    $type =safePost('type');
    $dbc =newDbc();
    $query ="select * from dandan where time ='".$time."'";
    $result =mysqli_query($dbc,$query);
    $row =mysqli_fetch_array($result);
    $status = $row['status'];
    $book_user = $row['user'];
    if($type =="up")
    {
        if ($status ==1)
        {
            $query = "update dandan set status=2 where time ='".$time."'";
            mysqli_query($dbc,$query) or die("1 to 2 failed");
            addMessage($book_user,"辉宇确认订单！");
            echo "done!";
        }
        else if($status ==2)
        {
            $query = "update dandan set status=3 where time ='".$time."'";
            mysqli_query($dbc,$query) or die("2 to 3 failed");
            echo "done!";
            $num = 5;
            $type = "辉宇蛋蛋店交易成功！";
            coinChange($book_user,$num,$type);
            addMessage($book_user,$type);
        }
        else
            echo "订单不能再提升！";
    }
    else if($type =="cancel")
    {
        if($status <3)
        {
            $reason =safePost('reason');
            $query = "update dandan set status=4 where time ='".$time."'";
            mysqli_query($dbc,$query) or die("to 4 failed");
            echo "done!";
            coinChange($book_user,"3","蛋蛋店订单取消[".$reason."]");
            addMessage($book_user,"蛋蛋店订单取消,原因:".$reason."");
        }
        else
            echo "无法取消！";
    }
    
            echo " <a class='btn' href=\"dandan.php\">返回查看</a>";
}
else
{
    if (isset($_POST['addr']))
    {
        $num = safePost('num');
        if($num <1 || $num >10)
        {
            echo "你妹！";
            exit;
        }
        $addr = safePost('addr');
        if($addr ==NULL)
        {
            echo "地址都不写送毛啊! ";
            exit;
        }
        $remark = safePost('remark');
        $dbc = newDbc();
        $query ="insert into dandan (time,user,addr,remark,num,status) values('".time()."','$user','$addr','$remark','$num','1')";
        $result =mysqli_query($dbc,$query);
        if($result)
        {
            coinChange($user,"-3","辉宇蛋蛋店预定");
            addMessage("湛江下暴雨","鸡蛋新订单！来自".$user);
            echo "预定成功!";
            echo " <a class='btn' href=\"dandan.php\">返回查看</a>";
        }
        else
            echo "预定失败";


    }
}

