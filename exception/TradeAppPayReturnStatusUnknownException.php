<?php
namespace asbamboo\openpayAlipay\exception;

/**
 * app支付同步（return）通知，支付状态不确定。（这时客户端应该通过查询接口，确定是否支付完成）
 *  - app支付同步（return）通知返回的通知参数中code 等于成功（10000）
 *  - app支付同步（return）通知返回的通知resultStatus 不等于订单支付成功（9000）
 *  - 通过支付宝交易查询接口， 使用app支付同步（return）通知返回的通知参数中（out_trade_no）未能成功查询。
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年2月18日
 */
class TradeAppPayReturnStatusUnknownException extends OpenpayAlipayException
{

}
