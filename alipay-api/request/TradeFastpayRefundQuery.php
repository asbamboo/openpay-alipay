<?php
namespace asbamboo\openpayAlipay\alipayApi\request;

use asbamboo\openpayAlipay\alipayApi\request\tool\BodyTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\UriTrait;
use asbamboo\openpayAlipay\alipayApi\request\tool\CreateRequestTrait;
use asbamboo\openpayAlipay\alipayApi\gateway\GatewayUriTrait;
use asbamboo\openpayAlipay\alipayApi\requestParams\CommonParams;
use asbamboo\openpayAlipay\alipayApi\requestParams\bizContent\TradeFastpayRefundQueryParams;

/**
 * alipay.trade.fastpay.refund.query(统一收单交易退款查询)
 * 商户可使用该接口查询自已通过alipay.trade.refund或alipay.trade.refund.apply提交的退款请求是否执行成功。 
 * 该接口的返回码10000，仅代表本次查询操作成功，不代表退款成功。如果该接口返回了查询数据，且refund_status为空或为REFUND_SUCCESS，则代表退款成功，
 * 如果没有查询到则代表未退款成功，可以调用退款接口进行重试。重试时请务必保证退款请求号一致。
 * 
 * @see https://docs.open.alipay.com/api_1/alipay.trade.fastpay.refund.query/
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月5日
 */
class TradeFastpayRefundQuery implements RequestInterface
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
    const METHOD    = 'alipay.trade.fastpay.refund.query';
    
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
        $BizContent     = new TradeFastpayRefundQueryParams();
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
