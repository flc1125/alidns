<?php
/**
 * API请求公共类
 * 
 * @author Flc <2016-02-01 14:53:20>
 * @link http://flc.ren 
 */
namespace Aliyun;

class AliyunClient
{
    /**
     * 访问者的身份ID
     * @var string
     */
    protected static $accessKeyId = 'rtfoKshq1JkVd5HA';

    /**
     * 密钥
     * @var string
     */
    protected static $accessKeySecret = 'tB9iS7jqfFRm2m0nQHov1lyCjTwX5E';

    /**
     * DNS API的服务接入地址
     * @var string
     */
    protected static $dnsURI = 'http://dns.aliyuncs.com';

    /**
     * 执行请求API
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public static function execute($request){
        $url    = self::$dnsURI;
        $params = array_merge(self::getPublicParams(), $request->getParams());
        $params['Signature'] = self::sign($params);

        $json =  self::http_gets($url, $params);

        if (!$json)
            return false;

        $result = json_decode($json, true);
        if (!$result || !is_array($result))
            return false;

        return $result;
    }

    /**
     * 转换编码
     * @param  string $str 
     * @return string      
     */
    protected static function percentEncode($str)
    {
        // 使用urlencode编码后，将"+","*","%7E"做替换即满足 API规定的编码规范
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }

    /**
     * 生成签名
     * @param  array $params 参数
     * @return string            
     */
    public static function sign($params){
        // 将参数Key按字典顺序排序
        ksort($params);
    
        // 生成规范化请求字符串
        $string = '';
        foreach($params as $key => $value)
        {
        $string .= '&' . self::percentEncode($key) 
            . '=' . self::percentEncode($value);
        }
    
        // 生成用于计算签名的字符串 stringToSign
        $stringToSign = 'GET&%2F&' . self::percentEncode(substr($string, 1));
    
        // 计算签名，注意accessKeySecret后面要加上字符'&'
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, self::$accessKeySecret . '&', true));
        return $signature;
    }

    /**
     * 获取随机数
     * @param  integer $length 随机数长度
     * @return string          
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        } 
        return $str;
    }

    /**
     * API请求公共参数
     * @return [type] [description]
     */
    public static function getPublicParams()
    {
        return array(
            'Format'           => 'json',
            'Version'          => '2015-01-09',
            'AccessKeyId'      => self::$accessKeyId,
            'SignatureMethod'  => 'HMAC-SHA1',
            'Timestamp'        => date("Y-m-d\TH:i:s\Z"),
            'SignatureVersion' => '1.0',
            'SignatureNonce'   => self::getNonceStr()
        );
    }

    /**
     * 服务器通过get请求获得内容
     * @param  string $baseURL 基础URL
     * @param  array $keysArr 请求参数
     * @return string          [description]
     */
    public static function http_gets($baseURL, $keysArr){
        $url = self::combineURL($baseURL, $keysArr);

        $ch = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($ch);
        $aStatus = curl_getinfo($ch);
        curl_close($ch);
        return $sContent;
    }

    /**
     * combineURL
     * 拼接url
     * @param string $baseURL   基于的url
     * @param array  $keysArr   参数列表数组
     * @return string           返回拼接的url
     */
    public static function combineURL($baseURL, $keysArr){
        if(empty($keysArr) || !is_array($keysArr)) return $baseURL;
        
        $combined = $baseURL."?";
        $valueArr = array();
        foreach($keysArr as $key => $val){
            $valueArr[] = "$key=".urlencode($val);
        }
        $keyStr = implode("&",$valueArr);
        $combined .= ($keyStr);
        return $combined;
    }
}