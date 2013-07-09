<?php
require('../functions.php');
require('../auth_head.php');
html_header("计科一班--辉宇蛋蛋店");
$user = $_SESSION['user'];
?>
<div style="padding: 0px 0px 50px; margin: 0px; border-width: 0px; height: 0px; display: block;" id="yass_top_edge_padding"></div>
  <div class="navbar  navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="../">SYSUCS.ORG</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php">个人中心</a></li>
              <li><a href="message.php">消息</a></li>
              <li><a href="rank.php">排行榜</a></li>
              <li><a href="../mission.php">签到</a></li>
              <li class="active"><a href="#">辉宇蛋蛋店</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="container" >

<?php
if ($user=="湛江下暴雨" )
{
    echo "<h3>订单管理</h3>";
    $dbc = newDbc();
    $query = "select sum(num) from dandan where status<3 order by time desc";
    $result = mysqli_query($dbc,$query);
    $row =mysqli_fetch_array($result);
    echo  "<div class='alert alert-info'>今日还有<big>".$row[0]."</big>个未完成.</div>";
    $query = "select * from dandan order by time desc";
    $result = mysqli_query($dbc,$query);
    if($result->num_rows == 0)
        echo"您还未下过订单！";
    else
    {
        echo "
            <table class=\"table table-striped table-bordered\">
            <thead>
            <tr>
            <td width='80px'>时间</td>
            <td>客户</td>
            <td>数量</td>
            <td>地址</td>
            <td>备注</td>
            <td width='80px'>状态</td>
            <td>操作</td>
            </tr>
            </thead>
            <tbody>            ";
        for($i=0;$i<$result->num_rows;$i++)
        {
            $row = mysqli_fetch_array($result);
         echo "<tr class='";
                 switch($row['status'])
                 {
                 case 1:
                     echo "warning";
                     break;
                 case 2:
                     echo "info";
                     break;
                 case 3:
                     echo "success";
                     break;
                 case 4:
                     echo "error";
                     break;
                 }
           echo "'> <td>". date("m/d H:i",$row['time']);
            echo "</td><td>".$row['user'];
            echo "</td><td>".$row['num'];
            echo "</td><td>".$row['addr'];
            echo "</td><td>".$row['remark'];
            echo "</td><td>";
            switch($row['status'])
            {
            case 1:
                echo "已下单";
                break;
            case 2:
                echo "辉宇已确认";
                break;
            case 3:
                echo "订单完成";
                break;
            case 4:
                echo "订单被取消";
               break;
            }
            echo "</td>";
            echo "<td>
                <form style='display:inline' action='dandan_book.php' method='post'>
                <input name='time' type='hidden' value=".$row['time']." />
                <input name='type' type='hidden' value='up' />
                <input type='submit' class='btn' value='提升' />
                </form></td><td>
                 <form style='display:inline' action='dandan_book.php' method='post'>
                <input name='time' type='hidden' value=".$row['time']." />
                <input name='type' type='hidden' value='cancel' />
                <div class='input-append' style='margin-bottom:0px'>
                <input  name='reason' id='appendedInputButton'  class='span2' type='text' value='无' />
                <input type='submit' class='btn btn-danger' value='取消' />
                </div>
                </form>

                </td> ";
        }
        echo " </tbody>
            </table> ";


    }


}
else
{
?>
<div class="alert alert-info">
蛋蛋的忧桑从今天(6.22)开始就停止营业了，感谢各位人类们的光顾，建森不会忘记你们的。从今天开始蛋蛋店正式更名为零钱店，从事各种免费找零钱找硬币工作，请大家继续光顾。。直接qq找我就行
</div>
<div class="alert alert-info">
辉宇蛋蛋店正式上线!花 <code>3</code>个计科币预定，交易成功即可获得<code>5</code>计科币返还！ 
</div>
<div class="row">
<div class="span7">
<h3>我的订单</h3>
<?php 
    $dbc = newDbc();
    $query = "select * from dandan where user ='".$user."' order by time desc";
    $result = mysqli_query($dbc,$query);
    if($result->num_rows == 0)
        echo"<h4>您还未下过订单！</h4>";
    else
    {
        echo "
            <table class=\"table table-striped table-bordered\">
            <thead>
            <tr>
            <td>时间</td>
            <td>数量</td>
            <td>地址</td>
            <td>备注</td>
            <td>状态</td>
            </tr>
            </thead>
            <tbody>            ";
        for($i=0;$i<$result->num_rows;$i++)
        {
            $row = mysqli_fetch_array($result);
            echo "<tr class='";
                 switch($row['status'])
                 {
                 case 1:
                     echo "warning";
                     break;
                 case 2:
                     echo "info";
                     break;
                 case 3:
                     echo "success";
                     break;
                 case 4:
                     echo "error";
                     break;
                 }
           echo "'><td>". date("m/d H:i",$row['time']);
            echo "</td><td>".$row['num'];
            echo "</td><td>".$row['addr'];
            echo "</td><td>".$row['remark'];
            echo "</td><td>";
                 switch($row['status'])
            {
            case 1:
                echo "已下单";
                break;
            case 2:
                echo "辉宇已确认";
                break;
            case 3:
                echo "订单完成";
                break;
            case 4:
                echo "订单被取消";
               break;
            }

                echo "</td>";
        }
        echo " </tbody>
            </table> ";


    }

?>
</div>

<div class="span5">
<h3>现在预定！</h3>
<form method="post" action="dandan_book.php">
    <div class="control-group">
        <label class="control-label">数量</label>
        <div class="controls">
<input  name="num" type="number" value="1" />
        </div>
      </div>
<div class="control-group">
        <label class="control-label" >宿舍</label>
        <div class="controls">
<input  name="addr" type="text" />
        </div>
      </div>
<div class="control-group">
        <label class="control-label" >备注</label>
        <div class="controls">
<input value="无" name="remark" type="text" />
        </div>
      </div>

        <label class="control-label" ></label>
        <div class="controls">
<input type="submit" class="btn btn-primary" value="预定！" />
        </div>
      </div>





</form>
</div>
</div>
<?php 
}
?>
</div>


