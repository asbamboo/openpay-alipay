<?php
namespace asbamboo\openpayAlipay\alipayApi\response;

/**
 * alipay.trade.page.pay(统一收单下单并支付页面接口) 响应结果
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月3日
 */
class TradeAppPayResponse extends ResponseAbstract
{
    /**
     * 必填 商户订单号
     *
     * @var string(64)
     */
    protected $out_trade_no;

    /**
     * 必填 支付宝交易号
     *
     * @var string(64)
     */
    protected $trade_no;

    /**
     * 支付宝分配给开发者的应用Id
     *
     * @var string(32)
     */
    protected $app_id;

    /**
     * 必填 交易金额
     *
     * @var price(11)
     */
    protected $total_amount;

    /**
     * 必填 收款支付宝账号对应的支付宝唯一用户号。以2088开头的纯16位数字
     *
     * @var string(64)
     */
    protected $seller_id;

    /**
     * 必填 编码格式 utf-8
     *
     * @var string(16)
     */
    protected $charset;

    /**
     * 必填 时间 2016-10-11 17:43:36
     *
     * @var string(32)
     */
    protected $timestamp;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\response\ResponseAbstract::getResponseRootNode()
     */
    final protected function getResponseRootNode() : string
    {
        return 'alipay_trade_app_pay_response';
    }
}