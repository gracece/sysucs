关于SYSUCS
=========

### 初衷

一开始是想给班级寻求一种 QQ群共享资源 的替代品，本想在SAE 用现成的论坛来实现，但是速度太慢而且使用效果不佳，太多冗余的东西了。
最初的idea来自 [Gavin](https://github.com/gavinhub) ,在SAE上实现了最基本的资源上传、分类、下载。再后来，[saucebing](https://github.com/saucebing)提供了局域网内的服务器，Gavin 把代码移植到本地，后面的版本都是基于这一个框架来扩展,同时gavin也一起完成了大量代码工程。在此对以上两位表示感谢。
另外一些问题说明可移步 [my blog] (http://gracece.net/2013/06/sysucs-rework/)

### 基本功能
- 用户注册与登陆
- 资源上传、下载
- 通知发布
- 后台管理（基本功能已完成）
- 资源评论
- 社区金钱系统
- 每日签到
- 简单的消息通知
- 迷你论坛

### 界面预览
![sysucs](http://ww3.sinaimg.cn/large/50b560a5gw1e5smmdwahlj211y0lcn28.jpg)

### 遗留问题

- 有些设置的更改没有在php代码提供，直接暴力改数据库。
- 有些设置直接写在了php代码里面，比如增加或者减少金币的数量。
- 某些古老浏览器上可能存在兼容性问题。
- php 与 html 混写在一起，代码比较混乱
- 没有用到类/对象，后续扩展可能比较麻烦
- 仍可能留有一些安全性漏洞。
- 没有提供上传进度提示，在上传大文件时候体验不佳。

### 使用方法

在`lamp`上运行完全没有问题，因为没有太多的依赖，所以在`lnmp` 或是 windows下应该也是能跑起来的，可能会涉及到小部分代码的更改。
	
	git clone https://github.com/gracece/sysucs.git

将代码clone到本地，并把`sample.config.php` 更名为 `config.php`。建立空的数据库，并导入 `sql/init.sql` （为了安全，导入完毕最好把该sql文件删除，不过开源了大家都看得到...)。然后在`config.php`中填好数据库名，用户名以及密码。

注册新用户名，默认第一个注册的用户为超级管理员，具有所有权限。可以通过邀请码来限制用户注册，在`reg.php`的第一行define，不喜也可删去。其他用户默认为普通用户，数据库中 `user`表中，`admin`代表为超级管理员，`addInfo`代表只有发布通知的权限，需要提升权限请直接改数据库将目标用户的对应值置为1。

在 `admin/setting.php` 可进行科目的添加以及remark的修改等，同时还可以修改首页slider的信息。 **注意** ，在添加新科目的过程中，可能由于权限问题，php代码无法新建文件夹，请手工完成并赋予可写入权限。	

另外，上传文件的大小限制请自行更改 `php.ini` 相关属性设置。

### 感谢

- bootstrap
- bootcss.com 
- chart.js
- jquery
- jquery.pin
- unslider









