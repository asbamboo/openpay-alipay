<?php
namespace asbamboo\openpayAlipay\alipayApi\requestParams\bizContent;

use asbamboo\openpayAlipay\alipayApi\requestParams\BizContentInterface;
use asbamboo\openpayAlipay\alipayApi\requestParams\MappingDataTrait;

/**
 * alipay.trade.query(统一收单线下交易查询) 请求参数
 *
 * @see https://docs.open.alipay.com/api_1/alipay.trade.query/
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年10月27日
 */
class TradeQueryParams implements BizContentInterface
{
    use MappingDataTrait;
    
    /**
     * 订单支付时传入的商户订单号,和支付宝交易号不能同时为空。 trade_no,out_trade_no如果同时存在优先取trade_no
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
    
    /**
     * 银行间联模式下有用，其它场景请不要使用; 双联通过该参数指定需要查询的交易所属收单机构的pid;
     * 
     * @var string(16)
     */
    public $org_pid;
}
