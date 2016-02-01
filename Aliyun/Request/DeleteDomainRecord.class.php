<?php
/**
 * 删除解析记录
 *
 * 根据传入参数删除解析记录。
 *
 * @link https://help.aliyun.com/document_detail/dns/api-reference/record-related/DeleteDomainRecord.html?spm=5176.docdns/api-reference/call-method/common-parameters.6.153.fdXWo3
 * 
 * @author Flc <2016-02-01 14:53:20>
 * @link http://flc.ren 
 */
namespace Aliyun\Request;

class DeleteDomainRecord
{

    /**
     * API请求参数
     * @var array
     */
    protected $params = array(
        'Action' => 'DeleteDomainRecord',
    ); 

    /**
     * 设置解析记录的ID，此参数在添加解析时会返回，在获取域名解析列表时会返回
     * @param string $value 域名名称
     */
    public function setRecordId($value)
    {
        $this->params['RecordId'] = $value;
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