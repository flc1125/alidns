<?php
header ("Content-Type:text/html; charset=UTF-8");
require_once __DIR__ . '/vendor/autoload.php';

// 设置系统时区
date_default_timezone_set('UTC');

use Aliyun\AliyunClient;
use Aliyun\Request\AddDomainRecord;

$dr = new AddDomainRecord();
$dr->setDomainName('que360.com');
$dr->setRR('demo111');
$dr->setType('A');
$dr->setValue('1.1.1.1');


$r = AliyunClient::execute($dr);
print_r($r);

exit;


/**
 * 初始化类
 */
class Controller
{
    /**
     * 初始化
     * @return response 
     */
    public static function init()
    {
        if (!$params = self::getParams()) {
            echo '非法操作!';
            exit;
        }


    }

    /**
     * 获取命令行工具参数
     * @return array
     */
    public static function getParams()
    {
        global $argc, $argv;
        if (!is_array($argv)) {
            return false;
        }
        unset($argv[0]);

        return array_values($argv);
    }
}

// 开始执行

// 定义全局
global $argc, $argv;

//Controller::init();