<?php
namespace asbamboo\openpayAlipay\alipayApi\requestParams\bizContent;

use asbamboo\openpayAlipay\alipayApi\requestParams\MappingDataTrait;
use asbamboo\openpayAlipay\alipayApi\requestParams\BizContentInterface;

/**
 * alipay.trade.page.pay(统一收单下单并支付页面接口) 请求参数
 *
 * @see https://docs.open.alipay.com/api_1/alipay.trade.page.pay
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月3日
 */
class TradePagePayParams implements BizContentInterface
{
    use MappingDataTrait;

    /**
     * 必选 最大长度64
     * 商户订单号,64个字符以内、只能包含字母、数字、下划线；需保证在商户端不重复
     *
     * @var string
     */
    public $out_trade_no;

    /**
     * 必选, 销售产品码，与支付宝签约的产品码名称。注：目前仅支持FAST_INSTANT_TRADE_PAY
     *
     * @var string(64)
     */
    public $product_code = 'FAST_INSTANT_TRADE_PAY';

    /**
     * 必选, 订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]。
     *
     * @var price(11)
     */
    public $total_amount;

    /**
     * 必选 订单标题
     *
     * @var string(256)
     */
    public $subject;

    /**
     * 可选 订单描述
     *
     * @var string(128)
     */
    public $body;

    /**
     * 可选 绝对超时时间，格式为yyyy-MM-dd HH:mm
     *
     * @var string(32)
     */
    public $time_expire;

    /**
     * 可选	订单包含的商品列表信息，json格式，其它说明详见商品明细说明
     *  - goods_id 必填 string(32) 商品的编号
     *  - alipay_goods_id 可选 string(32) 支付宝定义的统一商品编号
     *  - goods_name 必填 string(256) 商品名称
     *  - quantity 必填 number(10) 商品数量
     *  - price 必填 price(9) 商品单价，单位为元
     *  - goods_category 可选 string(24) 商品类目
     *  - body 可选 string(1000) 商品描述信息
     *  - show_url 可选 string(400) 商品的展示地址
     *
     * @var GoodsDetail()
     */
    public $goods_detail;

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
     * 可选 业务扩展参数
     *  - sys_service_provider_id 可选 string(64) 系统商编号 该参数作为系统商返佣数据提取的依据，请填写系统商签约协议的PID
     *  - hb_fq_num 可选 string(5) 系统商编号 使用花呗分期要进行的分期数
     *  - hb_fq_seller_percent 可选 string(3) 使用花呗分期需要卖家承担的手续费比例的百分值，传入100代表100%
     *  - industry_reflux_info 可选 string(512) 行业数据回流信息, 详见：地铁支付接口参数补充说明
     *  - card_type 可选 string(32) 卡类型
     *
     * @var ExtendParams()
     */
    public $extend_params;

    /**
     * 可选 商品主类型 :0-虚拟类商品,1-实物类商品 注：虚拟类商品不支持使用花呗渠道
     *
     * @var string(2)
     */
    public $goods_type;

    /**
     * 可选 该笔订单允许的最晚付款时间，逾期将关闭交易。
     *  - 取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
     *  - 该参数数值不接受小数点， 如 1.5h，可转换为 90m
     *
     * @var string(6)
     */
    public $timeout_express;

    /**
     * 可选 优惠参数 注：仅与支付宝协商后可用
     *
     * @var string(512)
     */
    public $promo_params;

