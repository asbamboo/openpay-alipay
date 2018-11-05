<?php
namespace asbamboo\openpayAlipay\alipayApi\response;

/**
 * alipay.trade.refund(统一收单交易退款接口) 响应结果
 * 
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月5日
 */
class TradeRefundResponse extends ResponseAbstract
{
    /**
     * 必填 支付宝交易号
     * 
     * @var string(64)
     */
    public $trade_no;
    
    /**
     * 必填 商户订单号
     * 	
     * @var string(64)
     */
    public $out_trade_no;
    
    /**
     * 必填 用户的登录id
     * 	
     * @var string(100)
     */
    public $buyer_logon_id;
    
    /**
     * 必填 本次退款是否发生了资金变化
     * 
     * @var string(1)
     */
    public $fund_change;
    
    /**
     * 必填 退款总金额	
     * 
     * @var price(11)
     */
    public $refund_fee;
    
    /**
     * 选填 退款币种信息	
     * 
     * @var string(8)
     */
    public $refund_currency;
    
    /**
     * 选填 退款支付时间
     * 	
     * @var date(32)
     */
    public $gmt_refund_pay;
    
    /**
     * 选填 退款使用的资金渠道
     *  - fund_channel 必填 string(32) 交易使用的资金渠道，详见 支付渠道列表	
     *  - amount 必填 price(32) 该支付工具类型所使用的金额		
     *  - real_amount 可选 price(11) 渠道实际付款金额			
     *  - fund_type 可选 string(32) 渠道所使用的资金类型,目前只在资金渠道(fund_channel)是银行卡渠道(BANKCARD)的情况下才返回该信息(DEBIT_CARD:借记卡,CREDIT_CARD:信用卡,MIXED_CARD:借贷合一卡)			
     *  
     * @var TradeFundBill()
     */
    public $refund_detail_item_list;
    
    /**
     * 选填 交易在支付时候的门店名称	
     * 
     * @var string(512)
     */
    public $store_name;
    
    /**
     * 必填 买家在支付宝的用户id	
     * 
     * @var string(28)
     */
    public $buyer_user_id;
    
    /**
     * 选填	退回的前置资产列表	
     *  - amount 必填 price(32) 前置资产金额	
     *  - assert_type_code 必填 string(32) 前置资产类型编码，和收单支付传入的preset_pay_tool里面的类型编码保持一致。	
     *  
     * @var PresetPayToolInfo()
     */
    public $refund_preset_paytool_list;

    /**
     * 选填	本次退款针对收款方的退收费金额； 默认不返回该信息，需与支付宝约定后配置返回；
     * 
     * @var price(11)
     */
    public $refund_charge_amount;
    
    /**
     * 选填	退款清算编号，用于清算对账使用； 只在银行间联交易场景下返回该信息；
     * 
     * @var string(64)
     */
    public $refund_settlement_id;
    
    /**
     * 选填 本次退款金额中买家退款金额	
     * 
     * @var string(11)
     */
    public $present_refund_buyer_amount;
    
    /**
     * 选填 本次退款金额中平台优惠退款金额		
     * 
     * @var string(11)
     */
    public $present_refund_discount_amount;
    
    /**
     * 选填 本次退款金额中商家优惠退款金额			
     * 
     * @var string(11)
     */
    public $present_refund_mdiscount_amount;
    
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\response\ResponseAbstract::getResponseRootNode()
     */
    final protected function getResponseRootNode() : string
    {
        return 'alipay_trade_refund_response';
    }
}