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
            include_once('libweibo/cwbgj.class.php');

            $wbTitle = '计科一班通知'.date("Y/m/d");//测试标题
            $wbName = 'SYSUCS.ORG';//测试作者昵称
            $fFont = '3';//字体1，2，3，4
            $cwbCon = $content;
            $imgUpload = 'http://sysucs.org/img/banner/logo-blue.png';
            //要测试的插图，多个图请在每个图片地址后加上;号
            $api_url = 'http://www.cwbgj.com/api.php';
            $cwbgj = new Cwbgj;
            $api_input["key"] = 'qq202524';
            $api_input["format"] = 'json';
            $api_input["wbTitle"] = $wbTitle;
            $api_input["wbName"] = $wbName;
            $api_input["fFont"] = $fFont;
            $api_input["cwbCon"] = $cwbCon;
            $api_input["imgUpload"] = $imgUpload;
            $cwbgj->submit($api_url,$api_input);
            $return= $cwbgj->results;

            $arr = json_decode($return,1);

            $stxt = $arr['txt'];//返回的适合发布到微博的140字缩略文字
            $surl = $arr['shareurl'];//返回的微博分享附加地址
            $spic = $arr['imgurl'];//返回的被转换的长微博图片地址

            echo '<img src="'.$spic.'" alt="">';
            $content = mb_substr($content,0,120,"UTF-8");
            $content .= "……详细信息见长微博";
            $ret = $c->upload($content,$spic,23.0686,113.380813);	//发送微博
        }
        else
        {
            $ret = $c->update($content,23.0686,113.380813);	//发送微博
        }

        echo "<div class='alert alert-info'>";
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

