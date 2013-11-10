<?php
require_once('config.php');
error_reporting(E_ALL);
function get_user_ip() {
    if(isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] !='unknown')
    { $ip = $_SERVER['HTTP_CLIENT_IP'];}
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']!='unknown')
    {$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
    else{
        $ip = $_SERVER['REMOTE_ADDR']; 
    }
    return $ip;
}
date_default_timezone_set('PRC');

function getNameBySubject($subject)
{
    $detail = DB::queryFirstRow("SELECT * FROM setting where subject=%s",$subject);
    return $detail['name'];
}

function html_header($title="计科一班")
{
?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title><?php echo $title ?></title>
    <meta name="description" content="中山大学2011级计科一班">
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css?version=2.3.1">
<link href="../../css/style.css?v=gggggggggggg" rel="stylesheet" type="text/css" media="screen" />   
<script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap.js?version=2.3.1"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
    <script type="text/javascript">
    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F0a37f369f66ef3c1841dcc3320ec316a' type='text/javascript'%3E%3C/script%3E"));
    </script>


</head>

<?php    
}

function setSession($user)
{
    $dbc =newDbc();
    $query = "SELECT * FROM user where name ='".$user."'";
    $result = mysqli_query($dbc,$query);
    $row = mysqli_fetch_array($result);
    $_SESSION['right']=1;
    $_SESSION['user']=$user;
    $_SESSION['admin'] = intval($row['admin']);
    $_SESSION['addInfo'] = intval($row['addInfo']);
}

function safePost($str)
{
    $val = !empty($_POST["$str"]) ? $_POST["$str"]:null;
    // $val = strip_tags($val);
    // 这个好像太严格了
    // $val =htmlentities($val);
    $val = htmlentities($val,ENT_QUOTES,"UTF-8");
    if(!get_magic_quotes_gpc())
    {
        $val = addslashes($val);
    }
    return $val;
}

function safeGet($str)
{
    $val = !empty($_GET["$str"]) ? $_GET["$str"]:null;
    if(!get_magic_quotes_gpc())
    {
        $val = addslashes($val);
    }
    return $val;
}

function coinChange($user,$num,$type)
{
    $dbc =newDbc();
    $query ="update user set coin =coin+$num where name ='".$user."'";
    mysqli_query($dbc,$query) or die("failed");
    $timestamp = microtime(true);
    if($num >0)
        $query ="insert into coin values('".$user."','".$type."','".$timestamp."','+".$num."') ";
    else
        $query ="insert into coin values('".$user."','".$type."','".$timestamp."','".$num."') ";

    mysqli_query($dbc,$query) or die ("failed insert");
    $dbc->close();

}

function addMessage($user,$content,$from="system")
{
    $dbc =newDbc();
    $content =addslashes($content);
    $query ="insert into message values('".$user."','".time()."','".$content."','0','".$from."') ";
    mysqli_query($dbc,$query) or die ($query." add message failed ");
    $dbc->close();
}


function newDbc()
{
    $dbc = new mysqli('localhost',DB_USER,DB_PASSWORD,DB_NAME);
    $query = "set names 'utf8'";
    mysqli_query($dbc,$query) or die("db connect  failed");
    return $dbc;

}
function db_select($table,$condition ="1")
{
    $dbc =newDbc();
    $query = "select * from ".$table." where ".$condition;
    $result =mysqli_query($dbc,$query) or die ($query."failed!");
    return $result;


}
function show5info()
{
    echo " <table class='table table-hover '> <tbody> ";
    $dbc =newDbc();
    $query = "SELECT * FROM info where type ='通知' ORDER BY date DESC;";
    $result =mysqli_query($dbc,$query);
    $num_results = $result->num_rows;
    $total_results = $num_results;
    //只显示最近五条
    if($num_results >10)  $num_results =10;
    $i = 0;
    while($i<$num_results)
    {
        $row = mysqli_fetch_array($result);
        $i++;
        echo "<tr><td><p><b>".$row['ip']." </b>  ".date("Y-m-d H:i 星期",$row['date']).trans($row['date'])."</p>"
            .nl2br($row['content']).
            "</td></tr>";
    }
    echo " </tbody> </table> ";
    echo ' <a href="search.php?all=true&q=+" class="btn">查看全部通知</a> ';


}

