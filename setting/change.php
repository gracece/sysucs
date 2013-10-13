<?php
require("../header.html");
require("../functions.php");
require("../auth_head.php");
$user = $_SESSION['user'];
$nowip =get_user_ip();
?>
<div class="container">
<br />
<br />
<div class="alert alert-info">
<h4>
<?php
$type = safeGet('type');
$dbc =newDbc();

if($type == 1)
{
    $email = safePost('email');
    $signature = safePost('signature');
    $signature = substr($signature,0,180);
    $nickname =safePost('nickname');
    $nicknameOK =true;
    $query ="select nickname from user where name='".$user."'";
    $rrrrr=mysqli_query($dbc,$query);
    $row =mysqli_fetch_array($rrrrr);
    $nowNickname=$row[0];

    if (strtolower($nickname) != strtolower($user)&& strtolower($nickname)!= strtolower($nowNickname))
    {
        $query = "select * from user where name='".$nickname."'";
        $result=mysqli_query($dbc,$query);
        if($result->num_rows >0)
        {
            $nicknameOK =false;
            echo "你不能把昵称改得和别人的登录名一样啊==<br />";
        }
        $query = "select * from user where nickname='".$nickname."'";
        $result=mysqli_query($dbc,$query);
        if($result->num_rows >0)
        {
            $nicknameOK =false;
            echo "这个昵称已经有人在用了<br />";
        }
    }

    if($nickname =='')
        $nicknameOK =false;

    if(!$nicknameOK)
    {
        $nickname =$user;
    }

    $query = "update user set signature ='".$signature."',nickname='".$nickname."',email='".$email."' where name ='".$user."'";
    $result = mysqli_query($dbc,$query);
    if($result)
        echo "资料更改成功！";
    else 
        echo "资料更改失败！";

}

if($type==2)
{
    $old = safePost('old');
    $new1 = safePost('new1');
    $new2 = safePost('new2');


    if($old != null )
    {
        if ($new2 != $new1)
        {
            echo "两次输入不一致！";
            exit;
        }
        $query = "select * from user where name ='".$user."'";
        $result = mysqli_query($dbc,$query);
        $row = mysqli_fetch_array($result);
        if($row['password'] == sha1($old))
        {
            $query = "update user set password = '".sha1($new1)."' where name ='".$user."'";
            $result = mysqli_query($dbc,$query);
            if($result)
                echo "密码更改成功！";
            else
                echo  "密码更改失败!";
        }
        else
        {
            echo "原密码错误";
            exit;
        }
    }

}
?>
</div>
<a href="./" class="btn">返回</a>
<a href="./rank.php" class="btn">查看排行榜</a>
</div>

