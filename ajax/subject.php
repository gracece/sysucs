<?php
require("../functions.php");
require("../auth_head.php");

$result = DB::query("SELECT * FROM setting where `show`=0");
echo "<ul class='nav nav-pills nav-stacked'>";
foreach ($result as $row) {
    echo '<li style="float:left"> <a href="#detail" onclick="loadXML(\'ajax/ls-inner.php\',\''.$row['subject'].'\')">'.$row['name'].'</a>
        </li>';
}
echo "</ul>";

