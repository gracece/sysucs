<?php
require("../functions.php");
require("../auth_head.php");
$user = $_SESSION['user'];
$account = DB::queryFirstRow("SELECT * FROM user WHERE name=%s",$user);
if ($account['coin']<50)
{
    echo "余额小于50,请稍后再来";
}
else
{
    DB::query("SELECT * FROM coin WHERE user=%s and type='试试手气' AND date>%i",$user,strtotime("today")+date("H")*3600);
    $count = DB::count();
    if ($count >= 5)
    {
        echo "本小时段的5次机会已用完，请下一时段再来！";
    }
    else
    {
    $num =  mt_rand(-12,11);
    $type = "试试手气";
    coinChange($user,$num,$type);
    echo $num;
    }
}
?>
