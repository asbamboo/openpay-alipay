<?php
namespace asbamboo\openpayAlipay\alipayApi\requestParams\bizContent;

use asbamboo\openpayAlipay\alipayApi\requestParams\BizContentInterface;
use asbamboo\openpayAlipay\alipayApi\requestParams\MappingDataTrait;

/**
 * alipay.trade.cancel(统一收单交易撤销接口) 请求参数
 *
 * @see https://docs.open.alipay.com/api_1/alipay.trade.cancel
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月6日
 */
class TradeCancelParams implements BizContentInterface
{
    use MappingDataTrait;

    /**
     * 原支付请求的商户订单号,和支付宝交易号不能同时为空
     *
     * @var string(64)
     */
    public $out_trade_no;

    /**
     * 支付宝交易号，和商户订单号不能同时为空
     *
     * @var string(64)
     */
    public $trade_no;
}