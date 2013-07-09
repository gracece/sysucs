<?php
require('functions.php');
$ip =get_user_ip();
session_start();

$url =safeGet("url");
if($url==NULL)
    $url="index.php";

/*
 //自动登陆部分
$dbc = newDbc();
$query = "SELECT * FROM user where ip ='".$ip."'";
$result = mysqli_query($dbc,$query);
$row = mysqli_fetch_row($result);
$count = $result->num_rows;
if($count >0 )
{
    $_SESSION['right']=1;
    $_SESSION['user']=$row[0];
    $_SESSION['auto']=1;
}

 */

if(isset($_SESSION['right'])&&$_SESSION['right']==1)
{
   header("Location:".$url);
    exit;
}

require("header.html");
?>
    <body style="background:url(./img/login/1.jpg);background-size:100%  ">
  <div class="container" style="height:100%">
    <div class="auth_form">
      <form  method="post">
        <h3>SYSUCS.ORG</h3>
        <div  class="alert " id="info" style="display:none"></div>
        <input name="login" value="1" type="hidden" />
        <input id="username" name="username" placeholder="Username" type="text" />
        <br />
        <input id="password" name="password" placeholder="Password" type="password" />
        <br />
        <span><a class="btn" href="reg.php" >注册</a></span>
        <input type="submit" style="float:right;" class="btn btn-primary" value="登录" />
      </form>
    </div>

<?php
if(isset($_POST['login']))
{
    $user =$_POST['username'];
    $password = $_POST['password'];
    //connect to mysql
    $dbc =newDbc();
    $query = "SELECT * FROM user where name ='".$user."' and
        password = '".sha1($password)."'";
    $result = mysqli_query($dbc,$query);
    if(!$result)
    {
        echo "数据查询失败！";
        exit;
    }
    $count = $result->num_rows;
    if($count >0 )
    {
        $row = mysqli_fetch_array($result);
        $_SESSION['right']=1;
        $_SESSION['user']=$user;
        $_SESSION['auto'] =0;
        $_SESSION['admin'] =$row['admin'];
        $_SESSION['addInfo'] = $row['addInfo'];
        header("Location:".$url);
        exit;
    }
    else 
    {
        echo" <script > document.getElementById(\"info\").style.display='block';
              document.getElementById(\"info\").innerHTML='你觉得是用户名错了还是密码错了？ ';
                                         </script > ";
    }
}
echo "</div>
    </body>
</html>";
?>

