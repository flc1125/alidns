<?php
/**
 * 获取解析记录列表
 *
 * 根据传入参数获取解析记录列表。
 * 查询可以指定域名（DomainName）、页码（PageNumber）和每页的数量（PageSize）来获取域名的解析列表。
 * 查询可以指定解析记录的主机记录关键字（RRKeyWord）、解析类型关键字（TypeKeyWord）或者记录值的关键字（ValueKeyWord）来查询含有该关键字的解析列表。
 * 解析列表的默认排序方式是按照解析添加的时间从新到旧排序的。
 *
 * @link https://help.aliyun.com/document_detail/dns/api-reference/record-related/DescribeDomainRecords.html?spm=5176.docdns/api-reference/record-related/DeleteDomainRecord.6.156.X6bu5q
 * 
 * @author Flc <2016-02-01 14:53:20>
 * @link http://flc.ren 
 */
namespace Aliyun\Request;

class DescribeDomainRecords
{

    /**
     * API请求参数
     * @var array
     */
    protected $params = array(
        'Action' => 'DescribeDomainRecords',
    ); 

    /**
     * 设置域名名称
     * @param string $value 域名名称
     */
    public function setDomainName($value)
    {
        $this->params['DomainName'] = $value;
        return $this;
    }

    /**
     * 设置当前页数，起始值为1，默认为1
     * @param integer $value [description]
     */
    public function setPageNumber($value = 1)
    {
        $this->params['PageNumber'] = $value;
        return $this;
    }

    /**
     * 设置分页查询时设置的每页行数，最大值500，默认为20
     * @param integer $value [description]
     */
    public function setPageSize($value = 20)
    {
        $this->params['PageSize'] = $value;
        return $this;
    }

    /**
     * 设置主机记录的关键字，按照”%RRKeyWord%”模式搜索，不区分大小写
     * @param [type] $value [description]
     */
    public function setRRKeyWord($value)
    {
        $this->params['RRKeyWord'] = $value;
        return $this;
    }

    /**
     * 设置解析类型的关键字，按照全匹配搜索，不区分大小写
     * @param [type] $value [description]
     */
    public function setTypeKeyWord($value)
    {
        $this->params['TypeKeyWord'] = $value;
        return $this;
    }

    /**
     * 设置记录值的关键字，按照”%ValueKeyWord%”模式搜索，不区分大小写
     * @param [type] $value [description]
     */
    public function setValueKeyWord($value)
    {
        $this->params['ValueKeyWord'] = $value;
        return $this;
    }

    /**
     * 返回所有参数
     * @return [type] [description]
     */
    public function getParams()
    {
        return $this->params;
    }
}