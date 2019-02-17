<?php
namespace asbamboo\openpayAlipay\alipayApi\notify;

use asbamboo\http\ServerRequestInterface;
use asbamboo\http\Response;
use asbamboo\http\Stream;
use asbamboo\openpayAlipay\alipayApi\response\TradeAppPayResponse;
use asbamboo\openpayAlipay\alipayApi\response\ResponseAbstract;

/**
 * 在支付宝开发社区中发过帖子问了关于返回状态码的问题，除了9000表示支付已经成功以外，其他状态具有不确定性，需要通过查询接口确定订单的状态
 *  - https://openclub.alipay.com/read.php?tid=13091&fid=59
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2019年2月11日
 */
class AppReturn implements NotifyInterface
{
    const RESULT_STATUS_SUCCESS     = '9000'; //订单支付成功
    const RESULT_STATUS_PROCESSING  = '8000'; //正在处理中，支付结果未知（有可能已经支付成功），请查询商户订单列表中订单的支付状态
    const RESULT_STATUS_FAILED      = '4000'; //订单支付失败
    const RESULT_STATUS_REPEATED    = '5000'; //重复请求
    const RESULT_STATUS_CANCEL      = '6001'; //用户中途取消
    const RESULT_STATUS_NETERR      = '6002'; //网络连接出错
    const RESULT_STATUS_UNKNOWN     = '6004'; //支付结果未知（有可能已经支付成功），请查询商户订单列表中订单的支付状态
//     其它	其它支付错误

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpayAlipay\alipayApi\notify\NotifyInterface::exec()
     */
    public function exec(ServerRequestInterface $Request): NotifyResponse
    {
        /**
         * 三个参数是alipay 返回给app端的。
         * @var Ambiguous $result
         */
        $result         = $Request->getRequestParam("result");
        $result_status  = $Request->getRequestParam("resultStatus");
        $memo           = $Request->getRequestParam("memo");
        $NotifyResponse = new NotifyResponse();

        $HttpResponse   = new Response(new Stream('php://temp', 'w+b'));
        $HttpResponse->getBody()->write($result);

        $TradeAppPayResponse    = new TradeAppPayResponse($HttpResponse);

        if($TradeAppPayResponse->get('code') != ResponseAbstract::CODE_SUCCESS){

        }


        if($result_status == self::RESULT_STATUS_SUCCESS){
            $NotifyResponse->trade_no       = $TradeAppPayResponse->get('out_trade_no');
            $NotifyResponse->out_trade_no   = $TradeAppPayResponse->get('trade_no');
            $NotifyResponse->trade_status   = 'TRADE_SUCCESS';
            $NotifyResponse->notify_data    = $Request->getRequestParams();
        }else{
            $TradeAppPayResponse            = new TradeAppPayResponse($HttpResponse);

        }

        return $NotifyResponse;
    }
}