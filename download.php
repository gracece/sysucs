<?php
require("functions.php");
require_once('auth_head.php');
require("header.html");
$user = $_SESSION['user'];
@$right =$_SESSION['right'];
?>
<?php
$ip =get_user_ip();
if(isset($_GET['subject']) && isset($_GET['file']))
{
    $subject = safeGet('subject');
    $file = safeGet('file');
    $dbc =newDbc();
    $query = "SELECT * FROM resource  WHERE subject ='".$subject."' and date = ".$file." ";
    $result=mysqli_query($dbc,$query);

    if($result==false ||$result->num_rows == 0)
    {
?>
    <div class="container">
    <br />
    <br />
    <br />
    <div class="alert alert-info">
<?php

        echo "没有这个文件,或者该文件已经被管理员删除,或移动到其他科目！";
        exit;
    }
    else{

        date_default_timezone_set('PRC');
        $row = mysqli_fetch_array($result);
        $fileTodown =$row['name'];
        $uploader =$row['user'];
        $download_times = $row['downloadtimes'];



        $query="UPDATE resource set downloadtimes =downloadtimes +1  WHERE subject ='".$subject."' and date = '".$file."' ";
        mysqli_query($dbc,$query) or die  ("update download time failed!");

        $time =date("U");
        $query = "INSERT into down values('".$fileTodown."','".$time."','".$ip."','".$user."')";
        $result = mysqli_query($dbc,$query);



        $ext = pathinfo("upload/".$subject."/".$fileTodown,PATHINFO_EXTENSION);
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $oldFileName = $fileTodown;
        if(preg_match("/MSIE/",$ua))
            $fileTodown = rawurlencode($fileTodown);

        if($ext == "pdf")
        {
            header("Content-Type:application/pdf");
            header("Content-Disposition:inline;filename='".$fileTodown."'");
        }
        else if($ext=="jpg" or $ext=="png")
        {
            header("Content-Type:image");
            header("Content-Disposition:inline;filename='".$fileTodown."'");
        }
        else
        {
            header("Content-Type:application/octet-stream");
            header("Content-Disposition:attachment;filename=\"".$fileTodown."\"");
        }
        header("X-Sendfile:upload/".$subject."/".$fileTodown);
        $fileTodown = $oldFileName;
        if($right == 1)
        {
            $query = "select * from down where file='".addslashes($fileTodown)."' and user ='".$user."'";
            $down = mysqli_query($dbc,$query);
            $download_times = $down->num_rows;
            if($download_times > 1)
            {
                $type ="[再次]下载".$fileTodown;
                $num =0;
                coinChange($user,$num,$type);
            }
            else
            {

                $query = "select * from user where name ='".$user."'";
                $result =mysqli_query($dbc,$query);
                $row =mysqli_fetch_array($result);
                if($row['coin'] <=0)
                {
?>
                    <div class="container">
                    <br />
                    <br />
                    <br />
                    <div class="alert alert-info">
<?php
                    echo "当期余额".$row['coin'];
                    echo "请通过签到或分享资源获取计科币！";
                    exit;
                }


                if($subject =="film")
                    $num =-2;
                else
                    $num =-1;

                $type ="下载".$fileTodown;
                coinChange($user,$num,$type);

                if ($uploader !=""&&$uploader!=$user)
                {
                    $num = 0-$num;
                    $type ="资源".$fileTodown."被[".$user."]下载";
                    coinChange($uploader,$num,$type);
                    addMessage($uploader,$type);
                }
            }
        }
        exit;
    }
}
else
    echo "额，你穿越了吧！";

?>