    /**
     * 可选 描述分账信息，json格式，详见分账参数说明
     *  - royalty_type 可选 string(150) 分账类型 卖家的分账类型，目前只支持传入ROYALTY（普通分账类型）。
     *  - royalty_detail_infos 可选 RoyaltyDetailInfos[2500] 分账明细的信息，可以描述多条分账指令，json数组。
     *    - serial_no 可选 number(9) 分账序列号，表示分账执行的顺序，必须为正整数
     *    - trans_in_type 可选 string(24) 接受分账金额的账户类型：
     *      - userId：支付宝账号对应的支付宝唯一用户号。
     *      - bankIndex：分账到银行账户的银行编号。目前暂时只支持分账到一个银行编号。
     *      - storeId：分账到门店对应的银行卡编号。默认值为userId。
     *    - batch_no 必填 string(32) 分账批次号 目前需要和转入账号类型为bankIndex配合使用。
     *    - out_relation_id 可选 string(64) 商户分账的外部关联号，用于关联到每一笔分账信息，商户需保证其唯一性。如果为空，该值则默认为“商户网站唯一订单号+分账序列号”
     *    - trans_out_type 必填 string(24) 要分账的账户类型。目前只支持userId：支付宝账号对应的支付宝唯一用户号。默认值为userId。
     *    - trans_out 必填 string(16) 如果转出账号类型为userId，本参数为要分账的支付宝账号对应的支付宝唯一用户号。以2088开头的纯16位数字。
     *    - trans_in 必填 string(28)
     *      - 如果转入账号类型为userId，本参数为接受分账金额的支付宝账号对应的支付宝唯一用户号。
     *      - 以2088开头的纯16位数字。如果转入账号类型为bankIndex，本参数为28位的银行编号（商户和支付宝签约时确定）。
     *      - 如果转入账号类型为storeId，本参数为商户的门店ID。
     *    - amount 必填 number(9) 分账的金额，单位为元
     *    - desc 可选 string(1000) 分账描述信息
     *    - amount_percentage 可选 string(3) 分账的比例，值为20代表按20%的比例分账
     *
     * @var RoyaltyInfo()
     */
    public $royalty_info;

    /**
     * 可选	SubMerchant 间连受理商户信息体，当前只对特殊银行机构特定场景下使用此字段
     *  - merchant_id 必填 string(11) 间连受理商户的支付宝商户编号，通过间连商户入驻后得到。间连业务下必传，并且需要按规范传递受理商户编号。
     *  - merchant_type 必填 string(32) 商户id类型，alipay: 支付宝分配的间连商户编号, merchant: 商户端的间连商户编号
     *
     * @var SubMerchant()
     */
    public $sub_merchant;

    /**
     * 可用渠道,用户只能在指定渠道范围内支付，多个渠道以逗号分割注，与disable_pay_channels互斥渠道列表：https://docs.open.alipay.com/common/wifww7
     *
     * @var string(128)
     */
    public $enable_pay_channels;

    /**
     * 可选 商户门店编号
     *
     * @var string(32)
     */
    public $store_id;

    /**
     * 可选 禁用渠道,用户不可用指定渠道支付，多个渠道以逗号分割注，与enable_pay_channels互斥 渠道列表：https://docs.open.alipay.com/common/wifww7
     *
     * @var string(128)
     */
    public $disable_pay_channels;

    /**
     * 可选	PC扫码支付的方式，支持前置模式和跳转模式。
     *  - 前置模式是将二维码前置到商户的订单确认页的模式。需要商户在自己的页面中以 iframe 方式请求支付宝页面。具体分为以下几种：
     *      - 0：订单码-简约前置模式，对应 iframe 宽度不能小于600px，高度不能小于300px；
     *      - 1：订单码-前置模式，对应iframe 宽度不能小于 300px，高度不能小于600px；
     *      - 3：订单码-迷你前置模式，对应 iframe 宽度不能小于 75px，高度不能小于75px；
     *      - 4：订单码-可定义宽度的嵌入式二维码，商户可根据需要设定二维码的大小。
     *  - 跳转模式下，用户的扫码界面是由支付宝生成的，不在商户的域名下。
     *      - 2：订单码-跳转模式
     *
     * @var string(2)
     */
    public $qr_pay_mode;

    /**
     * 可选 商户自定义二维码宽度 注：qr_pay_mode=4时该参数生效
     *
     * @var number(4)
     */
    public $qrcode_width;

    /**
     * 可选 描述结算信息，json格式，详见结算参数说明
     *  - settle_detail_infos 必填 SettleDetailInfo[10] 	结算详细信息，json数组，目前只支持一条。
     *  - trans_in_type 必填 string(64) 结算收款方的账户类型。
     *    - cardSerialNo：结算收款方的银行卡编号;
     *    - userId：表示是支付宝账号对应的支付宝唯一用户号;
     *    - loginName：表示是支付宝登录号；
     *  - trans_in 必填 string(64) 结算收款方。
     *    - 当结算收款方类型是cardSerialNo时，本参数为用户在支付宝绑定的卡编号；
     *    - 结算收款方类型是userId时，本参数为用户的支付宝账号对应的支付宝唯一用户号，以2088开头的纯16位数字；
     *    - 当结算收款方类型是loginName时，本参数为用户的支付宝登录号
     *  - summary_dimension 可选 string(64) 结算汇总维度，按照这个维度汇总成批次结算，由商户指定。目前需要和结算收款方账户类型为cardSerialNo配合使用
     *  - settle_entity_id 可选 string(64) 结算主体标识。当结算主体类型为SecondMerchant时，为二级商户的SecondMerchantID；当结算主体类型为Store时，为门店的外标。
     *  - settle_entity_type 可选 string(32) 结算主体类型。二级商户:SecondMerchant;商户或者直连商户门店:Store
     *  - amount 必填 number(9) 结算的金额，单位为元。目前必须和交易金额相同
     *
     * @var SettleInfo()
     */
    public $settle_info;

