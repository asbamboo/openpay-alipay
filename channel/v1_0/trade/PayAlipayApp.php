<?php
namespace asbamboo\openpayAlipay\channel\v1_0\trade;

use asbamboo\openpayAlipay\Constant;
use asbamboo\openpay\Constant AS OpenpayConstant;
use asbamboo\openpay\channel\v1_0\trade\PayInterface;
use asbamboo\openpay\channel\v1_0\trade\payParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\payParameter\Response;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayAlipay\Env;
use asbamboo\openpayAlipay\alipayApi\Client;
use asbamboo\openpayAlipay\exception\ResponseFormatException;
use asbamboo\api\exception\ApiException;
use asbamboo\openpayAlipay\channel\v1_0\traits\NotifyTrait;
use asbamboo\http\ServerRequestInterface;
use asbamboo\openpay\channel\v1_0\trade\payParameter\NotifyResult;
use asbamboo\openpayAlipay\alipayApi\notify\AppReturn;

/**
 * openpay[trade.pay] 渠道:支付宝PC支付
 *
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月4日
 */
class PayAlipayApp implements PayInterface
{
    use NotifyTrait;

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::execute()
     */
    public function execute(Request $Request) : Response
    {
        try{
            $request_data           = [
                'app_id'            => (string) EnvHelper::get(Env::ALIPAY_APP_ID),
                'out_trade_no'      => $Request->getInTradeNo(),
                'total_amount'      => bcdiv($Request->getTotalFee(), 100, 2), //聚合接口接收的单位是分，支付宝的单位是元
                'subject'           => $Request->getTitle(),
                'notify_url'        => $Request->getNotifyUrl(),
                'return_url'        => $Request->getReturnUrl(),
            ];
            $alipay_params          = json_decode((string) $Request->getThirdPart(), true);
            if(is_array($alipay_params)){
                foreach($alipay_params AS $alipay_key => $alipay_value){
                    $request_data[$alipay_key] = $alipay_value;
                }
            }
            $TradeAppPay            = Client::createRequest('TradeAppPay')->assignData($request_data);
            $reqeust_data           = $TradeAppPay->getAssignData();

            $Response               = new Response();
            $Response->setType(Response::TYPE_APP);
            $Response->setAppPayJson(json_encode($reqeust_data));
            return $Response;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\PayInterface::return()
     */
    public function return(ServerRequestInterface $Request) : NotifyResult
    {
        $AppReturn      = new AppReturn();
        $NotifyResult   = new NotifyResult();
        $NotifyResponse = $AppReturn->exec($Request);
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
     * @see \asbamboo\openpay\channel\ChannelInterface::supports()
     */
    public function supports() : array
    {
        return [
            Constant::CHANNEL_ALIPAY_APP   => Constant::CHANNEL_ALIPAY_APP_LABEL,
        ];
    }
}
