<?php
require_once('auth_admin.php');
require_once('../functions.php');
require_once('../header.html');

if($_SESSION['admin'] !=1)
{
    header("Location:index.php");
    exit;
}

$type = safeGet('type');
if ($type =="move")
{
    $subject = safePost('subject');
    $file = safePost('file');
    $new = safePost('newsubject');
    $source =  "../upload/".$subject."/".$file;
    $dest =  "../upload/".$new."/".$file;
    if(is_file("../upload/".$subject."/".$file))
    {
        if(copy($source,$dest))
        {
            unlink($source);
            $dbc = newDbc();
            $query = "UPDATE resource set subject='".$new."' WHERE name='".$file."'";
            if(mysqli_query($dbc,$query))
            {
                echo "success!";
            }
            else
                echo "fail";
        }
        
    }
}
else
{
$subject = safeGet('subject');
$file = safeGet('file');
?>

<div class="container">
<br />
<br />
<br />

<form action="?type=move"  method="post">
    <div>
      <select  name="newsubject"  style="width:240px;">
        <option value="none">请选择栏目</option>
<?php
    $dbc = newDbc();
    $query = "select * from setting where `show`=1";
    $result = mysqli_query($dbc,$query);
    while($row = mysqli_fetch_array($result))
    {
        echo ' <option value="'.$row['subject'].'">'.$row['name'].'</option>';
    }
?>
      </select>
      <br />
      <input name="subject" type="hidden" value="<?php echo $subject ?>" />
      <input name="file" type="hidden"  value="<?php echo $file ?>"/>
      <br />
      <input class="btn btn-primary btn-large" type="submit"  name="submit" value="移动" />
    </form>
</div>

<?php

}
