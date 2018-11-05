<?php
namespace asbamboo\openpayAlipay\alipayApi\requestParams\bizContent;

use asbamboo\openpayAlipay\alipayApi\requestParams\BizContentInterface;
use asbamboo\openpayAlipay\alipayApi\requestParams\MappingDataTrait;

/**
 * alipay.trade.refund(统一收单交易退款接口) 请求参数
 * 
 * @see https://docs.open.alipay.com/api_1/alipay.trade.refund/
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月5日
 */
class TradeRefundParams implements BizContentInterface
{
    use MappingDataTrait;
    
    /**
     * 特殊可选 订单支付时传入的商户订单号,不能和 trade_no同时为空。
     *
     * @var string(64)
     */
    public $out_trade_no;
    
    /**
     * 特殊可选 支付宝交易号，和商户订单号不能同时为空
     * 
     * @var string(64)
     */
    public $trade_no;
    
    /**
     * 必选 需要退款的金额，该金额不能大于订单金额,单位为元，支持两位小数
     * 
     * @var price(9)
     */
    public $refund_amount;
    
    /**
     * 订单退款币种信息	
     * 
     * @var string(8)
     */
    public $refund_currency;
    
    /**
     * 退款的原因说明	
     * 
     * @var string(256)
     */
    public $refund_reason;	
    
    /**
     * 可选 标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
     * 
     * @var string(64)
     */
    public $out_request_no;
    
    /**
     * 可选 商户的操作员编号
     * 	
     * @var string(30)
     */
    public $operator_id;
    
    /**
     * 商户的门店编号	
     * 
     * @var string(32)
     */
    public $store_id;
    
    /**
     * 商户的终端编号	
     * 
     * @var string(32)
     */
    public $terminal_id;
    
    /**
     * 可选 退款包含的商品列表信息，Json格式。 其它说明详见：“商品明细说明”
     *  - goods_id 必填 string(32) 商品的编号	
     *  - alipay_goods_id 可选 string(32) 支付宝定义的统一商品编号	
     *  - goods_name 必填 string(32) 商品名称	
     *  - quantity 必填 number(10) 商品数量	
     *  - price 必填 price(9) 商品单价，单位为元		
     *  - goods_category 可选 string(24) 商品类目			
     *  - categories_tree 可选 string(128) 商品类目树，从商品类目根节点到叶子节点的类目id组成，类目id值使用|分割		
     *  - body 可选 string(1000) 商品描述信息		
     *  - show_url 可选 string(400) 商品的展示地址		
     *  
     * @var GoodsDetail()
     */
    public $goods_detail;
    
    /**
     * 可选	退分账明细信息	
     *  - royalty_type 可选 string(32) 分账类型. 普通分账为：transfer; 补差为：replenish; 为空默认为分账transfer;
     *  - trans_out 可选 string(16) 支出方账户。
     *    - 如果支出方账户类型为userId，本参数为支出方的支付宝账号对应的支付宝唯一用户号，以2088开头的纯16位数字；
     *    - 如果支出方类型为loginName，本参数为支出方的支付宝登录号；
     *  - trans_out_type 可选 string(64) 支出方账户类型。
     *    - userId表示是支付宝账号对应的支付宝唯一用户号;
     *    - loginName表示是支付宝登录号；
     *  - trans_in_type 可选 string(64) 收入方账户类型。
     *    - userId表示是支付宝账号对应的支付宝唯一用户号;
     *    - cardSerialNo表示是卡编号;
     *    - loginName表示是支付宝登录号；
     *  - trans_in 可选 string(16) 收入方账户。
     *    - 如果收入方账户类型为userId，本参数为收入方的支付宝账号对应的支付宝唯一用户号，以2088开头的纯16位数字；
     *    - 如果收入方类型为cardSerialNo，本参数为收入方在支付宝绑定的卡编号；
     *    - 如果收入方类型为loginName，本参数为收入方的支付宝登录号；
     *  - amount 可选 price(9) 分账的金额，单位为元
     *  - amount_percentage 可选 number(3) 分账信息中分账百分比。取值范围为大于0，少于或等于100的整数。
     *  - desc 可选 string(1000) 分账描述	
     *  
     * @var OpenApiRoyaltyDetailInfoPojo()
     */
    public $refund_royalty_parameters;
    
    /**
     * 银行间联模式下有用，其它场景请不要使用； 双联通过该参数指定需要退款的交易所属收单机构的pid;
     * 
     * @var string(16)
     */
    public $org_pid;
}
