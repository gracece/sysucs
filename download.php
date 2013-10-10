<?php
session_start();
$user = $_SESSION['user'];
@$right =$_SESSION['right'];
require("functions.php");
require("header.html");
?>
<div class="container">
<br />
<br />
<br />

<div class="alert alert-info">
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
        echo "没有这个文件,或者该文件已经被管理员删除,或移动到其他科目！";
        exit;
    }
    else{

        date_default_timezone_set('PRC');
        $row = mysqli_fetch_array($result);
        $fileTodown =$row['name'];
        $uploader =$row['user'];
        $download_times = $row['downloadtimes'];
        echo "downloading ".$fileTodown;

        if($right == 1)
        {
            $query = "select * from down where file='".addslashes($fileTodown)."' and user ='".$user."'";
            $down = mysqli_query($dbc,$query);
            $download_times = $down->num_rows;
            if($download_times > 1)
            {
                echo "已经下载过".$fileTodown.",无需金币";
                $type ="[再次]下载".$fileTodown;
                $num =0;
                coinChange($user,$num,$type);
            }
            else
            {

                $query = "select * from user where name ='".$user."'";
                $result =mysqli_query($dbc,$query);
                $row =mysqli_fetch_array($result);
                echo "当期余额".$row['coin'];
                if($row['coin'] <=0)
                {
                    echo "你是有多蛋疼才能把计科币搞到负数啊，面壁去！";
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

      $query="UPDATE resource set downloadtimes =downloadtimes +1  WHERE subject ='".$subject."' and date = '".$file."' ";
        mysqli_query($dbc,$query) or die  ("update download time failed!");

        $time =date("U");
        $query = "INSERT into down values('".$fileTodown."','".$time."','".$ip."','".$user."')";
        $result = mysqli_query($dbc,$query);


        header("Location:upload/".$subject."/".$fileTodown);
        exit;
    }
}
else
    echo "额，你穿越了吧！";

?>
