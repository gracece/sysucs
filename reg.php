<?php
require("header.html");
require("./functions.php");
$allow_to_reg = true;

session_start();
if(isset($_SESSION['preTime']))
{
    if(time()-$_SESSION['preTime'] <mt_rand(4,6))
    {
        echo "访问太频繁，请至少5秒后再试试！";
        exit;
    }
}
$_SESSION['preTime'] = time();

$ip = get_user_ip();
if($allow_to_reg && isset($_POST['reg']) )
{

    $name =safePost('name');
    $pass1 =safePost('pass1');
    $pass2 =safePost('pass2');
    $code =safePost('code');
    $email =safePost('email');
    $schoolnumber = safePost('schoolnumber');
    if ($schoolnumber=='') {
        echo "学号！";
        exit;
    }
    if($pass1 != $pass2)
        echo "两次输入密码不一致！";
    else if($pass1 =='')
        echo "空密码是什么心态！";
    else if($code !=CODE)
        echo "邀请码错误";
    else
    {
        $dbc =newDbc();
        $query = "SELECT count(*) FROM user where name ='".$name."'";
        $result = mysqli_query($dbc,$query);
        $row = mysqli_fetch_row($result);
        $count = $row[0];
        if($count >0 )
        {
            echo "用户已存在";
            exit;
        }

        /*
        //外网不适用，由于可能出现多个用户共用一个出口ip
        $query = "SELECT count(*) FROM user where ip ='".$ip."'";
        $result = mysqli_query($dbc,$query);
        $row = mysqli_fetch_row($result);
        $count = $row[0];
        if($count >0 )
        {
            echo $ip."已经注册过账户！ ";
            exit;
        }
         */

        $query = "select count(*) from user";
        $result =mysqli_query($dbc,$query);
        $row =mysqli_fetch_row($result);
        $number = $row[0];
        if($number == 0)
          $query = "INSERT INTO user (name,nickname,number,password,ip,email,coin,checkdays,admin,addInfo) values ('".$name."','".$name."','".$schoolnumber."','".sha1($pass1)."','".$ip."','".$email."','100','0','1','1')";
        else
          $query = "INSERT INTO user (name,nickname,number,password,ip,email,coin,checkdays) values ('".$name."','".$name."','".$schoolnumber."','".sha1($pass1)."','".$ip."','".$email."','100','0')";

        $sub = mysqli_query($dbc,$query);
        if($sub)
        {
            addMessage("grace","新用户 ".$name." ".$schoolnumber." ".$ip." ".$email);
            echo "ok!";
            echo"
                <a href='/'>马上登录看看</a>
                ";
        }
        else 
            echo "failed!";
    }
    exit;

}
else
?>
<div class="container">
<br />
<div class="span4 well">

<h3> <a href="http://sysucs.org">SYSUCS</a> 注册</h3>
<?php
    if(!$allow_to_reg)
        echo "<div class='alert'>已关闭,有需要请联系管理员 admin@sysucs.org </div>";
?>
<form method="post">
<input name="reg" value="1" type="hidden" />
<p>用户名</p>
<input id="name" name="name" type="text" />
<p>Email</p>
<input  name="email" type="email" />
<p>学号</p>
<input  name="schoolnumber" type="text" />
<p>密码</p>
<input id="pass1" name="pass1" type="password" />
<p>确认密码</p>
<input id="pass2" name="pass2" type="password" />
<p>**码</p>
<input name="code"  type="text" />
<br />
<input type="submit" value="submit" class="btn btn-primary" />
<br />

</form>



</div>
