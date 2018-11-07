<?php
namespace asbamboo\openpayAlipay\alipayApi\requestParams\bizContent;

use asbamboo\openpayAlipay\alipayApi\requestParams\BizContentInterface;
use asbamboo\openpayAlipay\alipayApi\requestParams\MappingDataTrait;

/**
 * alipay.trade.close(统一收单交易关闭接口) 请求参数
 *
 * @see https://docs.open.alipay.com/api_1/alipay.trade.close/
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月6日
 */
class TradeCloseParams implements BizContentInterface
{
    use MappingDataTrait;

    /**
     * 特殊可选 该交易在支付宝系统中的交易流水号。最短 16 位，最长 64 位。和out_trade_no不能同时为空，如果同时传了 out_trade_no和 trade_no，则以 trade_no为准。
     *
     * @var string(64)
     */
    public $out_trade_no;

    /**
     * 特殊可选 订单支付时传入的商户订单号,和支付宝交易号不能同时为空。 trade_no,out_trade_no如果同时存在优先取trade_no
     *
     * @var string(64)
     */
    public $trade_no;

    /**
     * 可选 卖家端自定义的的操作员 ID
     *
     * @var string(28)
     */
    public $operator_id;
}