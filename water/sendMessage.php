<?php
require_once('../functions.php');
require_once('../auth_head.php');
?>

<div class="alert alert-info">
<?php
$content = safePost('content');
$user = $_SESSION['user'];
if($content =='')
{
    echo "空消息！";
    exit;
}

$dbc =newDbc();
$query ="insert into water(content,user,time) values('".$content."','".$user."','".time()."')";

//if ($user != "grace")
    mysqli_query ($dbc,$query) or die ("插入失败");

preg_match_all("/@\w{0,}([\x{4e00}-\x{9fa5}]){0,}/u", $content, $called_name);
if(count($called_name[0])>0)
{
    foreach ($called_name[0] as $value)
    {
        $uname=substr(trim($value),1);
        if(strtolower($uname) != strtolower($user))
        {
            $find =db_select("user","name='".$uname."'");

            if($find->num_rows >0)
            {
                $cont =$user."在<a href='../../water'>水水水</a>中提到了你:".$content;
                addMessage($uname,$cont,"@提醒");
                echo "成功提醒<i>".$uname."</i><br />";
            }
            else
            {
                echo "<p>没有找到".$uname."</p>";
            }

        }
        else
             echo "<p>熊孩子自己@自己是要干嘛啊</p>";

        
    }


}

echo "</div><div class='alert alert-success'><i>".$content."</i> 发送成功";
echo "</div>";
require('show.php');

?>

