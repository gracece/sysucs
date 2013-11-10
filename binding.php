<?php
session_start();
require_once ('functions.php');

if(isset($_POST['band']))
{
    $name = safePost('username');
    $password = safePost('password');
    if(isset($_SESSION['token']))
    {
        $row = DB::queryFirstRow("SELECT * FROM `user` WHERE name=%s AND password=%s",$name,sha1($password));
        if(!empty($row))
        {
            DB::update('user',array(
                'wb_uid'=>$_SESSION['token']['uid']
            ),"name=%s",$name);
            setSession($name);
            
            header("location:index.php");

        }
        else
        {
            echo "密码错误";
        }

    }
    else
    {
        echo "请先登录微博并授权计科一班";
    }
}
