<?php
namespace asbamboo\openpayAlipay\channel\v1_0\trade;

use asbamboo\openpay\channel\v1_0\trade\PayInterface;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\api\exception\ApiException;
use asbamboo\openpayAlipay\Env;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\openpayAlipay\alipayApi\Client;
use asbamboo\openpayAlipay\alipayApi\response\TradePrecreateResponse;
use asbamboo\openpayAlipay\exception\ResponseFormatException;
use asbamboo\openpay\channel\v1_0\trade\payParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\payParameter\Response;
use asbamboo\openpayAlipay\Constant;
use asbamboo\openpayAlipay\channel\v1_0\traits\NotifyTrait;

/**
 * openpay[trade.pay] 渠道:支付宝扫码支付
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年10月22日
 */
class PayAlipayQrcd implements PayInterface
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
            ];
            $alipay_params          = json_decode((string) $Request->getThirdPart(), true);
            if(is_array($alipay_params)){
                foreach($alipay_params AS $alipay_key => $alipay_value){
                    $request_data[$alipay_key] = $alipay_value;
                }
            }

            $AlipayResponse = Client::request('TradePrecreate', $request_data);
            if(     $AlipayResponse->get('code') != TradePrecreateResponse::CODE_SUCCESS
                ||  $AlipayResponse->get('sub_code') != null
            ){
                $Exception                      = new Api3NotSuccessResponseException('支付宝返回的响应值表示这次业务没有处理成功。');
                $ApiResponseParams              = new ApiResponseParams();
                $ApiResponseParams->code        = $AlipayResponse->get('code');
                $ApiResponseParams->msg         = $AlipayResponse->get('msg');
                $ApiResponseParams->sub_code    = $AlipayResponse->get('sub_code');
                $ApiResponseParams->sub_msg     = $AlipayResponse->get('sub_msg');
                $Exception->setApiResponseParams($ApiResponseParams);
                throw $Exception;
            }
            $Response               = new Response();
            $Response->setRedirectType(Response::REDIRECT_TYPE_QRCD);
            $Response->setQrCode($AlipayResponse->get('qr_code'));
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
            Constant::CHANNEL_ALIPAY_QRCD   => Constant::CHANNEL_ALIPAY_QRCD_LABEL,
        ];
    }
}