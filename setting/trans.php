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
<?php
if(isset($_POST['password']))
{
    $num =safePost('num');
    $toUser = safePost('to');
    $password =safePost('password');
    $reason = safePost('reason');
  
    $dbc=newDbc();
    $query ="select * from user where name='".$user."'";
    $result=mysqli_query($dbc,$query);
    $row=mysqli_fetch_array($result);
    if(sha1($password) != $row['password'])
    {
        echo"密码错误！";
        exit;
    }
    if($toUser == $user)
    {
        echo "自己转给自己是搞毛啊！";
        exit;
    }
    if($num <0)
    {
        echo "负数是搞毛啊";
        exit;
    }
    if($num <9)
    {
        echo "金额太小了不给转";
        exit;
    }
    if($row['coin'] < $num)
    {
        echo "账户余额不足！";
        exit;
    }
    if(!is_numeric($num))
    {
        echo "金额不是数字啊！！ ";
        exit;
    }
    $query ="select * from user where name='".$toUser."'";
    $result=mysqli_query($dbc,$query);
    if($result->num_rows ==0)
    {
        echo"$toUser 不存在！";
        exit;
    }

    $fee =0-($num * 0.05);
    $num = $num +$fee;
    $dec =0-$num;
    $type ="转让给".$toUser."(".$reason.")";
    coinChange($user,$dec,$type);
    $type ="转让手续费";
    coinChange($user,$fee,$type);

    $type =$user."转让(".$reason.")";
    coinChange($toUser,$num,$type);
    echo "成功转让！";
    echo $num;

}



?>
</h4>
</div>
<a href="../" class="btn">返回首页</a>
</div>


