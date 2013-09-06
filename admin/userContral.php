<?php
session_start();
if($_SESSION['admin'] !=1)
{
    header("Location:login.php");
    exit;
}

require_once('../functions.php');
date_default_timezone_set("PRC");

$user = $_POST['userId'];
$num = $_POST['coin'];
if($_POST['upOrDown'] == 'dec'){
    $num = -$num;
}
$type = $_POST['descr'];
if($type == ''){
    $type = '管理员修改';
}
coinChange($user,$num,$type);
if($num >0)
    addMessage($user,"计科币变更:".$type."<code>+".$num."</code>");
else
    addMessage($user,"计科币变更:".$type."<code>".$num."</code>");

echo "貌似可以了";
?>


