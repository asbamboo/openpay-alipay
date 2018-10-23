<?php
namespace asbamboo\openpayAlipay;

/**
 * 常量配置
 * 环境变量的key
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月10日
 */
final class Env
{
    /*********************************************************************************************
     * 支付宝环境变量
     *********************************************************************************************/
    // 支付宝接口网关uri
    const ALIPAY_GATEWAY_URI        = 'OPENPAY_ALIPAY_GATEWAY_URI';
    // 用于设置支付宝私银文件地址
    const ALIPAY_RSA_PRIVATE_KEY    = 'OPENPAY_ALIPAY_RSA_PRIVATE';
    // 用于设置支付宝公银文件地址
    const ALIPAY_RSA_ALIPAY_KEY     = 'OPENPAY_ALIPAY_RSA_ALIPAY';
    // 支付宝 app id
    const ALIPAY_APP_ID             = 'OPENPAY_ALIPAY_APP_ID';
    // 支付宝扫码支付的消息推送 notify url
    const ALIPAY_QRCD_NOTIFY_URL    = "OPENPAY_ALIPAY_QRCD_NOTIFY_URL";
    /*********************************************************************************************/
}