<?php
require('functions.php');
$ip =get_user_ip();
$dbc =newDbc();
session_start();

$url =safeGet("url");
if($url==NULL)
    $url="index.php";

if (isset($_COOKIE['sso']))
{
    $sso = addslashes($_COOKIE['sso']);
    $query = "SELECT * FROM cookie  where sso ='".$sso."'";
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
        $user = $row['user'];
        setSession($user);
        header("Location:".$url);
        exit;
    }


}


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
        <label class="checkbox">
          <input type="checkbox"  name="remember"> Remember me 
        </label>

        <span><a class="btn" href="reg.php" >注册</a></span>
        <input type="submit" style="float:right;" class="btn btn-primary" value="登录" />
      </form>
    </div>

<?php
if(isset($_POST['login']))
{
    $user =safePost('username');
    $password = safePost('password');
    $remember = safePost('remember');
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
        if($remember=="on")
        {
            $seed = $user.time().mt_rand(10,500);
            $sso = base64_encode(md5($seed));
            $query = "insert into cookie (sso,user,ip,time,ua) values('".$sso."','".$user."','".$ip."','".time()."','".$_SERVER['HTTP_USER_AGENT']."')";
            mysqli_query($dbc,$query);
            setcookie("sso",$sso,time()+30*24*60*60);
        }
        setSession($user);
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

