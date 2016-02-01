### PHP命令行解析DNS

----

#### 配置说明

- 修改`/Aliyun/AliyunClient.class.php`的`$accessKeyId`及`$accessKeySecret`参数即可

#### 使用方法

##### 新增域名解析记录（目前只限制A记录）

- 格式：`php flc -add [域名] [主机记录] [IP]`

- 范例：`php flc -add baidu.com www 1.1.1.1`

##### 查看域名解析记录列表

- 格式：`php flc -list [域名] [当前页] [每页数量]`；

    - `[当前页]`默认为1; `[每页数量]`默认为20
    - `[主机记录]`若为空，则使用`@`代替

- 范例：`php flc -list baidu.com 1 10`

##### 删除域名解析记录

- 格式：`php flc -delete [recordId]`

    - `[recordId]`可通过查看列表获取

- 范例：`php flc -delete 76203127`


##### 修改域名解析记录（目前只限制A记录）

- 格式：`php flc -update [recordId] [主机记录] [IP]`
    
    - `[recordId]`可通过查看列表获取
    - `[主机记录]`若为空，则使用`@`代替

- 范例：`php flc -update 76203127 www 1.1.1.1`

