<?php
require_once('../auth_head.php');

$dbc =newDbc();
$query = "select water.ID,water.content,water.time,water.user,user.nickname from water,user where user.name =water.user order by water.ID desc";
$water =mysqli_query($dbc,$query) or die("failed select");

echo " <table class='table table-striped'> <tbody> ";

for($i =0;$i<$water->num_rows;$i++)
{
    $row =mysqli_fetch_array($water);
    echo "<tr><td width='5%' id=".$row['ID'].">".$row['ID']."楼</td><td>
        <p><big><a title='".$row['user']."' href='../setting/message.php?to=".$row['user']."'>".$row['nickname']."</a></big> <small>";
    echo date("m/d H:i",$row['time'])."</small></p>";
    echo nl2br($row['content'])."</td><td width='8%'>
        <button class='btn' onclick=\"reply('".$row['user']."')\" >回复</button> 
        </td></tr>";

}


    echo"</tbody> </table> ";
