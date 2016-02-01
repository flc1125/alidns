<?php
header ("Content-Type:text/html; charset=UTF-8");
require_once __DIR__ . '/vendor/autoload.php';

// 设置系统时区
date_default_timezone_set('UTC');

use Aliyun\AliyunClient as Client;
use Aliyun\Request\AddDomainRecord;
use Aliyun\Request\DescribeDomainRecords;
use Aliyun\Request\DeleteDomainRecord;
/*
$dr = new DescribeDomainRecords();
$dr->setDomainName('que360.com');

$r = Client::execute($dr);
print_r($r);

exit;*/


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
            echo 'Illegal operation';
            exit;
        }
        if (!isset($params[0])) {
            echo 'Parameter error3';
            exit;
        }

        $action = $params[0];

        // 开始操作
        $resp = array();
        switch ($action) {
            case '-add':
                self::addDomainRecored($params);
                break;
            case '-list':
                self::listDomainRecored($params);
                break;
            case '-delete':
                self::deleteDomainRecord($params);
                break;
            default:
                echo 'Parameter error';
        }

        exit;
    }

    /**
     * 添加域名解析记录，仅适用A记录
     * @param array $params 参数
     */
    protected static function addDomainRecored($params)
    {
        $domainName = isset($params[1]) ? $params[1] : '';
        $rr         = isset($params[2]) ? $params[2] : '';
        $value      = isset($params[3]) ? $params[3] : '';

        if (!$domainName || !$rr || !$value) {
            echo 'Parameter error';
            return;
        }

        $request = new AddDomainRecord();
        $request->setDomainName($domainName)
            ->setRR($rr)
            ->setType('A')
            ->setValue($value);
        $rs =  Client::execute($request);
        
        if (!$rs || array_key_exists('Code', $rs)) {
            echo $rs['Message'] ? 'Error:'. $rs['Message'] : 'error';
            return;
        }

        echo 'success';
    }

    /**
     * 列出所有域名解析记录
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    protected static function listDomainRecored($params)
    {
        $domainName = isset($params[1]) ? $params[1] : '';
        $page       = isset($params[2]) ? intval($params[2]) : 1;
        $pageSize   = isset($params[3]) ? intval($params[3]) : 20;

        if (!$domainName) {
            echo 'domain name error';
            return;
        }

        $request = new DescribeDomainRecords();
        $request->setDomainName($domainName)
            ->setPageNumber($page)
            ->setPageSize($pageSize);
        $rs =  Client::execute($request);

        if (!$rs || array_key_exists('Code', $rs) || !$rs['DomainRecords']['Record']) {
            echo $rs['Message'] ? 'Error:'. $rs['Message'] : 'error';
            return;
        }

        // 成功输出
        echo 'Page:' . $rs['PageNumber'] . '/'. ceil($rs['TotalCount'] / $rs['PageSize']) . PHP_EOL;
        echo 'Total:' . $rs['TotalCount'] . PHP_EOL . PHP_EOL;
        echo 'RecordId  DomainName  RR  Value' . PHP_EOL;
        
        foreach ($rs['DomainRecords']['Record'] as $item) {
            echo $item['RecordId'] . '    ' . $item['DomainName'] . '   ' . $item['RR'] . '   ' . $item['Value'] . PHP_EOL;
        }
    }

    /**
     * 删除解析记录
     * @param  array $params 命令行参数
     * @return string         
     */
    protected static function deleteDomainRecord($params)
    {
        $recordId = isset($params[1]) ? $params[1] : '';

        if (!$recordId) {
            echo 'recordId error';
            return;
        }

        $request = new DeleteDomainRecord();
        $request->setRecordId($recordId);
        $rs =  Client::execute($request);

        if (!$rs || array_key_exists('Code', $rs)) {
            echo $rs['Message'] ? 'Error:'. $rs['Message'] : 'error';
            return;
        }

        echo 'success';
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

Controller::init();