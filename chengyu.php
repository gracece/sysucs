<?php
require_once('./functions.php');
function getOne($head)
{
    if($head == '')
        $head = "xxxxxxxxx";
    $head = last($head);
    $result = DB::query("select name from chengyu where name like '$head%' limit 100");
    $_ret = array();
    foreach ($result as $row ) {
        $_ret[] = $row['name'];
    }
    shuffle($_ret);
    return array_shift($_ret);
}

function last($word)
{
    return mb_substr($word,-1,1,"utf-8");
}

function trytry($now)
{
    $now = getOne($now);
    for ($i=0; $i < 30; $i++) {
        if(empty($now))
        {
            break;
        }
        echo "<a href='?q=$now'>$now</a>->";
        $now = getOne($now);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>成语</title>
    <meta name="description" content="中山大学2011级计科一班">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css?version=2.3.1">
<link href="../../css/style.css" rel="stylesheet" type="text/css" media="screen" />   
</head>

<div class="container-fluid">

<br>
<br>


<form class="form-search">
  <input type="text" placeholder="输入成语或某个字"  class="input-medium search-query" name="q">
    <input type="number"  value=10 name="times" class="span1">
  <button type="submit" class="btn">接下去</button>
</form>
<ul>
<?php
if (isset($_GET['q'])) {
    $now = $_GET['q'];
    if(isset($_GET['times']) && is_numeric($_GET['times']))
    {
        $times = $_GET['times'];
    }
    else {
        $times = 10;
    }
    for ($i=1; $i <= $times; $i++) {
        echo " <p>第".$i."次尝试：</p> ";
        trytry($now);
    }
    }

?>
</ul>

</div>
