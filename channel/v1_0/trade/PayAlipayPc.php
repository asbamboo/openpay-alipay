<?php
namespace asbamboo\openpayAlipay\channel\v1_0\trade;

use asbamboo\openpayAlipay\Constant;
use asbamboo\openpay\channel\v1_0\trade\PayInterface;
use asbamboo\openpay\channel\v1_0\trade\payParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\payParameter\Response;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayAlipay\Env;
use asbamboo\openpayAlipay\alipayApi\Client;
use asbamboo\openpayAlipay\exception\ResponseFormatException;
use asbamboo\api\exception\ApiException;
use asbamboo\openpayAlipay\channel\v1_0\traits\NotifyTrait;

/**
 * openpay[trade.pay] 渠道:支付宝PC支付
 *
 * @author 李春寅<licy2013@aliyun.com>
 * @since 2018年11月4日
 */
class PayAlipayPc implements PayInterface
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
            $TradePagePay           = Client::createRequest('TradePagePay')->assignData($request_data);
            $redirect_data          = $TradePagePay->getAssignData();
            $redirect_url           = (string) $TradePagePay->getGateway() . '?charset=' . $redirect_data['charset'];

            $Response               = new Response();
            $Response->setType(Response::TYPE_PC);
            $Response->setRedirectUrl($redirect_url);
            $Response->setRedirectData($redirect_data);
            return $Response;
        }catch(ResponseFormatException $e){
            throw new ApiException($e->getMessage());
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\ChannelInterface::supports()
     */
    public function supports() : array
    {
        return [
            Constant::CHANNEL_ALIPAY_PC   => Constant::CHANNEL_ALIPAY_PC_LABEL,
        ];
    }
}
