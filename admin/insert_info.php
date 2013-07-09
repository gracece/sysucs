

<?php
require_once('auth_admin.php');
require('../header.html');
require('../functions.php');
?>
    <body>
<div class="container">
<br />
<br />
<br />

<?php

$ip =get_user_ip();
$dbc = newDbc();
            mysqli_query($dbc,"set names UTF-8;");
            date_default_timezone_set('PRC');
             $date =date("U");

            $content=$_POST['content'];
            if(!get_magic_quotes_gpc())
            {
                $content = addslashes($content);
            }

            if ($content == NULL)
            {
                echo "NULL!";
                exit;
            }
            $content =trim($content);
            echo "<div class=\"alert alert-info\"><h3>". $content."</div>\n";
            $type ="通知";
            $subject ="info";
            $query = "INSERT INTO info values ('".$content."','".$type."','".$subject."','".$date."','".$ip."')";
            $sub = mysqli_query($dbc,$query);
            $dbc->close();

            


            if($sub){
                echo "<div class=\"alert alert-success\"><h3>";
                echo "加入数据库成功！<br />";
                echo "</h3></div>\n";
                echo "<a class='btn' href='/'>返回首页查看</a>";
            }else{
                echo "失败";
            }

?>
</div>
</body>

