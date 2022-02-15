<?php
namespace asbamboo\openpayAlipay;

/**
 * 相关常量
 *
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年10月30日
 */
final class Constant
{
    /************************************************************************************************
     * 支付渠道常量
     ***********************************************************************************************/
    const CHANNEL_ALIPAY_ONECD          = 'ALIPAY_ONECD';
    const CHANNEL_ALIPAY_ONECD_LABEL    = '支付宝一码付';
    const CHANNEL_ALIPAY_QRCD           = 'ALIPAY_QRCD';
    const CHANNEL_ALIPAY_QRCD_LABEL     = '支付宝扫码支付';
    const CHANNEL_ALIPAY_PC             = 'ALIPAY_PC';
    const CHANNEL_ALIPAY_PC_LABEL       = '支付宝PC支付';
    const CHANNEL_ALIPAY_APP            = 'ALIPAY_APP';
    const CHANNEL_ALIPAY_APP_LABEL      = '支付宝APP支付';
    /***********************************************************************************************/

    /************************************************************************************************
     * 支付宝 trade_status参数的取值
     ***********************************************************************************************/
    const WAIT_BUYER_PAY                = 'WAIT_BUYER_PAY';
    const TRADE_CLOSED                  = 'TRADE_CLOSED';
    const TRADE_SUCCESS                 = 'TRADE_SUCCESS';
    const TRADE_FINISHED                = 'TRADE_FINISHED';
    /***********************************************************************************************/
}