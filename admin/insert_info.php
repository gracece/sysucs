<?php
require_once('auth_admin.php');
require('../header.html');
require('../functions.php');

?>
    <body>
<div class="container">
<br />
<br />
<br />

<?php

$ip =get_user_ip();
$dbc = newDbc();
mysqli_query($dbc,"set names UTF-8;");
date_default_timezone_set('PRC');
$date =date("U");

$content=$_POST['content'];
if(!get_magic_quotes_gpc())
{
    $content = addslashes($content);
}

if ($content == NULL)
{
    echo "NULL!";
    exit;
}
$content =trim($content);
echo "<div class=\"alert alert-info\"><h3>". $content."</div>\n";
$type ="通知";
$subject ="info";
$query = "INSERT INTO info values ('".$content."','".$type."','".$subject."','".$date."','".$_SESSION['user']."')";
$sub = mysqli_query($dbc,$query);
$dbc->close();

if($sub){
    echo "<div class=\"alert alert-success\"><h3>";
    echo "加入数据库成功！<br />";
    echo "</h3></div>\n";
}else{
    echo "失败";
}


if(isset($_POST['toWeibo']) && $_POST['toWeibo']=="on")
{
require_once('libweibo/config_cs2011.php');
require_once('libweibo/saetv2.ex.class.php');
$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,CS_weibo_token);


    $content=trim($_POST['content']);
    if( isset($content )) {
        $content = strip_tags($content);
        $content = str_replace("&nbsp;",'',$content);
        $len = (strlen($content) + mb_strlen($content,'UTF8'))/2;
        if($len%2 != 0)
            $len = $len +1;
        $len = $len/2;

        if($len >=140)
        {
            $content = mb_substr($content,0,120,"UTF-8");
            $content .= "……详细信息请访问 http://sysucs.org";
        }

        echo "<div class='alert alert-info'>";
        $ret = $c->update($content,23.0686,113.380813);	//发送微博
        echo $content;
        if ( isset($ret['error_code']) && $ret['error_code'] > 0 ) {
            echo "<p>微博发送失败，错误：{$ret['error_code']}:{$ret['error']}</p>";
        } else {
            echo "<p>微博发送成功</p>";
        }
        echo "</div>";
    }

}

    echo "<a class='btn' href='/'>返回首页查看</a>";
?>
</div>
</body>

