<?php
require("../functions.php");
$dbc = newDbc();
//允许访问的文件夹
$sub_array =array("algorithms","communication","physical","graph","os","network","others");
if(isset($_GET['s']))
{
    if(in_array($_GET['s'],$sub_array))
    {
        $subject = $_GET['s'];
    writelist($subject,$dbc);
    }
    else 
        echo "no found!";

}

?>
