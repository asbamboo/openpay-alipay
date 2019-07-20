<?php
namespace asbamboo\openpayAlipay\alipayApi\response;

/**
 * alipay.trade.precreate(统一收单线下交易预创建)响应结果
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月12日
 */
class TradeCreateResponse extends ResponseAbstract
{
    /**
     * 必填 最大长度 64
     * 商户的订单号
     *
     * @var string
     */
    protected $out_trade_no;

    /**
     * 支付宝交易号
     *
     * @var string
     */
    protected $trade_no;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\response\ResponseAbstract::getResponseRootNode()
     */
    final protected function getResponseRootNode() : string
    {
        return 'alipay_trade_create_response';
    }
}
