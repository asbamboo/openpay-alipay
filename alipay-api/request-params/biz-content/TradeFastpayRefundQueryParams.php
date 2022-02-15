<?php
namespace asbamboo\openpayAlipay\alipayApi\requestParams\bizContent;

use asbamboo\openpayAlipay\alipayApi\requestParams\BizContentInterface;
use asbamboo\openpayAlipay\alipayApi\requestParams\MappingDataTrait;

/**
 * alipay.trade.fastpay.refund.query(统一收单交易退款查询) 请求参数
 *
 * @see https://docs.open.alipay.com/api_1/alipay.trade.fastpay.refund.query/
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月5日
 */
class TradeFastpayRefundQueryParams implements BizContentInterface
{
    use MappingDataTrait;
    
    /**
     * 特殊可选 支付宝交易号，和商户订单号不能同时为空
     *
     * @var string(64)
     */
    public $trade_no;
    
    /**
     * 特殊可选 订单支付时传入的商户订单号,不能和 trade_no同时为空。
     *
     * @var string(64)
     */
    public $out_trade_no;
    
    /**
     * 可选 标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
     *
     * @var string(64)
     */
    public $out_request_no;
    
    /**
     * 银行间联模式下有用，其它场景请不要使用； 双联通过该参数指定需要退款的交易所属收单机构的pid;
     *
     * @var string(16)
     */
    public $org_pid;
}
