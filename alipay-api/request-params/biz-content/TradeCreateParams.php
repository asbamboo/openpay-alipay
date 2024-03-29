<?php
namespace asbamboo\openpayAlipay\alipayApi\requestParams\bizContent;

use asbamboo\openpayAlipay\alipayApi\requestParams\BizContentInterface;
use asbamboo\openpayAlipay\alipayApi\requestParams\MappingDataTrait;

/**
 * alipay.trade.create(统一收单交易创建接口) 请求参数
 *
 * @see https://docs.open.alipay.com/api_1/alipay.trade.create
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月9日
 */
class TradeCreateParams implements BizContentInterface
{
    use MappingDataTrait;

    /**
     * 必选 最大长度64
     * 商户订单号,64个字符以内、只能包含字母、数字、下划线；需保证在商户端不重复
     *
     * @var string
     */
    public $out_trade_no;
    public $seller_id;

    /**
     * 必选 最大长度11
     *
     * 单位为元
     * 订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]
     * 如果同时传入了【打折金额】，【不可打折金额】，【订单总金额】三者，则必须满足如下条件：【订单总金额】=【打折金额】+【不可打折金额】
     *
     * @var string
     */
    public $total_amount;

    /**
     * 单位为元
     * 可打折金额. 参与优惠计算的金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]
     * 如果该值未传入，但传入了【订单总金额】，【不可打折金额】则该值默认为【订单总金额】-【不可打折金额】
     *
     * @var string
     */
    public $discountable_amount;

    /**
     * 必选 最大长度256
     *
     * 订单标题
     *
     * @var string
     */
    public $subject;

    /**
     * 可选 销售产品码。
     * 如果签约的是当面付快捷版，则传OFFLINE_PAYMENT;
     * 其它支付宝当面付产品传FACE_TO_FACE_PAYMENT；
     * 不传默认使用FACE_TO_FACE_PAYMENT；
     * @var string
     */
    public $product_code;
    
    public $goods_detail;
    public $body;
    public $buyer_id;
    public $operator_id;
    public $store_id;
    public $terminal_id;
    public $extend_params;

    /**
     * 该笔订单允许的最晚付款时间，逾期将关闭交易。
     * 取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
     * 该参数数值不接受小数点， 如 1.5h，可转换为 90m。
     *
     * @var string
     */
    public $timeout_express;

    public $settle_info;
    
    public $logistics_detail;
    
    public $business_params;
    
    public $receiver_address_info;
}
