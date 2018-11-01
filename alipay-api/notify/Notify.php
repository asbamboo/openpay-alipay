<?php
namespace asbamboo\openpayAlipay\alipayApi\notify;

use asbamboo\http\ServerRequestInterface;

/**
 * 支付宝推送消息的处理
 *  - 验证是否时合法的推送消息
 *  - 将推送消息序列化成 NotifyResponse
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月31日
 */
class Notify implements NotifyInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\notify\NotifyInterface::exec()
     */
    public function exec(ServerRequestInterface $Request) : NotifyResponse
    {
        $this->check($Request);
        $NotifyResponse                 = new NotifyResponse();
        $NotifyResponse->out_trade_no   = $Request->getPostParam('out_trade_no');
        $NotifyResponse->trade_no       = $Request->getPostParam('trade_no');
        $NotifyResponse->trade_status   = $Request->getPostParam('trade_status');
        $NotifyResponse->notify_data    = $Request->getRequestParams();
        return $NotifyResponse;
    }

    /**
     *
     * @param ServerRequestInterface $Request
     */
    private function check(ServerRequestInterface $Request) : void
    {

    }
}