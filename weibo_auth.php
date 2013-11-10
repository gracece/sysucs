<?php
session_start();
include_once( 'admin/libweibo/config.php' );
include_once( 'admin/libweibo/saetv2.ex.class.php' );
require_once ('functions.php');

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code']))
{
    $keys = array();
    $keys['code'] = $_REQUEST['code'];
    $keys['redirect_uri'] = WB_CALLBACK_URL;
    try 
    {
        $token = $o->getAccessToken( 'code', $keys ) ;
    }
    catch (OAuthException $e)
    {
        echo "error";
    }
}
else
{
    $token = $o->getTokenFromJSSDK();
}

if (isset($token))
{
    $_SESSION['token'] = $token;
    setcookie( 'weibojs_'.$o->client_id, http_build_query($token),time()+3600 );
    $c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
    $uid_get = $c->get_uid();
    if(isset($uid_get['uid']))
    {
        $uid = $uid_get['uid'];
    }
    else
    {
        echo "微博应用还在审核中，只允许特定测试账号使用微博登录,如有需要请联系grace";
        exit;
    }
    $user_message = $c->show_user_by_id($uid);//根据ID获取用户等基本信息
    $row = DB::queryFirstRow("SELECT `name` FROM `user` WHERE `wb_uid`=%s",$uid);
    if(empty($row))
    {
        html_header("计科一班-绑定微博");
?>
    <body style="background:url(./img/login/1.jpg);background-size:100%  ">
  <div class="container" style="height:100%">
<div class="alert alert-info"> <?php   echo "@".$user_message['name']." 未绑定计科一班账号"; ?> </div>
    <div class="auth_form">
      <form  method="post" action="binding.php">
        <h3>绑定计科一班账号</h3>
        <div  class="alert " id="info" style="display:none"></div>
        <input name="band" value="1" type="hidden" />
        <input id="username" name="username" placeholder="Username" type="text" />
        <br />
        <input id="password" name="password" placeholder="Password" type="password" />
        <br />
        <input type="submit" class="btn btn-primary" value="立即绑定！" />
      </form>
    </div>

<?php
    }
    else
    {

        setSession($row['name']);
        echo "授权成功！";
        header("Location:index.php");
    }

}
else
{
    echo "授权失败。";
}

?>
