<?php
require_once('auth_admin.php');
require_once('../functions.php');
require_once('../header.html');

if($_SESSION['admin'] !=1)
{
    header("Location:index.php");
    exit;
}

?>

<div class="container">
<?php
if(safePost('new')==true)
{
    $code = md5(sha1("sysucs".time()));
    if(safePost('admin-code')=="sure")
    {
        DB::insert("invite_code",array(
            "code"=>$code,
        ));
        header("Location:".$_SERVER['PHP_SELF']);
    }
    else
    {
        echo ' <div class="alert alert-danger">Wrong Admin Code</div> ';
    }
}
?>

<form  class=" span4" method="post" action="#">
<p>操作密码</p>
<input  name="admin-code" type="text" />
<input type="hidden" name="new" value="true">
<input type="submit" class="btn btn-primary" value="生成邀请码" />
</form>
<table class="table">
<thead>
    <tr>
        <td>id</td>
        <td>code</td>
        <td>valid</td>
        <td>user</td>
        <td>time</td>
    </tr>
</thead>
<tbody>

<?php
$result = DB::query("SELECT * FROM invite_code ORDER BY ID DESC");
foreach ($result as $row) {
    echo "
        <tr>
            <td>{$row['id']}</td>
            <td> <a href='/reg.php?code={$row['code']}' > {$row['code']} </a> </td>
            <td>{$row['valid']}</td>
            <td>{$row['user']}</td>
            <td>{$row['time']}</td>
        </tr>
        ";
}

?>

</tbody>
</table>
