<?php
namespace asbamboo\openpayAlipay\alipayApi\response;

/**
 * alipay.trade.query(统一收单线下交易预创建)响应结果
 * 
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年10月27日
 */  
class TradeQueryResponse extends ResponseAbstract
{
    /**
     * 支付宝交易号	
     * 
     * @var string(64)
     */
    public $trade_no;
    
    /**
     * 商家订单号
     * 
     * @var string(64)
     */
    public $out_trade_no;
    
    /**
     * 买家支付宝账号	
     * 
     * @var string(100)
     */
    public $buyer_logon_id;
    
    /**
     * 交易状态：
     *  - WAIT_BUYER_PAY（交易创建，等待买家付款）
     *  - TRADE_CLOSED（未付款交易超时关闭，或支付完成后全额退款）
     *  - TRADE_SUCCESS（交易支付成功）
     *  - TRADE_FINISHED（交易结束，不可退款）
     * 
     * @var string(32)
     */
    public $trade_status;
    
    /**
     * 交易的订单金额，单位为元，两位小数。该参数的值为支付时传入的total_amount
     * 	
     * @var price(11)
     */
    public $total_amount;
    
    /**
     * 标价币种，该参数的值为支付时传入的trans_currency
     * 
     * @var string(8)
     */
    public $trans_currency;
    
    /**
     * 订单结算币种，对应支付接口传入的settle_currency
     * 
     * @var string(8)
     */
    public $settle_currency;
    
    /**
     * 结算币种订单金额	
     * 
     * @var price(11)
     */
    public $settle_amount;

    /**
     * 订单支付币种	
     * 
     * @var strings(8)
     */
    public $pay_currency;
    
    /**
     * 支付币种订单金额	
     * 
     * @var price(11)
     */
    public $pay_amount;
    
    /**
     * 结算币种兑换标价币种汇率
     * 
     * @var price(11)
     */
    public $settle_trans_rate;
    
    /**
     * 标价币种兑换支付币种汇率	
     * 
     * @var price(11)
     */
    public $trans_pay_rate;
    
    /**
     * 买家实付金额，单位为元，两位小数。该金额代表该笔交易买家实际支付的金额，不包含商户折扣等金额
     * 
     * @var price(11)
     */
    public $buyer_pay_amount;
    
    /**
     * 积分支付的金额，单位为元，两位小数。该金额代表该笔交易中用户使用积分支付的金额，比如集分宝或者支付宝实时优惠等
     * 
     * @var price(11)
     */
    public $point_amount;
    
    /**
     * 交易中用户支付的可开具发票的金额，单位为元，两位小数。该金额代表该笔交易中可以给用户开具发票的金额
     *
     * @var price(11)
     */
    public $pinvoice_amount;

    /**
     * 本次交易打款给卖家的时间	
     *
     * @var date
     */
    public $send_pay_date;

    /**
     * 实收金额，单位为元，两位小数。该金额为本笔交易，商户账户能够实际收到的金额
     * 
     * @var price(11)
     */
    public $receipt_amount;
    
    /**
     * 商户门店编号	
     * 
     * @var string(32)
     */
    public $store_id;
    
    /**
     * 商户机具终端编号	
     * 
     * @var string(32)
     */
    public $terminal_id;
    
    /**
     * 交易支付使用的资金渠道	
     * 
     * @var TradeFundBill()
     */
    public $fund_bill_list;
    
    /**
     * 请求交易支付中的商户店铺的名称
     * 	
     * @var string(512)
     */
    public $store_name;
    
    /**
     * 买家在支付宝的用户id
     * 	
     * @var string(16)
     */
    public $buyer_user_id;
    
    /**
     * 该笔交易针对收款方的收费金额； 默认不返回该信息，需与支付宝约定后配置返回；
     * 
     * @var price(11)
     */
    public $charge_amount;
    
    /**
     * 费率活动标识，当交易享受活动优惠费率时，返回该活动的标识； 默认不返回该信息，需与支付宝约定后配置返回； 可能的返回值列表： 蓝海活动标识：bluesea_1
     * 
     * @var string(64)
     */
    public $charge_flags;
    
    /**
     * 支付清算编号，用于清算对账使用； 只在银行间联交易场景下返回该信息；
     * 
     * @var string(64)
     */
    public $settlement_id;
    
    /**
     * 预授权支付模式，该参数仅在信用预授权支付场景下返回。信用预授权支付：CREDIT_PREAUTH_PAY	
     * 
     * @var string(64)
     */
    public $auth_trade_pay_mode;
    
    /**
     * 买家用户类型。CORPORATE:企业用户；PRIVATE:个人用户。	
     * 
     * @var string(18)
     */
    public $buyer_user_type;
    
    /**
     * 商家优惠金额	
     * 
     * @var price(11)
     */
    public $mdiscount_amount;
    
    /**
     * 平台优惠金额	
     * 
     * @var price(11)
     */
    public $discount_amount;  
    
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\response\ResponseAbstract::getResponseRootNode()
     */
    final protected function getResponseRootNode() : string  
    {
        return 'alipay_trade_query_response';
    }
}
