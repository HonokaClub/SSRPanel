自改存档
# 前端部署
## 环境要求
````
PHP 7.1 （必须）
MYSQL 5.5 （推荐5.6+）
内存 1G+ 
磁盘空间 10G+
PHP必须开启curl、gd、fileinfo、openssl、mbstring组件
安装完成后记得编辑config/app.php中 'debug' => true, 改为 false
````

#### 安装
````
php composer.phar install
php artisan key:generate
chown -R www:www storage/
chmod -R 777 storage/
chown www * -R
````

###### 迁移(创建表结构)
````
php artisan migrate
````

###### 播种(填充数据)
````
php artisan db:seed --class=ConfigTableSeeder
php artisan db:seed --class=CountryTableSeeder
php artisan db:seed --class=LevelTableSeeder
php artisan db:seed --class=SsConfigTableSeeder
php artisan db:seed --class=UserTableSeeder
````

##### 手动部署
````
若自动部署报错请手动导入 sql/db.sql
````

#### 伪静态
````
location / {
    try_files $uri $uri/ /index.php$is_args$args;
}
````

#### php 函数
````
找到php.ini
vim /usr/local/php/etc/php.ini

搜索disable_function
删除proc_开头的所有函数
````

## 定时任务
````
* * * * * php /home/wwwroot/SSRPanel/artisan schedule:run >> /dev/null 2>&1

注意运行权限，必须跟ssrpanel项目权限一致，否则出现无权限报错：
例如用lnmp的话默认权限用户组是 www:www，则添加定时任务是这样的: crontab -e -u www
````

## 邮件配置
###### SMTP
````
编辑 config\mail.php

请自行配置如下内容
'driver' => 'smtp',
'host' => 'smtp.exmail.qq.com',
'port' => 465,
'from' => [
    'address' => 'xxx@qq.com',
    'name' => 'HC',
],
'encryption' => 'ssl',
'username' => 'xxx@qq.com',
'password' => 'xxxxxx',
````

###### Mailgun
````
编辑 config\mail.php
将 driver 值改为 mailgun

编辑 config/services.php

请自行配置如下内容
'mailgun' => [
    'domain' => 'mailgun发件域名',
    'secret' => 'mailgun上申请到的secret',
],
````

###### 发邮件失败处理
````
如果使用了逗比的ban_iptables.sh来防止用户发垃圾邮件
可能会导致出现 Connection could not be established with host smtp.exmail.qq.com [Connection timed out #110] 这样的错误
因为smtp发邮件必须用到25,26,465,587这四个端口，逗比的一键脚本会将这些端口一并封禁
可以编辑iptables，注释掉以下这段（前面加个#号就可以），然后保存并重启iptables
#-A OUTPUT -p tcp -m multiport --dports 25,26,465,587 -m state --state NEW,ESTABLISHED -j REJECT --reject-with icmp-port-unreachable
````

## 英文版
````
修改 config/app.php 下的 locale 值为 en
欢迎提交其他语言的语言包，语言包在：resources/lang下
````


## 后端部署
###### RR
````
git clone https://github.com/ssrpanel/shadowsocksr.git
cd shadowsocksr
sh initcfg.sh
./setup_cymysql2.sh
配置 usermysql.json. 确保数据对应
````

###### 一键 R
````
wget -N --no-check-certificate https://raw.githubusercontent.com/ssrpanel/ssrpanel/master/server/deploy_ssr.sh;chmod +x deploy_ssr.sh;./deploy_ssr.sh


wget -N --no-check-certificate https://raw.githubusercontent.com/maxzh0916/Shadowsowcks1Click/master/Shadowsowcks1Click.sh;chmod +x Shadowsowcks1Click.sh;./Shadowsowcks1Click.sh
````

## 更新代码
````
如果每次更新都会出现数据库文件被覆盖，请先执行一次：
chmod a+x fix_git.sh && sh fix_git.sh

如果本地自行改了文件，想用回原版代码，请先备份好 config/database.php，然后执行以下命令：
chmod a+x update.sh && sh update.sh

如果更新完代码各种错误，请先执行一遍 php composer.phar install
````

## 网卡流量监控一键脚本（Vnstat）
````
wget -N --no-check-certificate https://raw.githubusercontent.com/ssrpanel/ssrpanel/master/server/deploy_vnstat.sh;chmod +x deploy_vnstat.sh;./deploy_vnstat.sh
````

## 单端口多用户（推荐）
````
编辑节点的 user-config.json 文件：
vim user-config.json

将 "additional_ports" : {}, 改为以下内容：
"additional_ports" : {
    "80": {
        "passwd": "统一认证密码", // 例如 SSRP4ne1，推荐不要出现除大小写字母数字以外的任何字符
        "method": "统一认证加密方式", // 例如 aes-128-ctr
        "protocol": "统一认证协议", // 可选值：orgin、verify_deflate、auth_sha1_v4、auth_aes128_md5、auth_aes128_sha1、auth_chain_a
        "protocol_param": "#", // #号前面带上数字，则可以限制在线每个用户的最多在线设备数，仅限 auth_chain_a 协议下有效，例如： 3# 表示限制最多3个设备在线
        "obfs": "tls1.2_ticket_auth", // 可选值：plain、http_simple、http_post、random_head、tls1.2_ticket_auth
        "obfs_param": ""
    },
    "443": {
        "passwd": "统一认证密码",
        "method": "统一认证加密方式",
        "protocol": "统一认证协议",
        "protocol_param": "#",
        "obfs": "tls1.2_ticket_auth",
        "obfs_param": ""
    }
},

保存，然后重启SSR服务。
客户端设置：

远程端口：80
密码：password
加密方式：aes-128-ctr
协议：auth_aes128_md5
混淆插件：tls1.2_ticket_auth
协议参数：1026:@123 (SSR端口:SSR密码)

或

远程端口：443
密码：password
加密方式：aes-128-ctr
协议：auth_aes128_sha1
混淆插件：tls1.2_ticket_auth
协议参数：1026:SSRP4ne1 (SSR端口:SSR密码)

经实测，节点后端使用auth_sha1_v4_compatible，可以兼容auth_chain_a
注意：如果想强制所有账号都走80、443这样自定义的端口的话，记得把 user-config.json 中的 additional_ports_only 设置为 true
警告：经实测单端口下如果用锐速没有效果，很可能是VPS供应商限制了这两个端口
提示：配置单端口最好先看下这个WIKI，防止才踩坑：https://github.com/ssrpanel/ssrpanel/wiki/%E5%8D%95%E7%AB%AF%E5%8F%A3%E5%A4%9A%E7%94%A8%E6%88%B7%E7%9A%84%E5%9D%91

````

## 校时
````
如果架构是“面板机-数据库机-多节点机”，请务必保持各个服务器之间的时间一致，否则会产生：节点的在线数不准确、最后使用时间异常、单端口多用户功能失效等。
推荐统一使用CST时间并安装校时服务：
vim /etc/sysconfig/clock 把值改为 Asia/Shanghai
cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime

重启一下服务器，然后：
yum install ntp
ntpdate cn.pool.ntp.org
````

