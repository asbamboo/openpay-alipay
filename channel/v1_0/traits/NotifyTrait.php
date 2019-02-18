<?php
namespace asbamboo\openpayAlipay\channel\v1_0\traits;

use asbamboo\http\ServerRequestInterface;
use asbamboo\openpay\channel\v1_0\trade\payParameter\NotifyResult;
use asbamboo\openpayAlipay\alipayApi\notify\Notify;
use asbamboo\openpay\Constant AS OpenpayConstant;
use asbamboo\openpayAlipay\Constant;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月3日
 */
trait NotifyTrait
{
    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::notify()
     */
    public function getTradeNoKeyName() : string
    {
        return 'out_trade_no';
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::notify()
     */
    public function notify(ServerRequestInterface $Request) : NotifyResult
    {
        $Notify             = new Notify();
        $NotifyResult       = new NotifyResult();
        $NotifyResult->setResponseSuccess('success');
        $NotifyResult->setResponseFailed('fail');

        $NotifyResponse     = $Notify->exec($Request);
        $NotifyResult->setInTradeNo($NotifyResponse->out_trade_no);
        $NotifyResult->setThirdTradeNo($NotifyResponse->trade_no);
        $NotifyResult->setThirdPart(json_encode($NotifyResponse->notify_data));

        /**
         * 交易状态：
         *  - WAIT_BUYER_PAY（交易创建，等待买家付款）、
         *  - TRADE_CLOSED（未付款交易超时关闭，或支付完成后全额退款）、
         *  - TRADE_SUCCESS（交易支付成功）、
         *  - TRADE_FINISHED（交易结束，不可退款）
         */
        if($NotifyResponse->trade_status == Constant::TRADE_CLOSED){
            $NotifyResult->setTradeStatus(OpenpayConstant::TRADE_PAY_TRADE_STATUS_CANCEL);
        }else if($NotifyResponse->trade_status == Constant::TRADE_SUCCESS){
            $NotifyResult->setTradeStatus(OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYOK);
        }else if($NotifyResponse->trade_status == Constant::TRADE_FINISHED){
            $NotifyResult->setTradeStatus(OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYED);
        }else{
            $NotifyResult->setTradeStatus(OpenpayConstant::TRADE_PAY_TRADE_STATUS_PAYING);
        }

        return $NotifyResult;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::return()
     */
    public function return(ServerRequestInterface $Request) : NotifyResult
    {
        return $this->notify($Request);
    }
}