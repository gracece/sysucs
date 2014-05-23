<?php
require_once('../functions.php');
require_once('../auth_head.php');

$studentID = safePost('studentID');
$password = safePost('password');
$user = $_SESSION['user'];

$useInfo = DB::queryFirstRow("SELECT * FROM user WHERE name=%s",$user);
if ($useInfo['verified']==0)
{
    if(verify_uems($studentID,$password))
    {
        DB::query("SELECT * FROM user WHERE number=%s AND verified=1",$studentID);
        $counter = DB::count();
        if($counter >0)
        {
            echo $studentID."已被认证！";
        }
        else
        {
            echo "认证成功";
            DB::update('user',array(
                'verified' => 1,
                'number' =>$studentID,
            ),"name=%s",$user);
            addMessage('grace',$user."认证".$studentID);
            coinChange($user,50,"认证奖励");
        }
    }
    else
    {
        echo "认证失败";
    }
}
else
{
    echo "无需重复认证";
}
