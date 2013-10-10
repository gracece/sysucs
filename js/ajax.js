var pre ="index";
function loadXML(url,subject)
{
  var arr = new Array();
  arr = document.getElementsByName(pre);
  for(var i=0;i<arr.length;i++){
    var obj = document.getElementsByName(pre).item(i);
    obj.className = "nav-li";
  }
  var xmlhttp;
  var out;
  var x,i;
  xmlhttp =null;
  if(window.XMLHttpRequest)
    {
      xmlhttp =new XMLHttpRequest();
    }
    else if(window.ActiveXObject)
      {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      else
        {
          alert("抱歉，您的浏览器太高级了不支持xmlhttp");
        }
        xmlhttp.onreadystatechange =function()
        {
          if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
              document.getElementById('more').innerHTML=xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET",url+"?s="+subject+"&time="+Math.random()*1234,true);
        xmlhttp.send();
        pre =subject;

        var arr = new Array();
        arr = document.getElementsByName(pre);
        for(var i=0;i<arr.length;i++){
          var obj = document.getElementsByName(pre).item(i);
          obj.className = "active";
        }

}
function loadComment(url)
{
  var xmlhttp;
  var out;
  var x,i;
  xmlhttp =new XMLHttpRequest();
  xmlhttp.onreadystatechange =function()
  {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
      {
        document.getElementById('fileinfo').innerHTML=xmlhttp.responseText;
      }
  }

  xmlhttp.open("GET",url+"&time="+Math.random()*1234,true);
  xmlhttp.send();
}
function loadInfo(url)
{
  var xmlhttp;
  var out;
  var x,i;
  xmlhttp =new XMLHttpRequest();
  xmlhttp.onreadystatechange =function()
  {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
      {
        document.getElementById('moreinfo').innerHTML=xmlhttp.responseText;
      }
      else
        document.getElementById('moreinfo').innerHTML='<img src="img/load.gif"><img src="img/load.gif"><img src="img/load.gif"><span>其实在校园网这么快你根本不会看到加载图片=.=,看到了有奖！！</span>';
  }

  xmlhttp.open("GET",url+"&time="+Math.random()*1234,true);
  xmlhttp.send();
}

function readMessage(time)
{
  var xmlhttp;
  var out;
  var x,i;
  xmlhttp =new XMLHttpRequest();
  xmlhttp.onreadystatechange =function()
  {
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
      {
        document.getElementById(time).innerHTML=xmlhttp.responseText;
      }
  }

  xmlhttp.open("GET","../ajax/messageRead.php?time="+time,true);
  xmlhttp.send();
}


