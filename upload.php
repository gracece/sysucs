
<?php
error_reporting("E_ALL");
require("functions.php");
require("auth_head.php");
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>计科一班</title>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />   
<style type="text/css"></style></head>



<body>
 <div class=header onclick="window.location.reload()" title="点我也能刷新哦！">
            <div class="inner row">
              <img src="./img/newlogo_white.png" alt="" />
            </div>
          </div>

<div class="container">
<?php

$ip=get_user_ip();
if($ip =="172.18.187.103")
    exit;
$isPost = false;
$subject = $_POST["subject"];
$notInsertToInfo = safePost("notInsertToInfo");
echo '<div class="well"><h1>';
if($subject =="film")
    $allow_type =array("rar","zip","7z","avi","mp4","mp3","hlv","mov","asf","wmv","3gp","mkv","f4v","flv","rmvb","rm","webm");
else
    $allow_type=array("apk","asm","epub","img","iso","xls","xlsx","cpp","pdf","gif","mp3","mp4","zip","rar","doc","docx","mov","ppt","pptx","txt","7z","jpeg","jpg","JPEG","png");
//允许的文件类型
$torrent = explode(".",$_FILES["file"]["name"]);
$file_end = end($torrent);
$file_end = strtolower($file_end);
//获取文件的后缀并转换为小写


if (in_array($file_end,$allow_type))
{
    if ($_FILES["file"]["error"] > 0)
    {
        switch($_FILES["file"]["error"])
        {
        case 1: echo "error 1";break;
        case 2: 
            echo "文件大小超过限制了!";
            break;
        case 3: echo "error 3";break;
        case 4: echo "error 4";break;
        case 5: echo "error 5";break;
        case 6:
            echo "文件上传出错！";
            break;
        }
    }
    else
    {
        echo "上传: " . $_FILES["file"]["name"] . "<br />";
        echo "类型: " . $_FILES["file"]["type"] . "<br />";
        echo "大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";

        if (file_exists("upload/$subject/" . $_FILES["file"]["name"]))
        {
            echo '<div class= "alert alert-error">';
            echo $_FILES["file"]["name"] . " 已经存在！</div> ";
            exit;
        }
        else if (!is_dir("upload/".$subject))
        {
            echo $subject."不是一个合法目录！";
            exit;

        }
        else 
        {

            move_uploaded_file($_FILES["file"]["tmp_name"],
                "upload/$subject/" . $_FILES["file"]["name"]);
            echo '<div class= "alert alert-success">';
            echo "上传成功！！！</div>";
            echo "<p class='alert alert-info' id='cc'>dosomething</p>";
            echo "<script type='text/javascript'>
                function clock(){    
                    i--;
                    document.getElementById('cc').innerHTML='本窗口将在'+i+'秒后自动关闭';
                    if(i>0)
                    setTimeout('clock();',1000);
                    else self.close(); 
                 }
        var i=2;clock('cc');</script>";

        $dbc = newDbc();
        mysqli_query($dbc,"set names UTF-8;");
        date_default_timezone_set('PRC');
        $user =$_SESSION['user'];
        $path = './upload/';
        $parent = $subject;
        $Filename = $_FILES['file']['name'];
        $date =date("U");
        $description = safePost('description');
       $query = "INSERT INTO resource values ('".$Filename."',".$date.",'".$description."','".$ip."','0','".$user."','0','".$subject."');";
        $sub = mysqli_query($dbc,$query);
        if($sub){
            echo "加入数据库<br />";
        }else{
            echo "失败";
        }
        
        if($subject == "film")
        {
            $num = 5;
            $type ="[上传电影]".$Filename;
        }
        else
        {
            $num =3;
            $type ="[上传]".$Filename;
        }
        coinChange($user,$num,$type);

        //处理是否插入通知栏
        if($notInsertToInfo != "on")
        {
            $content = "<a href=\"download.php?subject=".$parent."&file=".$date."\">".$Filename."</a>";
            $type="资源更新";
            $subject = $parent;
            $query = "INSERT INTO info values ('".$content."','".$type."','".$subject."','".$date."','".$user."')";
            $hehe = mysqli_query($dbc,$query);
            if($hehe)
                echo "插入通知栏成功\n";
            else 
                echo "插入通知栏失败\n";
        }
        }
    }
}
else 
{
    echo "类型: ". $file_end . "<br />";
    echo "这个文件类型不允许！";
    echo "允许的文件有：</br>";
    foreach($allow_type as $xxx)
        echo $xxx . "、 ";
    echo "</br> 如有需要，请与管理员联系！";
}
echo "</div></h1>";
?>

</div>


</body>
</html>

