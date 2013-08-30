<?php 
session_start();

@$logout=$_GET['userout'];
if($logout ==1)
{
    if (isset($_COOKIE['sso']))
    {
        $dbc =newDbc();
        $query = "delete  from cookie where sso='".$_COOKIE['sso']."'";
        $result=mysqli_query($dbc,$query);
    }
    setcookie("sso", "", time()-3600);
    $_SESSION['right']=0;

}

$url=$_SERVER['PHP_SELF'];

if(@$_SESSION['right']!=1)
{
    header("Location:../../login.php?url=".$url);
    exit;
}
?>
