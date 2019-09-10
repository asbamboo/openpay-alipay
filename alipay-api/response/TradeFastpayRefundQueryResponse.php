<?php
namespace asbamboo\openpayAlipay\alipayApi\response;

/**
 * alipay.trade.fastpay.refund.query(统一收单交易退款查询) 响应结果
 * 
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月5日
 */
class TradeFastpayRefundQueryResponse extends ResponseAbstract
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
     * 选填	本笔退款对应的退款请求号	
     * 
     * @var string(64)
     */
    public $out_request_no;
    
    /**
     * 选填 发起退款时，传入的退款原因	
     * @var string(256)
     */
    public $refund_reason;
    
    /**
     * 选填	该笔退款所对应的交易的订单金额	
     * @var Price(11)
     */
    public $total_amount;
    
    /**
     * 选填	本次退款请求，对应的退款金额	
     * @var Price(11)
     */
    public $refund_amount;
    
    /**
     * 选填	退分账明细信息	
     * @var RefundRoyaltyResult()
     */
    public $refund_royaltys;

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
     * 选填	本次商户实际退回金额；默认不返回该信息，需与支付宝约定后配置返回；
     * @var string(11)
     */
    public $send_back_fee;

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
        return 'alipay_trade_fastpay_refund_query_response';
    }
}