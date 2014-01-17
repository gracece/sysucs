<?php
require("../functions.php");
require("../auth_head.php");
$user = $_SESSION['user'];
$account = DB::queryFirstRow("SELECT * FROM user WHERE name=%s",$user);
if ($account['coin']<25)
{
    echo "余额小于25,请稍后再来";
}
else
{
    DB::query("SELECT * FROM coin WHERE user=%s and type='试试手气' AND date>%i",$user,strtotime("today")+date("H")*3600);
    $count = DB::count();
    if ($count >= 5)
    {
        echo "-99";
    }
    else
    {
     if(safeGet('twice') == '1')
     {
        $num =  mt_rand(-22,22);
        coinChange($user,-1,"试试手气翻倍成本");
     }
     else if(safeGet('twice') == '2')
     {
        $num =  mt_rand(-99,99);
        coinChange($user,-2,"试试手气翻倍成本");
     }
     else
        $num =  mt_rand(-11,11);

    $type = "试试手气";
    coinChange($user,$num,$type);
    echo $num;
    }
}
?>