function trans($timeString){
    switch(date('w',$timeString)){
    case 0:return '日';
    case 1:return '一';
    case 2:return '二';
    case 3:return '三';
    case 4:return '四';
    case 5:return '五';
    case 6:return '六';
    }
}
function writelist($parent,$dbc,$showUser =false){
    $root =$_SERVER['DOCUMENT_ROOT'];
    $query = "SELECT * FROM resource where subject ='".$parent."'ORDER BY date DESC;";
    echo' <table style="background:white" class="table table-striped table-bordered">
        <thead>
        <tr>
        <th style="width:30px;text-align:center;">#</th>
        <th style="width:420px;">名称</th>
        <th style="width:70px;" class="hidden-phone">文件大小</th>';
    if($showUser == true) echo ' <th style="width:70px;">上传者</th>';
    echo' <th style="width:70px;" class="hidden-phone">上传时间</th>
        <th style="width:30px;" class="hidden-phone">热度</th>';
    if($showUser == true) echo ' <th style="width:30px;" class="hidden-phone" >评论</th>';
    echo'
        </tr>
        </thead>
        <tbody>
        '; 
    if($r = mysqli_query($dbc,$query)){  
        $index = 1;  
        while($row = mysqli_fetch_array($r)){
            //  if(is_file($root.'/upload/'.$parent.'/'.$row['name']))
            //  {
            $size = filesize($root.'/upload/'.$parent.'/'.$row['name'])/1024/1024;
            $size = number_format($size,2);
            //两位小数
            $description = $row['description'];
            $commentNum =$row['comment'];
            echo "<tr>
                <td style='text-align:center;'>".$index."</td>
                <td>
                <a href='download.php?subject=".$parent."&file=".$row['date']."'>".$row['name']."</a>
                </td>
                <td class='hidden-phone'>".$size."MB</td>";

            if($showUser == true)
                echo" <td>".$row['user']."</td>";

            echo"
                <td class='hidden-phone'>".date("Y/m/d",$row['date'])."</td>
                <td class='hidden-phone'>".$row['downloadtimes']."</td>";
            if($showUser == true) echo "
                <td class='hidden-phone' > <a href=\"#fileinfo\" onclick='loadComment(\"fileinfo.php?subject=".$parent."&file=".$row['date']."\")' role=\"button\" data-toggle=\"modal\">".$commentNum."</a> </td>";
            echo " </tr> ";
            $index++;
            //  }
            // else
            //    echo $row['name']."not a file";


        }
    }else{
        echo mysqli_error($dbc);
    }
    echo " </tbody> </table> ";
}


function showMissionBtn($user)
{

    $today = date("Y/m/d");
    $date_second = strtotime($today);
    //显示签到按钮
    $count = DB::queryFirstField("SELECT COUNT(*) FROM coin WHERE date>=%i AND user=%s AND type='签到'",$date_second,$user);
    if($count== 0)
        echo " <a class='btn btn-large btn-primary'  href=\"mission.php?t=". md5(md5(strtotime('today'))."sysucs")."\">快来签到!</a><br /> ";
    else
    {
        $checkdays = DB::queryFirstField("SELECT checkdays FROM user WHERE name=%s",$user);
        echo " <a class='btn btn-large'   href=\"mission.php\">已签到".$checkdays."天<i class='icon-thumbs-up'></i></a><br /> ";
    }
}

function bing_pic()
{
$mkt=array( "en-US", "zh-CN", "ja-JP", "en-AU", "en-UK", "de-DE", "en-NZ", "en-CA");
$url="http://www.bing.com/HPImageArchive.aspx?format=XML&idx=".mt_rand(0,9)."&n=1&mkt=".$mkt[mt_rand(0,7)];
$content =file_get_contents($url);
$p = xml_parser_create();
xml_parse_into_struct($p,$content,$vals,$index);
xml_parser_free($p);
$url='http://www.bing.com'. $vals[5]['value'];
return $url;


}
?>
