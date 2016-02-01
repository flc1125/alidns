### PHP命令行解析DNS

----

#### 新增域名解析记录（目前只限制A记录）

- 格式：`php index.php -add [域名] [主机记录] [IP]`

- 范例：`php index.php -add que360.com www 1.1.1.1`

#### 查看域名解析记录列表

- 格式：`php index.php -list [域名] [当前页] [每页数量]`；

    - `[当前页]`默认为1; `[每页数量]`默认为20
    - `[主机记录]`若为空，则使用`@`代替

- 范例：`php index.php -list que360.com 1 10`

#### 删除域名解析记录

- 格式：`php index.php -delete [recordId]`

    - `[recordId]`可通过查看列表获取

- 范例：`php index.php -delete 76203127`


#### 修改域名解析记录（目前只限制A记录）

- 格式：`php index.php -update [recordId] [主机记录] [IP]`
    
    - `[recordId]`可通过查看列表获取
    - `[主机记录]`若为空，则使用`@`代替

- 范例：`php index.php -update www 1.1.1.1`

