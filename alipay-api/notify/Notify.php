<?php
namespace asbamboo\openpayAlipay\alipayApi\notify;

use asbamboo\http\ServerRequestInterface;
use asbamboo\openpayAlipay\exception\OpenpayAlipayException;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayAlipay\Env;

/**
 * 支付宝推送消息的处理
 *  - 验证是否时合法的推送消息
 *  - 将推送消息序列化成 NotifyResponse
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月31日
 */
class Notify implements NotifyInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\notify\NotifyInterface::exec()
     */
    public function exec(ServerRequestInterface $Request) : NotifyResponse
    {
        if($this->check($Request) !== 1 ){
            throw new OpenpayAlipayException('非法 notify 请求.');
        }
        $NotifyResponse                 = new NotifyResponse();
        $NotifyResponse->out_trade_no   = $Request->getPostParam('out_trade_no');
        $NotifyResponse->trade_no       = $Request->getPostParam('trade_no');
        $NotifyResponse->trade_status   = $Request->getPostParam('trade_status');
        $NotifyResponse->notify_data    = $Request->getRequestParams();
        return $NotifyResponse;
    }

    /**
     *
     * @param ServerRequestInterface $Request
     */
    private function check(ServerRequestInterface $Request) : void
    {
        $sign_str   = $this->getSignString($Request);
        $sign       = $Request->getPostParam('sign');
        return $this->verifySign($sign_str, $sign); 
    }
    
    /**
     * 验证签名
     * 如果返回 1 表示验证通过
     *
     * @see http://php.net/manual/zh/function.openssl-verify.php
     * @param string $sign_source
     * @param string $sign
     * @return int
     */
    private function verifySign($sign_source, $sign) : int
    {
        $public_pem     = EnvHelper::get(Env::ALIPAY_RSA_ALIPAY_KEY);
        if(is_file($public_pem)){
            $public_pem    = 'file://' . $public_pem;
        }
        $sign   = base64_decode($sign);
        $ssl    = openssl_get_publickey($public_pem);
        $verify = openssl_verify($sign_source, $sign, $ssl, OPENSSL_ALGO_SHA256);
        openssl_free_key($ssl);
        
        return $verify;
    }
    /**
     * 返回签名使用的字符串
     *
     * @return string
     */
    private function getSignString(ServerRequestInterface $Request) : string
    {
        $sign_data  = [];
        $data       = array_merge($Request->getPostParams(), $Request->getQueryParams());
        ksort($data);
        foreach($data AS $key => $value){
            if($this->checkIsSignKey($key)){
                $sign_data[]    = "{$key}={$value}";
            }
        }
        return implode('&', $sign_data);
    }
    
    /**
     * 判断一个本实例的一个属性，是不是应该当做签名字符串的一部分。
     *
     *  - sign字段不是签名字符串
     *  - self::checkIsEmpty 不是签名字符串
     *  - 上传文件字段 不是签名字符串
     *
     * @param string $key 本实例的键名
     * @return bool
     */
    private function checkIsSignKey($key) : bool
    {
        if($key != 'sign' && $key != 'sign_type' && $this->checkIsEmpty($this->{$key}) == false && "@" != substr($this->{$key}, 0, 1)){
            return true;
        }
        return false;
    }
    
    /**
     * 判断一个参数的值是否是空
     *
     * 下列情况返回true
     *  - 空字符串|trim($value) === ''
     *  - null值|$value === null
     *  - 未定义|!isset($value)
     *
     * @param mixed $value
     * @return bool
     */
    private function checkIsEmpty($value) : bool
    {
        if(!isset($value)){
            return true;
        }
        
        if($value === null){
            return true;
        }
        
        if(trim($value) === ""){
            return true;
        }
        
        return false;
    }
}