<?php
namespace asbamboo\openpayAlipay\alipayApi\request;

use asbamboo\openpayAlipay\alipayApi\gateway\GatewayUriTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\BodyTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\UriTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\CreateRequestTrait;
use asbamboo\openpayAlipay\alipayApi\requestParams\bizContent\TradeQueryParams;
use asbamboo\openpayAlipay\alipayApi\requestParams\CommonParams;

/**
 * alipay.trade.query(统一收单线下交易查询)
 * 
 * 该接口提供所有支付宝支付订单的查询，商户可以通过该接口主动查询订单状态，完成下一步的业务逻辑。 
 * 需要调用查询接口的情况： 
 *  - 当商户后台、网络、服务器等出现异常，商户系统最终未接收到支付通知； 
 *  - 调用支付接口后，返回系统错误或未知交易状态情况； 
 *  - 调用alipay.trade.pay，返回INPROCESS的状态； 
 *  - 调用alipay.trade.cancel之前，需确认支付状态；
 * 
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年10月27日
 */
class TradeQuery implements RequestInterface
{
    use GatewayUriTrait;
    use BodyTrait;
    use UriTrait;
    use CreateRequestTrait;
    
    
    /**
     * 接口请求的method参数的固定值
     *
     * @var string
     */
    const METHOD    = 'alipay.trade.query';
    
    /**
     * 指派参数的数据集合
     *
     * @var array
     */
    private $assign_data;
    
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\request\RequestInterface::assignData()
     */
    public function assignData(array $assign_data): RequestInterface
    {
        $BizContent     = new TradeQueryParams();
        $CommonParams   = new CommonParams();
        
        $BizContent->mappingData($assign_data);
        $CommonParams->mappingData($assign_data);
        $CommonParams->setBizContent($BizContent);
        
        $CommonParams->method   = self::METHOD;
        $CommonParams->sign     = $CommonParams->makeSign();
        $this->assign_data      = get_object_vars($CommonParams);
        
        return $this;
    }
}