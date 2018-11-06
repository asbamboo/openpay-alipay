<?php
namespace asbamboo\openpayAlipay\alipayApi\response;

/**
 * alipay.trade.close(统一收单交易关闭接口)
 *
 * @see https://docs.open.alipay.com/api_1/alipay.trade.close/
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月6日
 */
class TradeCloseResponse extends ResponseAbstract
{
    /**
     * 必填 支付宝交易号
     *
     * @var string(64)
     */
    protected $trade_no;

    /**
     * 必填 商户订单号
     *
     * @var string(64)
     */
    protected $out_trade_no;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\response\ResponseAbstract::getResponseRootNode()
     */
    final protected function getResponseRootNode() : string
    {
        return 'alipay_trade_close_response';
    }
}