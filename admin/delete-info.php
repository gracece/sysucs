<?php
require_once('auth_admin.php');
require("../header.html");
require("../functions.php");
?>
<body>
<div class="container">



<?php
$dbc =newDbc();
mysqli_query($dbc,"set names UTF-8");
if(mysqli_connect_error()){    
    echo "failed";
}
date_default_timezone_set('PRC');
$deleteInfo = $_POST['deleteInfo'];
$deleteContent = $_POST['deleteContent'];
echo "<div class='well'><h2>deleting</h2><div class='alert alert-info'> ".$deleteContent." </div>";
$query = "DELETE FROM info WHERE date = '".$deleteInfo."'";
if(mysqli_query($dbc,$query)) echo "已从数据库删除";

$dbc->close();

echo "<h1 id='countdown' class='well' style='TEXT-align:center'></h1>";
?>

<script language="javascript">
//<!-- 倒计时5秒关闭页面
function clock(){
    i=i-1;
    document.title = "本窗口将在"+i+"秒后自动关闭!";
    document.getElementById("countdown").innerHTML =  "本窗口将在"+i+"秒后自动关闭!";
    if(i>0)setTimeout("clock();",1000);
    else self.close();
    }
    var i=1;
    clock();
    //-->
    </script>

</body>
</html>


