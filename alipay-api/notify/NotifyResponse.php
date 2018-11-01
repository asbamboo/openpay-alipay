<?php
namespace asbamboo\openpayAlipay\alipayApi\notify;

/**
 * 推送信息响应
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月31日
 */
class NotifyResponse
{
    /**
     * 支付宝的中的商户订单号
     * @var string
     */
    public $out_trade_no;

    /**
     * 支付宝交易号
     * @var string
     */
    public $trade_no;

    /**
     * 支付宝交易状态
     *
     * @var string
     */
    public $trade_status;

    /**
     * 全部的推送数据
     *
     * @var array
     */
    public $notify_data;
}