    /**
     * 可选 开票信息
     *  - key_info 必填 InvoiceKeyInfo[200] 开票关键信息
     *    - is_support_invoice 必填 boolean(5) 该交易是否支持开票 true
     *    - invoice_merchant_name 必填 string(80) 开票商户名称：商户品牌简称|商户门店简称
     *    - tax_num 必填 string(30) 税号
     *  - details 必填 string(400) 开票内容 注：json数组格式 [{"code":"100294400","name":"服饰","num":"2","sumPrice":"200.00","taxRate":"6%"}]
     *
     * @var InvoiceInfo()
     */
    public $invoice_info;

    /**
     * 可选 签约参数，支付后签约场景使用
     *  - personal_product_code 必填 string(64) 个人签约产品码，商户和支付宝签约时确定。
     *  - sign_scene 可选 string(64) 协议签约场景，商户和支付宝签约时确定。当传入商户签约号external_agreement_no时，场景不能为默认值DEFAULT|DEFAULT。
     *  - external_agreement_no 可选 string(32) 商户签约号，代扣协议中标示用户的唯一签约号（确保在商户系统中唯一）。
     *    - 格式规则：支持大写小写字母和数字，最长32位。商户系统按需传入，如果同一用户在同一产品码、同一签约场景下，签订了多份代扣协议，那么需要指定并传入该值。
     *  - external_logon_id 可选 string(100) 用户在商户网站的登录账号，用于在签约页面展示，如果为空，则不展示
     *  - sign_validity_period 可选 string(8) 当前用户签约请求的协议有效周期。整形数字加上时间单位的协议有效期，从发起签约请求的时间开始算起。
     *    - 目前支持的时间单位：1. d：天2. m：月 如果未传入，默认为长期有效。
     *  - third_party_type 可选 string(32) 签约第三方主体类型。对于三方协议，表示当前用户和哪一类的第三方主体进行签约。
     *    - 取值范围：1. PARTNER（平台商户）;2. MERCHANT（集团商户），集团下子商户可共享用户签约内容; 默认为PARTNER。
     *  - buckle_app_id 可选 string(64) 商户在芝麻端申请的appId
     *  - buckle_merchant_id 可选 string(64) 商户在芝麻端申请的merchantId
     *  - promo_params 可选 string(512) 签约营销参数，此值为json格式；具体的key需与营销约定
     *  - integration_type 可选 string(16) 请求后页面的集成方式。取值范围：1. ALIAPP：支付宝钱包内2. PCWEB：PC端访问 默认值为PCWEB。
     *  - request_from_url 可选 string(256) 请求来源地址。如果使用ALIAPP的集成方式，用户中途取消支付会返回该地址。
     *  - business_params 可选 string(512) 商户传入业务信息，具体值要和支付宝约定，应用于安全，营销等参数直传场景，格式为json格式
     *  - ext_user_info 可选 ExtUserInfo 外部指定买家
     *    - name 可选 string(16) 姓名 注： need_check_info=T时该参数才有效
     *    - mobile 可选 string(20) 手机号 注：该参数暂不校验
     *    - cert_type 可选 string(32) 身份证：IDENTITY_CARD、护照：PASSPORT、军官证：OFFICER_CARD、士兵证：SOLDIER_CARD、户口本：HOKOU等。如有其它类型需要支持，请与蚂蚁金服工作人员联系。
     *    - cert_no 可选 string(64) 证件号 注：need_check_info=T时该参数才有效
     *    - min_age 可选 string(3) 允许的最小买家年龄，买家年龄必须大于等于所传数值 注：1. need_check_info=T时该参数才有效 2. min_age为整数，必须大于等于0
     *    - fix_buyer 可选 string(8) 是否强制校验付款人身份信息 T:强制校验，F：不强制
     *    - need_check_info 可选 string(1) 是否强制校验身份信息 T:强制校验，F：不强制
     *
     * @var AgreementSignParams()
     */
    public $agreement_sign_params;
}