<?php
namespace asbamboo\openpayAlipay\alipayApi\requestParams\bizContent;

use asbamboo\openpayAlipay\alipayApi\requestParams\MappingDataTrait;
use asbamboo\openpayAlipay\alipayApi\requestParams\BizContentInterface;

/**
 * alipay.trade.app.pay App支付请求参数说明 请求参数
 *
 * @see https://docs.open.alipay.com/204/105465/
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月3日
 */
class TradeAppPayParams implements BizContentInterface
{
    use MappingDataTrait;

    /**
     * 可选 订单描述
     * 对一笔交易的具体描述信息。如果是多种商品，请将商品描述字符串累加传给body。
     *
     * @var string(128)
     */
    public $body;

    /**
     * 必选 订单标题
     *
     * @var string(256)
     */
    public $subject;

    /**
     * 必选 最大长度64
     * 商户订单号,64个字符以内、只能包含字母、数字、下划线；需保证在商户端不重复
     *
     * @var string
     */
    public $out_trade_no;

    /**
     * 可选 该笔订单允许的最晚付款时间，逾期将关闭交易。
     *  - 取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
     *  - 该参数数值不接受小数点， 如 1.5h，可转换为 90m
     *
     * @var string(6)
     */
    public $timeout_express;

    /**
     * 必选, 订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]。
     *
     * @var price(11)
     */
    public $total_amount;

    /**
     * 必选, 销售产品码，商家和支付宝签约的产品码，为固定值QUICK_MSECURITY_PAY
     *
     * @var string(64)
     */
    public $product_code = 'QUICK_MSECURITY_PAY';

    /**
     * 可选 商品主类型 :0-虚拟类商品,1-实物类商品 注：虚拟类商品不支持使用花呗渠道
     *
     * @var string(2)
     */
    public $goods_type;

    /**
     * 可选
     * 公用回传参数，如果请求时传递了该参数，则返回给商户时会回传该参数。
     * 支付宝只会在同步返回（包括跳转回商户网站）和异步通知时将该参数原样返回。
     * 本参数必须进行UrlEncode之后才可以发送给支付宝。
     *
     * @var string(512)
     */
    public $passback_params;

    /**
     * 可选 优惠参数 注：仅与支付宝协商后可用
     *
     * @var string(512)
     */
    public $promo_params;

    /**
     * 可选 业务扩展参数
     *  - sys_service_provider_id 可选 string(64) 系统商编号 该参数作为系统商返佣数据提取的依据，请填写系统商签约协议的PID
     *  - hb_fq_num 可选 string(5) 系统商编号 使用花呗分期要进行的分期数
     *  - hb_fq_seller_percent 可选 string(3) 使用花呗分期需要卖家承担的手续费比例的百分值，传入100代表100%
     *  - needBuyerRealnamed 可选 string(1) 是否发起实名校验 T：发起 F：不发起
     *  - TRANS_MEMO 可选 string(128) 账务备注 注：该字段显示在离线账单的账务备注中 如：促销
     *
     * @var ExtendParams()
     */
    public $extend_params;

    /**
     * 可用渠道,用户只能在指定渠道范围内支付，多个渠道以逗号分割注，与disable_pay_channels互斥渠道列表：https://docs.open.alipay.com/common/wifww7
     *
     * @var string(128)
     */
    public $enable_pay_channels;

    /**
     * 可选 禁用渠道,用户不可用指定渠道支付，多个渠道以逗号分割注，与enable_pay_channels互斥 渠道列表：https://docs.open.alipay.com/common/wifww7
     *
     * @var string(128)
     */
    public $disable_pay_channels;

    /**
     * 可选 商户门店编号
     *
     * @var string(32)
     */
    public $store_id;

    /**
     * 外部指定买家，详见外部用户ExtUserInfo参数说明
     *  - name 可选 string(16) 姓名 注： need_check_info=T时该参数才有效
     *  - mobile 可选 string(20) 手机号 注：该参数暂不校验
     *  - cert_type 可选 string(32) 身份证：IDENTITY_CARD、护照：PASSPORT、军官证：OFFICER_CARD、士兵证：SOLDIER_CARD、户口本：HOKOU等。如有其它类型需要支持，请与蚂蚁金服工作人员联系。
     *  - cert_no 可选 string(64) 证件号 注：need_check_info=T时该参数才有效
     *  - min_age 可选 string(3) 允许的最小买家年龄，买家年龄必须大于等于所传数值 注：1. need_check_info=T时该参数才有效 2. min_age为整数，必须大于等于0
     *  - fix_buyer 可选 string(8) 是否强制校验付款人身份信息 T:强制校验，F：不强制
     *  - need_check_info 可选 string(1) 是否强制校验身份信息 T:强制校验，F：不强制
     * @var ExtUserInfo()
     */
    public $ext_user_info;
}