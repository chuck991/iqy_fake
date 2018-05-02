# iqy_fake
fake iqy
网站前台包含：
	1.首页
	2.列表页
	3.视频播放页
	4.页面搜索
网站后台包含：
	1.登陆及退出登陆功能
	2.管理员管理
	3.权限管理
	4.系统设置
	5.标签管理
	6.影片管理
开发环境及工具
	phpstudy/sublime/navicat/thinkphp5
# 项目使用说明
1.修改posts文件，指定域名
2.添加apache虚拟主机，根目录定位至public路径
3.创建数据库并执行sql语句
4.修改 /application/database.php 指定mysql账户和数据库名
5.默认首页为前台（时间关系暂时还不完善）
	影片列表页相对完善
6.后台登录路口：具体域名/admin/account/login
	系统管理员：admin => 123456