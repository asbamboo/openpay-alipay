<?php
namespace asbamboo\openpayAlipay\channel\v1_0\trade;

use asbamboo\openpay\channel\v1_0\trade\CancelInterface;
use asbamboo\openpayAlipay\Constant;
use asbamboo\openpay\channel\v1_0\trade\cancelParameter\Request;
use asbamboo\openpay\channel\v1_0\trade\cancelParameter\Response;
use asbamboo\helper\env\Env AS EnvHelper;
use asbamboo\openpayAlipay\Env;
use asbamboo\openpayAlipay\alipayApi\Client;
use asbamboo\openpayAlipay\alipayApi\response\TradeCloseResponse;
use asbamboo\openpay\apiStore\exception\Api3NotSuccessResponseException;
use asbamboo\api\apiStore\ApiResponseParams;
use asbamboo\openpayAlipay\exception\ResponseFormatException;
use asbamboo\api\exception\ApiException;

/**
 * openpay[trade.cancel]
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年11月6日
 */
class CancelAlipay implements CancelInterface
{

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\openpay\channel\v1_0\trade\CancelInterface::execute()
     */
    public function execute(Request $Request) : Response
    {
        try{
            $request_data           = [
                'app_id'            => (string) EnvHelper::get(Env::ALIPAY_APP_ID),
                'out_trade_no'      => $Request->getInTradeNo(),
            ];
            $alipay_params          = json_decode((string) $Request->getThirdPart(), true);
            if(is_array($alipay_params)){
                foreach($alipay_params AS $alipay_key => $alipay_value){
                    $request_data[$alipay_key] = $alipay_value;
                }
            }
            $AlipayResponse = Client::request('TradeClose', $request_data);
            if(     $AlipayResponse->get('code') != TradeCloseResponse::CODE_SUCCESS
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
            $Response           = new Response();
            $Response->setInTradeNo($AlipayResponse->get('out_trade_no'));
            $Response->setIsSuccess(true);
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
            Constant::CHANNEL_ALIPAY_PC     => Constant::CHANNEL_ALIPAY_PC_LABEL,
            Constant::CHANNEL_ALIPAY_QRCD   => Constant::CHANNEL_ALIPAY_QRCD_LABEL,
        ];
    }
}
