服务器端 Bootstrap
===============================
* [Dashboard 后台(backend/)](./backend)
* [手机端/app (m/)](./m)
* [pc站(/frontend)](./frontend)
* [api (/api)](./api)

用到的工具与开发环境
-------------------------------
* [Ubuntu14.04 64位](http://www.ubuntu.com/server)
    * 你懂
* Apache2
    * 不用解释
* [php5.5.9](http://php.net/)
    * 有namespace 新特性的php
* [Mysql5.6.19](https://www.mysql.com/)
    * 我们mysql用到了5.6的新特性，所以不要试图用5.6以下版本
* [composer](https://getcomposer.org/)
    * 第三方管理工具
* [Yii2](http://www.yiiframework.com/doc-2.0/) [![yii2 经典模板](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
    * 我们主要用到的框架
* [bootstrap](http://getbootstrap.com/css/)
    * 项目中bootstrap在pc端，和手机m端最初版本用了很多。
* [jQuery](https://jquery.com/)
    * 著名javascript 框架,我们尽量只用于pc端和后台管理
* [git 版本控制器与Github](https://github.com/)

部署指引
------------------------------
###安装环境
```
sudo su
apt-get install -y php5=5.5\*
apt-get install -y apache2=2.4\*
apt-get install -y php5-mysql
apt-get install -y mysql-server-5.6
apt-get install -y php5-gd
apt-get install -y php5-curl
apt-get install -y git

a2enmod rewrite
a2enmod rewrite
a2enmod proxy
a2enmod proxy_http
```

###拉取git代码
在clone代码前，请确保在github已经添加了sshkey ，如果没有添加，请[点击这里](https://github.com/settings/ssh)添加
```
cd the_path_that_you_want_save
git clone git@github.com:chongdd/miduoduo.git
cd miduoduo
```

###安装php第三方库
```
cd www/
php ../bin/composer.phar global require "fxp/composer-asset-plugin:~1.0.0"
php ../bin/composer.phar install
cd ..
```

###初始化项目
```
cd www/
./init
cd ..
```
这里需要你自己设置相关 **-local.php的文件，比如数据库连接等等



###创建数据库并导入mysql数据
* 创建数据库
```
mysql -u your-mysql-username -p
$mysql> create database the-database-name-you-want default character set utf8 default collate utf8_general_ci;
$mysql> exit;
```

* 导入数据
```
cd www
./yii migrate --migrationPath=@yii/rbac/migrations
#这里初始化角色
./yii auth-manager/init

./yii migrate

```

###运行起测试环境
```
cd www/
./test_web
```
恭喜！你看到这里就可以在浏览器输入对应的网址来运行项目了
对应网址的映射如下：
```
http://ip:9999  >  m/web/ 
http://ip:9998  >  frontend/web/ 
http://ip:9997  >  backend/web/ 
http://ip:9996  >  api/web/ 
```


### 设置apache(手机端app的html5f反向代理)
```
vi /etc/apache2/sites-available/000-default.conf

#添加如下类似设置(自己hosts里随便填些测试域名)
<VirtualHost *:80>
     ServerName chongdd.cn
     ServerAdmin admin@chongdd.com
     ServerAlias *.origin.test.chongdd.cn
     RewriteEngine On

     RewriteCond %{HTTP_HOST} ^(.*)\.origin\.test\.chongdd\.cn$
     RewriteRule ^(.*)$ http://127.0.0.1:9999/origin/%1$1 [L,P]
     ProxyPassReverse  / http://127.0.0.1:9999/origin/%1/
</VirtualHost>

#重load apache
sduo service apache2 reload

# 访问一下http://h5v1.origin.test.chongdd.cn看是否能打开
```


代码结构
===============================

```
www                          Yii2经典模板结构
    common
        config/              共享 configurations
        mail/                e-mails 模板
        models/              共享models
    console
        config/              contains console configurations
        controllers/         contains console controllers (commands)
        migrations/          contains database migrations
        models/              contains console-specific model classes
        runtime/             contains files generated during runtime
    backend                  dashboard 后台管理代码
        assets/              contains application assets such as JavaScript and CSS
        config/              contains backend configurations
        controllers/         contains Web controller classes
        models/              contains backend-specific model classes
        runtime/             contains files generated during runtime
        views/               contains view files for the Web application
        web/                 contains the entry script and Web resources
    frontend                 m端代码
        assets/              contains application assets such as JavaScript and CSS
        config/              contains frontend configurations
        controllers/         contains Web controller classes
        models/              contains frontend-specific model classes
        runtime/             contains files generated during runtime
        views/               contains view files for the Web application
        web/                 contains the entry script and Web resources
        widgets/             contains frontend widgets
    m                        m端代码(包含App嵌入的html)
        assets/              contains application assets such as JavaScript and CSS
        config/              contains m configurations
        controllers/         contains Web controller classes
        models/              contains m-specific model classes
        runtime/             contains files generated during runtime
        views/               contains view files for the Web application
        web                  contains the entry script and Web resources
            origin/          手机app运行的所有代码
        widgets/             contains m widgets
    api                      api 模块
        common
            models           api内共用到的models
        config               api configurations
        modules              不同api的版本都在此
            v*               版本 如v1
                controllers  v* 的controllers
                models       v* 的特殊models
                Module.php   
    vendor/                  contains dependent 3rd-party packages
    environments/            contains environment-based overrides
    tests                    contains various tests for the advanced application
        codeception/         contains tests developed with Codeception PHP Testing Framework
```

数据结构图
===============================
![alt tag](http://7xjr6t.com1.z0.glb.clouddn.com/sql-struct.png)

