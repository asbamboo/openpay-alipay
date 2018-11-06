<?php
namespace asbamboo\openpayAlipay\alipayApi\response;

/**
 * alipay.trade.cancel(统一收单交易撤销接口) 响应结果
 *
 * @see https://docs.open.alipay.com/api_1/alipay.trade.cancel/
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月6日
 */
class TradeCancelResponse extends ResponseAbstract
{
    /**
     * 必填 支付宝交易号
     *
     * @var string(64)
     */
    protected $trade_no;

    /**
     * 必填 商户订单号
     *
     * @var string(64)
     */
    protected $out_trade_no;

    /**
     * 必填 是否需要重试
     *
     * @var string(1)
     */
    protected $retry_flag;

    /**
     * 选填 当撤销产生了退款时，返回退款时间；默认不返回该信息，需与支付宝约定后配置返回；
     *
     * @var date(32)
     */
    protected $gmt_refund_pay;

    /**
     * 选填 当撤销产生了退款时，返回的退款清算编号，用于清算对账使用；只在银行间联交易场景下返回该信息；
     *
     * @var string(64)
     */
    protected $refund_settlement_id;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\response\ResponseAbstract::getResponseRootNode()
     */
    final protected function getResponseRootNode() : string
    {
        return 'alipay_trade_cancel_response';
    }
}