<?php
require_once('functions.php');
require_once('auth_head.php');
?>

        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<?php
$subject = safeGet('subject');
$file = safeGet('file');
$dbc= newDbc();
if($file !=NULL)
    $result =db_select("resource","subject='".$subject."' and date='".$file."'");
else
{
    $fileName =safeGet('fileName');
    $result =db_select("resource","subject ='".$subject."' and name='".$fileName."'");
}

if($result==false ||$result->num_rows == 0)
{
    echo "没有这个文件,或者该资源已经被管理员删除";
    exit;
}
else
{

    $row = mysqli_fetch_array($result);
    $fileName =$row['name'];
    $file =$row['date'];
    $uploader =$row['user'];
    $downloadTimes = $row['downloadtimes'];
    $description =$row['description'];
    echo'
        <h3>'.$fileName;
       echo "  <a class='btn btn-small' href='download.php?subject=".$subject."&file=".$file."'> <i class='icon-download-alt'></i> 下载</a>";
    echo '</h3>
        </div>
    <div class="modal-body" style="max-height:470px;">
    <h4>上传者:'.$uploader.'</h4>
    <h4>资源描述</h4>
        ';
    if($description =='')
        echo "空";
    else
        echo $description;
    echo "
        <h4>资源评论</h4>
        ";
    $query = "SELECT comment.subject,comment.file,comment.time,comment.content,user.nickname FROM comment,user 
        where comment.user=user.name  and 
        subject ='".$subject."' and file='".$fileName."'  
        ORDER BY comment.time DESC;";
    $comment =mysqli_query($dbc,$query);
    if($comment ->num_rows == 0)
        echo "暂无评论!";

    else
    {
        echo " <table class='table table-hover '> <tbody> ";
        for($i=0;$i<$comment->num_rows;$i++)
        {
            $row=mysqli_fetch_array($comment);
            echo "<tr><td><p><big>".$row['nickname']."</big> ".date("m/d H:i",$row['time'])."</p>";
            echo "<p>".$row['content']."</p></td></tr>";
        }
        echo " </tbody></table>";
    }



}

?>
<hr />
<iframe  style="display:none;" name="addComment">
</iframe>
<form onSubmit=" setTimeout(show,500);
function show()
{
<?php
  echo"loadComment('fileinfo.php?subject=".$subject."&file=".$file."');";
?>
}
 " action="addComment.php" target="addComment" method="post">
<input name="file" value="<?php echo $fileName ?>" type="hidden" />
<input name="subject" value="<?php echo $subject ?>" type="hidden" />
<textarea  name="content" rows="3" style="width:90%"></textarea>
<br />
<input type="submit" class="btn " value="发布" />

</form>
</div>
