<?php
namespace asbamboo\openpayAlipay\alipayApi\notify;

use asbamboo\http\ServerRequest;
use asbamboo\http\ServerRequestInterface;

/**
 * 接收支付宝推送的消息
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月31日
 */
interface NotifyInterface
{
    /**
     * 主执行程序
     *
     * @param ServerRequest $Request
     * @return NotifyResponse
     */
    public function exec(ServerRequestInterface $Request) : NotifyResponse;
}